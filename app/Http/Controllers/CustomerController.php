<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataCustomer = Customer::latest()->paginate(10);
        return view('pages.customer.index', [
            'customer' => $dataCustomer
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextId = Customer::getNextId();
        return view('pages.customer.create', [
            'nextId' => $nextId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan'       => 'required|string|max:255',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_hp'                 => 'required|string|max:15',
            'email'                 => 'nullable|email|unique:customers,email',
            'alamat'                => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Customer::create($validator->validated());

        return redirect()->route('customer.index')
                         ->with('success', 'Data customer berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('pages.customer.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('pages.customer.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan'       => 'required|string|max:255',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_hp'                 => 'required|string|max:15',
            'email'                 => [
                'nullable',
                'email',
                Rule::unique('customers')->ignore($customer->id_customer, 'id_customer'),
            ],
            'alamat'                => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.edit', $customer->id_customer)
                        ->withErrors($validator)
                        ->withInput();
        }

        $customer->update($validator->validated());

        return redirect()->route('customer.index')
                         ->with('success', 'Data customer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')
                         ->with('success', 'Data customer berhasil dihapus.');
    }
}
