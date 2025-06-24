@extends('layouts.bootstrap-app')

@section('content')
<style>
    body {
        background-color: #f1f6f9;
        font-family: 'Poppins', sans-serif;
    }

    .form-wrapper {
        background: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }
</style>

<div class="container py-4">
    <h3 class="mb-4 text-primary">✏️ Edit Data Mutasi Barang</h3>

    <div class="form-wrapper">
        <form method="POST" action="{{ route('mutasi.update', $mutasi->id) }}">
            @csrf
            @method('PUT')
            @include('mutasi._form', ['submit' => 'Perbarui'])
        </form>
    </div>
</div>
@endsection
