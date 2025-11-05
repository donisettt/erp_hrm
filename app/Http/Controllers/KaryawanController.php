<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKaryawan = Karyawan::latest()->paginate(10);

        return view('pages.karyawan.index', [
            'karyawan' => $dataKaryawan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // app/Http/Controllers/TeknisiController.php

    public function create()
    {
        $nextId = Karyawan::getNextId();

        return view('pages.karyawan.create', [
            'nextId' => $nextId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_ktp' => 'required|string|unique:karyawan,no_ktp|max:20',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'nullable|email|unique:karyawan,email',
            'alamat' => 'nullable|string',
            'upah_harian' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('karyawan.create')->withErrors($validator)->withInput();
        }

        Karyawan::create($validator->validated());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return view('pages.karyawan.show', [
            'karyawan' => $karyawan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return view('pages.karyawan.edit', [
            'karyawan' => $karyawan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validator = Validator::make($request->all(), [
            'no_ktp' => ['required', 'string', 'max:20', Rule::unique('karyawan')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => ['nullable', 'email', Rule::unique('karyawan')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'alamat' => 'nullable|string',
            'upah_harian' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('karyawan.edit', $karyawan->id_karyawan)->withErrors($validator)->withInput();
        }

        $karyawan->update($validator->validated());

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')
                        ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
