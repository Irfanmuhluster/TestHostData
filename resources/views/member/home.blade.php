@extends('member.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                  @if (session('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          {{ session('success') }}
                          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>
                    @endif
                   @if (session('error'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          {{ session('error') }}
                          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>
                  @endif

                    <div>
                      <h5 class="card-title mb-1">Saldo Anda saat ini</h5>
                      <h2 class="fw-bold text-primary">Rp. {{ number_format($user->balance, 0, ',', '.') }}</h2>
                    </div>
                    <a href="{{ route('member.deposit.create') }}" class="btn btn-primary d-flex align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 1a6 6 0 1 1 0 12A6 6 0 0 1 8 2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5A.5.5 0 0 1 8 4z"/>
                      </svg>
                      Tambah Deposit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
