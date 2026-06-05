<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryPenjualan;
use App\Models\Kelas;

class HistoryPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = \Validator::make($request->all(), [
                'kelas_id' => 'required|exists:kelas,id',
                'bulan' => 'required|integer|min:1|max:12',
                'tahun' => 'required|integer|min:2000|max:2100',
                'omset' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $kelasId = $request->kelas_id;

            $exists = HistoryPenjualan::where('user_id', auth()->id())
                ->where('kelas_id', $kelasId)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->first();

            if ($exists) {
                $exists->update([
                    'omset' => $request->omset,
                    'keterangan' => $request->keterangan
                ]);
                
                $kelas = Kelas::find($kelasId);

                return response()->json([
                    'success' => true,
                    'message' => 'Riwayat penjualan berhasil diperbarui.',
                    'data' => [
                        'id' => $exists->id,
                        'kelas_id' => $exists->kelas_id,
                        'kelas_nama' => $kelas ? $kelas->nama_kelas : 'Produk Terhapus',
                        'bulan' => $exists->bulan,
                        'tahun' => $exists->tahun,
                        'omset' => $exists->omset,
                        'keterangan' => $exists->keterangan ?? '-',
                        'formatted_omset' => 'Rp' . number_format($exists->omset, 0, ',', '.'),
                        'formatted_date' => \Carbon\Carbon::create()->month($exists->bulan)->translatedFormat('F') . ' ' . $exists->tahun
                    ]
                ]);
            }

            $history = HistoryPenjualan::create([
                'user_id' => auth()->id(),
                'kelas_id' => $kelasId,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'omset' => $request->omset,
                'keterangan' => $request->keterangan,
            ]);
            
            $kelas = Kelas::find($kelasId);

            return response()->json([
                'success' => true,
                'message' => 'Riwayat penjualan berhasil ditambahkan.',
                'data' => [
                    'id' => $history->id,
                    'kelas_id' => $history->kelas_id,
                    'kelas_nama' => $kelas ? $kelas->nama_kelas : 'Produk Terhapus',
                    'bulan' => $history->bulan,
                    'tahun' => $history->tahun,
                    'omset' => $history->omset,
                    'keterangan' => $history->keterangan ?? '-',
                    'formatted_omset' => 'Rp' . number_format($history->omset, 0, ',', '.'),
                    'formatted_date' => \Carbon\Carbon::create()->month($history->bulan)->translatedFormat('F') . ' ' . $history->tahun
                ]
            ]);
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'omset' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $exists = HistoryPenjualan::where('user_id', auth()->id())
            ->where('kelas_id', $request->kelas_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Riwayat penjualan untuk produk, bulan, dan tahun ini sudah ada.');
        }

        HistoryPenjualan::create([
            'user_id' => auth()->id(),
            'kelas_id' => $request->kelas_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'omset' => $request->omset,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Riwayat penjualan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = \Validator::make($request->all(), [
                'kelas_id' => 'required|exists:kelas,id',
                'bulan' => 'required|integer|min:1|max:12',
                'tahun' => 'required|integer|min:2000|max:2100',
                'omset' => 'required|numeric|min:0',
                'keterangan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $history = HistoryPenjualan::where('user_id', auth()->id())->findOrFail($id);

            $duplicate = HistoryPenjualan::where('user_id', auth()->id())
                ->where('kelas_id', $request->kelas_id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->where('id', '!=', $id)
                ->first();

            if ($duplicate) {
                return response()->json(['success' => false, 'message' => 'Riwayat penjualan untuk produk, bulan, dan tahun ini sudah ada.'], 422);
            }

            $history->update([
                'kelas_id' => $request->kelas_id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'omset' => $request->omset,
                'keterangan' => $request->keterangan,
            ]);

            $kelas = Kelas::find($request->kelas_id);

            return response()->json([
                'success' => true,
                'message' => 'Riwayat penjualan berhasil diperbarui.',
                'data' => [
                    'id' => $history->id,
                    'kelas_id' => $history->kelas_id,
                    'kelas_nama' => $kelas ? $kelas->nama_kelas : 'Produk Terhapus',
                    'bulan' => $history->bulan,
                    'tahun' => $history->tahun,
                    'omset' => $history->omset,
                    'keterangan' => $history->keterangan ?? '-',
                    'formatted_omset' => 'Rp' . number_format($history->omset, 0, ',', '.'),
                    'formatted_date' => \Carbon\Carbon::create()->month($history->bulan)->translatedFormat('F') . ' ' . $history->tahun
                ]
            ]);
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'omset' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $history = HistoryPenjualan::where('user_id', auth()->id())->findOrFail($id);

        $duplicate = HistoryPenjualan::where('user_id', auth()->id())
            ->where('kelas_id', $request->kelas_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($duplicate) {
            return redirect()->back()->with('error', 'Riwayat penjualan untuk produk, bulan, dan tahun ini sudah ada.');
        }

        $history->update([
            'kelas_id' => $request->kelas_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'omset' => $request->omset,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Riwayat penjualan berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $history = HistoryPenjualan::where('user_id', auth()->id())->findOrFail($id);
        $history->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Riwayat penjualan berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Riwayat penjualan berhasil dihapus.');
    }
}
