<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user(); 

        return view('pages.profile.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nik' => [
                'required',
                'string',
                Rule::unique('users')->ignore($user->id),
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('users')->ignore($user->id),
            ],
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|string|max:15',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToUpdate = $validator->validated();

        if ( $request->filled('password') ) {
            $dataToUpdate['password'] = Hash::make($request->password);
        } else {
            unset($dataToUpdate['password']);
        }
        
        $user->update($dataToUpdate);

        return redirect()->route('profile.edit')
                         ->with('success', 'Profile berhasil diperbarui.');
    }
}
