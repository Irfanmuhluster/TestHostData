@extends('member.app')

@section('content')
    <div class="container my-5">
        <h3 class="mb-4">Keranjang</h3>
        <div class="card">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Kuantitas</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subTotal = 0; @endphp
                            @foreach ($cartItems as $index => $item)
                                @php $itemTotal = $item->product->price * $item->quantity; @endphp
                                @php $subTotal += $itemTotal; @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1" class="form-control form-control-sm"
                                                style="width: 80px; display: inline-block;">
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th colspan="2">Rp {{ number_format($subTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cartItems" value="{{ json_encode($cartItems) }}">
                        <button type="submit" class="btn btn-success mt-3">Beli</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
