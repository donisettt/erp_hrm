<?php

namespace App\Http\Controllers;

use App\Models\Spbu;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SpbuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSpbu = Spbu::with('customer')->latest()->paginate(10);

        return view('pages.spbu.index', [
            'spbu' => $dataSpbu
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('nama_perusahaan')->get();

        return view('pages.spbu.create', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_spbu'         => 'required|string|unique:spbu,no_spbu|max:50',
            'manajer'         => 'required|string|max:255',
            'nama_lokasi'     => 'required|string|max:255',
            'no_hp'           => 'required|string|max:15',
            'alamat'          => 'required|string',
            'jam_operasional' => 'nullable|string|max:50',
            'customer_id'     => 'required|string|exists:customers,id_customer', // Validasi Foreign Key
        ]);

        if ($validator->fails()) {
            return redirect()->route('spbu.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Spbu::create($validator->validated());

        return redirect()->route('spbu.index')
                         ->with('success', 'Data SPBU berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Spbu $spbu)
    {
        $spbu->load('customer');
        return view('pages.spbu.show', [
            'spbu' => $spbu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spbu $spbu)
    {
        $customers = Customer::orderBy('nama_perusahaan')->get();

        return view('pages.spbu.edit', [
            'spbu' => $spbu,
            'customers' => $customers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spbu $spbu)
    {
        $validator = Validator::make($request->all(), [
            'no_spbu' => [
                'required',
                'string',
                'max:50',
                Rule::unique('spbu')->ignore($spbu->id), // Abaikan ID SPBU saat ini
            ],
            'manajer'         => 'required|string|max:255',
            'nama_lokasi'     => 'required|string|max:255',
            'no_hp'           => 'required|string|max:15',
            'alamat'          => 'required|string',
            'jam_operasional' => 'nullable|string|max:50',
            'customer_id'     => 'required|string|exists:customers,id_customer',
        ]);

        if ($validator->fails()) {
            return redirect()->route('spbu.edit', $spbu->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $spbu->update($validator->validated());

        return redirect()->route('spbu.index')
                         ->with('success', 'Data SPBU berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spbu $spbu)
    {
        $spbu->delete();
        return redirect()->route('spbu.index')
                         ->with('success', 'Data SPBU berhasil dihapus.');
    }
}
