@extends('layouts.bootstrap-app')

@section('content')
    {{-- Styling Khusus Halaman Ini --}}
    <style>
        body {
            background-color: #f1f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .card-filter {
            background: #eaf4ff;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .btn-action {
            margin-right: 0.5rem;
        }

        .table thead {
            background-color: #2e86de;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>

    <div class="container py-4">
        <h3 class="mb-4 text-primary">📋 Data Mutasi Barang</h3>

        {{-- Flash Success --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filter Form --}}
        <div class="card-filter mb-4">
            <form class="row gy-2 gx-3 align-items-end" method="GET" action="{{ route('mutasi.index') }}">
                <div class="col-md-3">
                    <label class="form-label">Pencarian</label>
                    <input type="text" class="form-control" name="search" placeholder="Cari data..." value="{{ $keyword ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tgl_mulai" value="{{ $tgl_mulai ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tgl_selesai" value="{{ $tgl_selesai ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Harga Min</label>
                    <input type="number" class="form-control" name="harga_min" value="{{ $harga_min ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Harga Max</label>
                    <input type="number" class="form-control" name="harga_max" value="{{ $harga_max ?? '' }}">
                </div>
                <div class="col-md-1 d-grid">
                    <button class="btn btn-primary">Cari</button>
                </div>
                <div class="col-md-1 d-grid">
                    <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        {{-- Aksi Tambahan --}}
        <div class="mb-4">
            <a href="{{ route('mutasi.create') }}" class="btn btn-success btn-action">+ Tambah Data</a>

            <form action="{{ route('mutasi.cetak.filter') }}" method="GET" target="_blank" class="d-inline">
                @foreach (['search', 'tgl_mulai', 'tgl_selesai', 'harga_min', 'harga_max'] as $param)
                    <input type="hidden" name="search" value="{{ $keyword }}">
                    <input type="hidden" name="tgl_mulai" value="{{ $tgl_mulai }}">
                    <input type="hidden" name="tgl_selesai" value="{{ $tgl_selesai }}">
                    <input type="hidden" name="harga_min" value="{{ $harga_min }}">
                    <input type="hidden" name="harga_max" value="{{ $harga_max }}">
                @endforeach
                <button class="btn btn-outline-danger btn-action">Cetak PDF</button>
            </form>

            <form action="{{ route('mutasi.export.excel') }}" method="GET" class="d-inline">
                @foreach (['search', 'tgl_mulai', 'tgl_selesai', 'harga_min', 'harga_max'] as $param)
                    <input type="hidden" name="search" value="{{ $keyword }}">
                    <input type="hidden" name="tgl_mulai" value="{{ $tgl_mulai }}">
                    <input type="hidden" name="tgl_selesai" value="{{ $tgl_selesai }}">
                    <input type="hidden" name="harga_min" value="{{ $harga_min }}">
                    <input type="hidden" name="harga_max" value="{{ $harga_max }}">
                @endforeach
                <button class="btn btn-outline-success btn-action">Export Excel</button>
            </form>
            <br>
            <form action="{{ route('mutasi.import.excel') }}" method="POST" enctype="multipart/form-data" class="d-inline ms-2">
                @csrf
                <div class="input-group" style="max-width: 400px;">
                    <input type="file" name="file" class="form-control" required>
                    <button class="btn btn-outline-primary" type="submit">Impor Excel</button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
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
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($mutasi as $i => $m)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $m->no_transaksi }}</td>
                        <td>{{ $m->kode_barang }}</td>
                        <td>{{ $m->nama_barang }}</td>
                        <td>{{ $m->merk }}</td>
                        <td>{{ $m->tipe }}</td>
                        <td>Rp {{ number_format($m->harga_perolehan, 0, ',', '.') }}</td>
                        <td>{{ $m->asal }}</td>
                        <td>{{ $m->tujuan }}</td>
                        <td>{{ \Carbon\Carbon::parse($m->tgl_pindah)->format('d/m/Y') }}</td>
                        <td>{{ $m->keterangan }}</td>
                        <td>
                            <a href="{{ route('mutasi.edit', $m->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('mutasi.destroy', $m->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
