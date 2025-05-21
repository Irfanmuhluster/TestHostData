@extends('member.app')

@section('content')
<div class="container my-5">
  <div class="card shadow">
    <div class="card-body text-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="green" class="bi bi-check-circle-fill mb-3" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.439 5.53 7.47a.75.75 0 0 0-1.06 1.06l2.5 2.5z"/>
      </svg>
      <h3 class="text-success">Transaksi Berhasil!</h3>
      <p class="mb-4">Terima kasih, {{ $transactions->user->name }}. Berikut adalah detail transaksi Anda:</p>

      <table class="table table-bordered w-75 mx-auto">
        <tr>
          <th>No. Transaksi</th>
          <td>{{ $transactions->id }}</td>
        </tr>
        <tr>
          <th>Total Pembayaran</th>
          <td>Rp {{ number_format($transactions->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <th>Tanggal</th>
          <td>{{ $transactions->created_at }}</td>
        </tr>
      </table>

      <div class="mt-4">
        <a href="{{ route('member.product') }}" class="btn btn-secondary me-2">Kembali ke Beranda</a>
       
      </div>
    </div>
  </div>
</div>
@endsection
