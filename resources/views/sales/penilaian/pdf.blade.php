<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penilaian Sales (Marketing)</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        thead th { background: #f0f0f0; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h3 class="center">Laporan Penilaian Sales (Marketing)</h3>
    <p>Nama: {{ $userName }}</p>
    <p>Periode: {{ $bulan }}/{{ $tahun }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aspek Kinerja</th>
                <th>Target</th>
                <th>Bobot</th>
                <th>Pencapaian</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Leads MBC</td>
                <td>Target {{ $targetLeadsMBC }}/bulan</td>
                <td class="center">45%</td>
                <td class="center">{{ $leadsMBC }}</td>
                <td class="center">{{ $nilaiLeadsMBC }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Leads SMI</td>
                <td>Target {{ $targetLeadsSMI }}/bulan</td>
                <td class="center">45%</td>
                <td class="center">{{ $leadsSMI }}</td>
                <td class="center">{{ $nilaiLeadsSMI }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Penilaian Atasan</td>
                <td>Input Oleh Atasan</td>
                <td class="center">10%</td>
                <td class="center">{{ $persenManual }}%</td>
                <td class="center">{{ $nilaiManualPart }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Total Nilai Akhir: {{ $totalNilai }}</h4>
</body>
</html>
