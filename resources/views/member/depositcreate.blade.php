@extends('member.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Deposit') }}</div>

                <div class="card-body">
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
                        <h5 class="card-title mb-3">Masukkan Jumlah Deposit</h5>
                          
                        <form action="{{ route('member.deposit.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jumlahDeposit" class="form-label">Jumlah Deposit (Rp)</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Contoh: 1000000" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">
                                Simpan Deposit
                            </button>
                        </form>
                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
