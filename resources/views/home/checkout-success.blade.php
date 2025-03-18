@extends('master.main')
@section('title', 'Đặt hàng thành công')
@section('main')
    <main>
        <div class="container text-center">
            <h2 class="text-success my-4">Đặt hàng thành công!</h2>
            <p>Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    </main>
@endsection
