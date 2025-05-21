@extends('member.app')

@section('content')
    <div class="container my-5">
        <h3 class="mb-4">Daftar Produk</h3>
        <div class="row g-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            @foreach ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $product->image }}" class="card-img-top" alt="Produk">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-success fw-bold">{{ number_format($product->price, 0, ',', '.') }}</p>
                        <form action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary mt-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 7a.5.5 0 0 0-.5.5V9H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V10H10a.5.5 0 0 0 0-1H8.5V7.5A.5.5 0 0 0 8 7z" />
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 13H4a.5.5 0 0 1-.49-.402L1.61 2H.5a.5.5 0 0 1-.5-.5zM3.14 6l1.25 5h8.22l1.25-5H3.14z" />
                            </svg>
                            Tambah ke Keranjang
                        </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
