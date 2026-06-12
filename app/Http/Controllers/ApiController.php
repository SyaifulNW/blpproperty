<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function googleFormWebhook(Request $request)
    {
        try {

            $payload = $request->json()->all();
            if (empty($payload)) {
                $payload = $request->all();
            }

            Log::info("PAYLOAD", $payload);
            
            

            $nama        = $payload['nama'] ?? null;
            $noWa        = $payload['no_wa'] ?? null;
            $jenisProduk = $payload['jenis_produk'] ?? null;
            $sumberLeads = $payload['sumber_leads'] ?? 'Mandiri';
            $source      = $payload['source'] ?? 'google_form';
            $sales       = $payload['sales'] ?? null;

            if (!$nama || !$noWa) {
                return response()->json([
                    'success' => false,
                    'message' => 'nama & no_wa wajib'
                ], 422);
            }

            // Normalisasi WA
            $noWa = preg_replace('/[^0-9]/', '', $noWa);
            if (substr($noWa, 0, 1) == '0') {
                $noWa = '62' . substr($noWa, 1);
            }

            // Cek duplicate
            $cek = DB::table('data')
                ->where('no_wa', $noWa)
                ->first();

            if ($cek) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate'
                ], 200);
            }

            // Cari kelas
            $kelasId = null;
            if ($jenisProduk) {
                $kelas = DB::table('produk')
                    ->where('nama_kelas', 'LIKE', '%' . $jenisProduk . '%')
                    ->first();

                $kelasId = $kelas ? $kelas->id : null;
            }

            // 🔥 TANPA FIELD BERISIKO
            $data = [
                'nama'           => $nama,
                'no_wa'          => $noWa,
                'leads' => $sumberLeads,
                'leads_custom'   => 'Google Form - ' . $source,
                'status_peserta' => 'peserta_baru',
                'kelas_id'       => $kelasId,
                'status'         => 'Cold',

                // aman
                'created_by'     => $sales ? ucfirst($sales) : 'blpproperty',
                'created_by_role'=> 'sales',

                'spin_b'         => 'Tidak',
                'spin_a'         => 'Tidak',
                'spin_t'         => 'Tidak',
                'survei_lokasi'  => 'Tidak',

                'spin1_wa'       => 0,
                'spin1_telp'     => 0,
                'spin2_wa'       => 0,
                'spin2_telp'     => 0,
                'spin3_wa'       => 0,
                'spin3_telp'     => 0,
                'spin4_wa'       => 0,
                'spin4_telp'     => 0,
                'spin5_wa'       => 0,
                'spin5_telp'     => 0,

                'created_at'     => now(),
                'updated_at'     => now(),
            ];

            Log::info("INSERT DATA", $data);

            $id = DB::table('data')->insertGetId($data);

            return response()->json([
                'success' => true,
                'id' => $id
            ], 201);

        } catch (\Throwable $e) {

            Log::error("ERROR API", [
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}