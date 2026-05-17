@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Modul Manajemen Partner</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Pendaftaran Partner Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.partners.store') }}" method="POST">
                @csrf {{-- Token keamanan Laravel --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Partner</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama pihak partner" required>
                </div>
                <div class="mb-3">
                    <label for="logo_url" class="form-label">URL Logo Partner</label>
                    <select name="logo_url" id="logo_url" class="form-select" required>
                        <option value="https://placehold.co/200x200">Placeholder Standard (200x200)</option>
                        <option value="https://placehold.co/300x300">Placeholder Large (300x300)</option>
                        <option value="https://placehold.co/400x200">Placeholder Wide (400x200)</option>
                    </select>
                    <small class="text-muted">Pilih dropdown atau input teks sesuai kebutuhan kuis[cite: 39].</small>
                </div>

                <button type="submit" class="btn btn-success">Simpan Partner</button>
            </form>
        </div>
    </div>
    <h4 class="mb-3">Daftar Partner yang Mendukung</h4>
    <div class="row">
        @foreach($partners as $partner)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 text-center shadow-sm p-3">
                    <img src="{{ $partner->logo_url }}" class="card-img-top img-fluid mx-auto" alt="{{ $partner->name }}" style="max-width: 150px; height: 150px; object-fit: cover;">
                    <div class="card-body p-2">
                        <h5 class="card-title text-truncate mt-2">{{ $partner->name }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection