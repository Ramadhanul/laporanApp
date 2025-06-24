@extends('layouts.bootstrap-app')

@section('content')
    {{-- Tambahkan styling agar seperti publik --}}
    <style>
        body {
            background-color: #f1f6f9;
            font-family: 'Poppins', sans-serif;
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

    {{-- Konten Dashboard --}}
    <div class="container my-4">
        <h3 class="mb-4 text-primary">Dashboard Mutasi Barang (Admin)</h3>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4>Total Mutasi Barang</h4>
                    <p>{{ $totalMutasi }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <h4>Mutasi Bulan Ini</h4>
                    <p>{{ $bulanIni }}</p>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <h5 class="text-primary mb-3">Grafik Mutasi per Bulan</h5>
            <canvas id="chartMutasi" height="100"></canvas>
        </div>
    </div>

    {{-- Script Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartMutasi');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($perBulan->pluck('bulan')) !!},
                datasets: [{
                    label: 'Jumlah Mutasi per Bulan',
                    data: {!! json_encode($perBulan->pluck('total')) !!},
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
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endsection
