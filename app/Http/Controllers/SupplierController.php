<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSupplier = Supplier::latest()->paginate(10);
        
        return view('pages.supplier.index', [
            'supplier' => $dataSupplier
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = Supplier::getNextId();
        return view('pages.supplier.create', [
            'nextId' => $nextId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'no_hp'     => 'required|string|max:15',
            'email'     => 'nullable|email|unique:suppliers,email',
            'alamat'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('supplier.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Supplier::create($validator->validated());

        return redirect()->route('supplier.index')
                         ->with('success', 'Data supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('pages.supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'no_hp'     => 'required|string|max:15',
            'email'     => [
                'nullable',
                'email',
                Rule::unique('suppliers')->ignore($supplier->id_supplier, 'id_supplier'),
            ],
            'alamat'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('supplier.edit', $supplier->id_supplier)
                        ->withErrors($validator)
                        ->withInput();
        }

        $supplier->update($validator->validated());

        return redirect()->route('supplier.index')
                         ->with('success', 'Data supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')
                         ->with('success', 'Data supplier berhasil dihapus.');
    }
}
