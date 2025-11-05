<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Customer;
use App\Models\Spbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataProyek = Proyek::with('customer', 'spbu')->latest()->paginate(10);

        return view('pages.proyek.index', [
            'proyek' => $dataProyek,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('nama_perusahaan')->get();

        $spbus = [];
        if (old('customer_id')) {
            $spbus = Spbu::where('customer_id', old('customer_id'))->get();
        }

        return view('pages.proyek.create', [
            'customers' => $customers,
            'spbus' => $spbus,
        ]);
    }

    public function getNextProyekId(Request $request)
    {
        $customerId = $request->query('customer_id');
        if (!$customerId) {
            return response()->json(['error' => 'Customer ID diperlukan'], 400);
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            return response()->json(['error' => 'Customer tidak ditemukan'], 404);
        }

        $nextId = Proyek::generateNextId($customer);

        return response()->json(['nextId' => $nextId]);
    }

    public function getSpbuByCustomer(Request $request)
    {
        $customerId = $request->query('customer_id');
        if (!$customerId) {
            return response()->json([], 400);
        }

        $spbus = Spbu::where('customer_id', $customerId)->select('id', 'no_spbu', 'nama_lokasi')->orderBy('no_spbu')->get();

        return response()->json($spbus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|string|exists:customers,id_customer',
            'spbu_id' => 'required|integer|exists:spbu,id',
            'invoice' => 'nullable|string|max:50',
            'nama_proyek' => 'required|string|max:255',
            'harga_borongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->route('proyek.create')->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $customer = Customer::find($validatedData['customer_id']);
        $newProyekId = Proyek::generateNextId($customer);

        $prefix = strtoupper(substr(preg_replace('/^(PT|CV)\.?\s*/i', '', $customer->nama_perusahaan), 0, 3));

        $lastInvoice = Proyek::where('invoice', 'like', "INV/{$prefix}/%")
            ->orderBy('invoice', 'desc')
            ->value('invoice');

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $monthYear = date('mY');

        $validatedData['id_proyek'] = $newProyekId;
        $validatedData['invoice'] = "HRM/{$prefix}/{$monthYear}/{$nextNumber}";

        Proyek::create($validatedData);

        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyek $proyek)
    {
        $proyek->load('customer', 'spbu');
        return view('pages.proyek.show', [
            'proyek' => $proyek,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyek $proyek)
    {
        $customers = Customer::orderBy('nama_perusahaan')->get();

        $customerId = old('customer_id', $proyek->customer_id);
        $spbus = Spbu::where('customer_id', $customerId)->get();

        return view('pages.proyek.edit', [
            'proyek' => $proyek,
            'customers' => $customers,
            'spbus' => $spbus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyek $proyek)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|string|exists:customers,id_customer',
            'spbu_id' => 'required|integer|exists:spbu,id',
            'invoice' => 'required|string|max:50',
            'nama_proyek' => 'required|string|max:255',
            'harga_borongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->route('proyek.edit', $proyek->id_proyek)->withErrors($validator)->withInput();
        }

        $proyek->update($validator->validated());

        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function printPdf(Proyek $proyek)
    {
        $proyek->load('customer', 'spbu');
        $pdf = PDF::loadView('pages.proyek.pdf', ['proyek' => $proyek]);
        return $pdf->stream('struk-proyek-' . $proyek->id_proyek . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();
        return redirect()->route('proyek.index')->with('success', 'Data proyek berhasil dihapus.');
    }
}
