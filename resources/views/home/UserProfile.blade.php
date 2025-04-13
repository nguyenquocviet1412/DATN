@extends('master.main')
@section('title', 'Hồ sơ người dùng')
@section('main')
<!-- breadcrumb area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active"><a href="{{route('user.profile')}}">Tài khoản</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-gradient text-white text-center py-4 rounded-top" style="background-color: #b38b59;">
            <h2 class="mb-0"><i class="bi bi-person-lines-fill"></i> Thông Tin Hồ Sơ</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="list-group shadow-sm rounded-3 overflow-hidden">
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action active d-flex align-items-center" style="background-color: #b38b59; border-color: #b38b59;">
                            <i class="bi bi-person-circle me-2"></i> Hồ Sơ
                        </a>
                        <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-card-list me-2"></i> Đơn Hàng
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-center">
                            <img src="https://via.placeholder.com/150" class="rounded-circle img-fluid border p-2 shadow" alt="User Avatar">
                            <h4 class="mt-3 fw-bold" style="color: #b38b59;">{{ $user->fullname }}</h4>
                            <p class="text-muted">Thành viên từ {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="alert alert-info shadow-sm" role="alert">
                                <i class="bi bi-info-circle me-2"></i>Thông tin cá nhân của bạn được bảo mật và chỉ hiển thị cho bạn.
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header text-white" style="background-color: #b38b59;">
                            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i> Chi Tiết Hồ Sơ</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered rounded-3 overflow-hidden">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-gender-ambiguous me-2" style="color: #b38b59;"></i> Giới tính:</th>
                                        <td>
                                            @if($user->gender === 'Male')
                                                Nam
                                            @elseif($user->gender === 'Female')
                                                Nữ
                                            @else
                                                Khác
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-calendar-event me-2" style="color: #b38b59;"></i> Sinh nhật:</th>
                                        <td>{{ \Carbon\Carbon::parse($user->birthday)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-envelope-fill me-2" style="color: #b38b59;"></i> Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-telephone-fill me-2" style="color: #b38b59;"></i> Số điện thoại:</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-geo-alt-fill me-2" style="color: #b38b59;"></i> Địa chỉ:</th>
                                        <td>{{ $user->address }}</td>
                                    </tr>
<tr>
                                        <th scope="row" class="bg-light"><i class="bi bi-gender-ambiguous me-2" style="color: #b38b59;"></i> Giới tính:</th>
                                        <td>
                                            @if($user->gender === 'Male')
                                                Nam
                                            @elseif($user->gender === 'Female')
                                                Nữ
                                            @else
                                                Khác
                                            @endif
                                        </td>
                                    </tr>
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
