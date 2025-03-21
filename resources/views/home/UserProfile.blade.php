@extends('master.main')
@section('title', 'Hồ sơ người dùng')
@section('main')

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group shadow-lg rounded-3 overflow-hidden">
                <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i> Hồ Sơ
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-wallet2 me-2"></i> Ví tiền
                </a>
                <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-card-list me-2"></i> Đơn Hàng
                </a>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient bg-primary text-white text-center py-3 rounded-top">
                    <h2 class="mb-0"><i class="bi bi-person-lines-fill"></i> Hồ sơ của tôi</h2>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="https://via.placeholder.com/150" class="rounded-circle img-fluid border p-2 shadow" alt="User Avatar">
                            <h4 class="mt-3 text-primary fw-bold">{{ $user->fullname }}</h4>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-hover table-bordered rounded-3 overflow-hidden">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-envelope-fill text-primary me-2"></i> Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-telephone-fill text-success me-2"></i> Số điện thoại:</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Địa chỉ:</th>
                                        <td>{{ $user->address }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-gender-ambiguous text-info me-2"></i> Giới tính:</th>
                                        <td>{{ $user->gender }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-person-badge-fill text-warning me-2"></i> Vai trò:</th>
                                        <td>{{ $user->role }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
