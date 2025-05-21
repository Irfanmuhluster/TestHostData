@extends('member.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <form action="{{ route('member.deposit.proceed') }}" method="POST">
                            @csrf
                            <input type="hidden" name="deposit_id" value="{{ $deposit->id }}">

                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                @foreach($paymentMethods as $method)
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="form-check w-100">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="paymentMethod" 
                                                    value="{{ $method['paymentMethod'] }}" 
                                                    id="method_{{ $method['paymentMethod'] }}" 
                                                    required
                                                >
                                                <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="method_{{ $method['paymentMethod'] }}">
                                                    <div>
                                                        <strong>{{ $method['paymentName'] }}</strong><br>
                                                        <small>Fee: {{ number_format($method['totalFee']) }} </small>
                                                    </div>
                                                    @if(isset($method['paymentImage']))
                                                    <img src="{{ $method['paymentImage'] }}" alt="{{ $method['paymentName'] }}" width="50">
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Lanjut ke Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


