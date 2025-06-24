<div class="row g-3">
    <div class="col-md-6">
        <label>No Transaksi</label>
        <input type="text" name="no_transaksi" value="{{ old('no_transaksi', $mutasi->no_transaksi ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Kode Barang</label>
        <input type="text" name="kode_barang" value="{{ old('kode_barang', $mutasi->kode_barang ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" value="{{ old('nama_barang', $mutasi->nama_barang ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Merk</label>
        <input type="text" name="merk" value="{{ old('merk', $mutasi->merk ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Tipe</label>
        <input type="text" name="tipe" value="{{ old('tipe', $mutasi->tipe ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Harga Perolehan</label>
        <input type="number" step="0.01" name="harga_perolehan" value="{{ old('harga_perolehan', $mutasi->harga_perolehan ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Asal</label>
        <input type="text" name="asal" value="{{ old('asal', $mutasi->asal ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Tujuan</label>
        <input type="text" name="tujuan" value="{{ old('tujuan', $mutasi->tujuan ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Tanggal Pindah</label>
        <input type="date" name="tgl_pindah" value="{{ old('tgl_pindah', $mutasi->tgl_pindah ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Keterangan</label>
        <input type="text" name="keterangan" value="{{ old('keterangan', $mutasi->keterangan ?? '') }}" class="form-control">
    </div>
    <div class="col-12 mt-4 d-flex justify-content-between">
        <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">← Kembali</a>
        <button class="btn btn-primary" type="submit">{{ $submit }}</button>
    </div>

</div>
