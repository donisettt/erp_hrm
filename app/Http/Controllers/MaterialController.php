<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataMaterial = Material::with('supplier')->latest()->paginate(10);

        return view('pages.material.index', [
            'material' => $dataMaterial
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = Material::getNextId();
        $suppliers = Supplier::orderBy('nama')->get();

        return view('pages.material.create', [
            'nextId' => $nextId,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'supplier_id'   => 'required|string|exists:suppliers,id_supplier',
            'satuan'        => 'required|string|max:50',
            'harga_satuan'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('material.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Material::create($validator->validated());

        return redirect()->route('material.index')
                         ->with('success', 'Data material berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $material->load('supplier');
        return view('pages.material.show', [
            'material' => $material
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $suppliers = Supplier::orderBy('nama')->get();
        return view('pages.material.edit', [
            'material' => $material,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'supplier_id'   => 'required|string|exists:suppliers,id_supplier',
            'satuan'        => 'required|string|max:50',
            'harga_satuan'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('material.edit', $material->id_material)
                        ->withErrors($validator)
                        ->withInput();
        }

        $material->update($validator->validated());

        return redirect()->route('material.index')
                         ->with('success', 'Data material berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('material.index')
                         ->with('success', 'Data material berhasil dihapus.');
    }
}
