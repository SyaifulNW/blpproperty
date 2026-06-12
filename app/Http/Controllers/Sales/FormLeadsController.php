<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Data;
use App\Models\LeadSource;
use App\Models\User;

class FormLeadsController extends Controller
{
    /**
     * Show the public Google Forms-styled leads form.
     */
    public function show(Request $request)
    {
        $salesName = $request->query('sales');
        
        // Fetch all products (kelas) and lead sources
        $products = Produk::orderBy('nama_kelas')->get();
        $leadSources = LeadSource::orderBy('name')->get();

        return view('public.form-leads', [
            'salesName' => $salesName,
            'products' => $products,
            'leadSources' => $leadSources
        ]);
    }

    /**
     * Handle the form submission and save lead to database.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:50',
            'leads' => 'required|string|max:255',
            'kelas_id' => 'required|exists:produk,id',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi.',
            'no_wa.required' => 'No Whatsapp wajib diisi.',
            'leads.required' => 'Sumber Leads wajib diisi.',
            'kelas_id.required' => 'Jenis Produk wajib diisi.',
            'kelas_id.exists' => 'Jenis Produk tidak valid.',
        ]);

        $data = new Data();
        $data->nama = $request->input('nama');
        $data->no_wa = $request->input('no_wa');
        $data->leads = $request->input('leads');
        $data->kelas_id = $request->input('kelas_id');
        $data->status_peserta = 'peserta_baru';

        // Initialize default empty fields expected in database
        $data->leads_custom = '';
        $data->provinsi_id = '';
        $data->provinsi_nama = '';
        $data->kota_id = '';
        $data->kota_nama = '';
        $data->jenisbisnis = '';
        $data->nama_bisnis = '';
        $data->situasi_bisnis = '';
        $data->kendala = '';

        // Resolve sales user to assign created_by & role
        $salesName = $request->input('sales');
        $salesUser = User::where('name', $salesName)->first();

        if ($salesUser) {
            $data->created_by = $salesUser->name;
            $data->created_by_role = $salesUser->role;
        } else {
            $data->created_by = $salesName ?: 'System';
            $data->created_by_role = 'cs';
        }

        $data->save();

        return view('public.form-success', [
            'salesName' => $salesName
        ]);
    }
}
