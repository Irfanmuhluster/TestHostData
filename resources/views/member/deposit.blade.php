@extends('member.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Deposit') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12 p-5">
                            <h1>
                                <b>Rp. 26000</b>
                            </h1>
                        </div>
                        <div class="col-md-6 col-sm-12 p-5">
                            <a href="{{ route('member.deposit.create') }}" class="btn btn-primary">Deposit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
