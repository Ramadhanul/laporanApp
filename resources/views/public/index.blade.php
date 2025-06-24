<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mutasi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1f6f9;
            font-family: 'Poppins', sans-serif;
        }

        header {
            background-color: #2e86de;
            padding: 1rem 2rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 400;
        }

        header nav a:hover,
        header nav a.active {
            font-weight: 600;
            text-decoration: underline;
        }

        .stat-card {
            border-left: 6px solid #2e86de;
            background: #ffffff;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .stat-card h4 {
            font-size: 1.25rem;
            color: #2e86de;
        }

        .stat-card p {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

{{-- NAV --}}
<header>
    <div style="font-size: 1.5rem; font-weight: bold;">
        🏥 RUMAH SAKIT
    </div>
    <nav>
        <a href="{{ route('public.index') }}" class="{{ request()->is('public') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('public.data') }}" class="{{ request()->is('public/data') ? 'active' : '' }}">Data</a>
        <a href="{{ route('public.chatbot') }}" class="{{ request()->is('public/chatbot') ? 'active' : '' }}">Chatbot</a>
    </nav>
</header>

<div class="container my-4">
    <h3 class="mb-4 text-primary">Dashboard Mutasi Barang</h3>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="stat-card">
                <h4>Total Mutasi Barang</h4>
                <p>{{ $total }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <h4>Mutasi Bulan Ini</h4>
                <p>{{ $bulan_ini }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="chart-container">
        <h5 class="text-primary mb-3">Grafik Mutasi per Bulan</h5>
        <canvas id="chartMutasi" height="100"></canvas>
    </div>
</div>

{{-- Script --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartMutasi');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(
                \App\Models\MutasiBarang::selectRaw("DATE_FORMAT(tgl_pindah, '%Y-%m') as bulan")
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->pluck('bulan')
            ) !!},
            datasets: [{
                label: 'Jumlah Mutasi',
                data: {!! json_encode(
                    \App\Models\MutasiBarang::selectRaw("DATE_FORMAT(tgl_pindah, '%Y-%m') as bulan, COUNT(*) as total")
                        ->groupBy('bulan')
                        ->orderBy('bulan')
                        ->pluck('total')
                ) !!},
                backgroundColor: '#2e86de',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</body>
</html>
