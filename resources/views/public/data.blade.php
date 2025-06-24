<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mutasi Barang - Publik</title>
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

        .section-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .table thead {
            background-color: #2e86de;
            color: white;
        }

        .card-filter {
            background: #eaf4ff;
            padding: 1rem 1.5rem;
            border-radius: 12px;
        }

        .btn-action {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>

{{-- NAV --}}
<header>
    <div style="font-size: 1.5rem; font-weight: bold;" class="d-flex align-items-center">
        <img src="{{ asset('img/logoyarsi.png') }}" alt="Logo RS" height="36" class="me-2">
        MUTASI BARANG YARSISUMBAR
    </div>
    <nav>
        <a href="{{ route('public.index') }}" class="{{ request()->is('public') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('public.data') }}" class="{{ request()->is('public/data') ? 'active' : '' }}">Data</a>
        <a href="{{ route('public.chatbot') }}" class="{{ request()->is('public/chatbot') ? 'active' : '' }}">Chatbot</a>
    </nav>
</header>

<div class="container my-4">
    <h3 class="mb-4 text-primary">Data Mutasi Barang</h3>

    {{-- Filter --}}
    <div class="card-filter mb-4">
        <form method="GET" action="{{ route('public.data') }}" class="row gy-2 gx-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Pencarian</label>
                <input type="text" name="search" value="{{ $keyword }}" placeholder="Cari" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ $tgl_mulai }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="{{ $tgl_selesai }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga Min</label>
                <input type="number" name="harga_min" value="{{ $harga_min }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga Max</label>
                <input type="number" name="harga_max" value="{{ $harga_max }}" class="form-control">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-primary">Cari</button>
            </div>
            <div class="col-md-1 d-grid">
                <a href="{{ route('public.data') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    {{-- Export Buttons --}}
    <div class="mb-3">
        <form action="{{ route('public.cetak.pdf') }}" method="GET" class="d-inline">
            <input type="hidden" name="search" value="{{ $keyword }}">
            <input type="hidden" name="tgl_mulai" value="{{ $tgl_mulai }}">
            <input type="hidden" name="tgl_selesai" value="{{ $tgl_selesai }}">
            <input type="hidden" name="harga_min" value="{{ $harga_min }}">
            <input type="hidden" name="harga_max" value="{{ $harga_max }}">
            <button class="btn btn-danger btn-action">Cetak PDF</button>
        </form>

        <form action="{{ route('public.export.excel') }}" method="GET" class="d-inline">
            <input type="hidden" name="search" value="{{ $keyword }}">
            <input type="hidden" name="tgl_mulai" value="{{ $tgl_mulai }}">
            <input type="hidden" name="tgl_selesai" value="{{ $tgl_selesai }}">
            <input type="hidden" name="harga_min" value="{{ $harga_min }}">
            <input type="hidden" name="harga_max" value="{{ $harga_max }}">
            <button class="btn btn-success btn-action">Export Excel</button>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Harga Perolehan</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tgl Pindah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>{{ $item->no_transaksi }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->merk }}</td>
                    <td>{{ $item->tipe }}</td>
                    <td>Rp {{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                    <td>{{ $item->asal }}</td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pindah)->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $data->withQueryString()->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
