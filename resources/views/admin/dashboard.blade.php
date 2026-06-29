@extends('layouts.adminlte4.main')

@section('header')
    Panel Admin
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-4">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted text-uppercase small fw-bold mb-1">Total Pengguna</p>
                        <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 me-4">
                        <i class="bi bi-bookmark fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted text-uppercase small fw-bold mb-1">Total Film Disimpan</p>
                        <h2 class="fw-bold mb-0">{{ $totalWatchlists }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title fw-bold mb-0">Manajemen Pengguna</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold text-uppercase small text-muted">No</th>
                            <th class="fw-bold text-uppercase small text-muted">Nama</th>
                            <th class="d-none d-sm-table-cell fw-bold text-uppercase small text-muted">Email</th>
                            <th class="d-none d-md-table-cell fw-bold text-uppercase small text-muted">Bergabung</th>
                            <th class="fw-bold text-uppercase small text-muted text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $user->name }}</td>
                                <td class="d-none d-sm-table-cell">{{ $user->email }}</td>
                                <td class="d-none d-md-table-cell text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Anda yakin ingin menghapus akun {{ $user->name }} secara permanen? Semua data watchlist milik user ini juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    Belum ada pengguna lain yang terdaftar selain Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
