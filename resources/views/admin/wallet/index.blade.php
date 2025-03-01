@extends('admin.layout')

@section('title', 'Ví Tiền | Quản trị Admin')
@section('title2', 'Danh sách ví tiền')

@section('content')
<style>
    .toggle-status {
        position: relative;
        width: 60px;
        height: 30px;
        -webkit-appearance: none;
        background: #ccc;
        border-radius: 15px;
        outline: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    .toggle-status:checked {
        background: #28a745; /* Màu xanh khi bật */
    }

    .toggle-status::before {
        content: "";
        position: absolute;
        width: 26px;
        height: 26px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: transform 0.3s;
    }

    .toggle-status:checked::before {
        transform: translateX(30px); /* Di chuyển nút gạt */
    }
</style>


{{-- Thông báo bằng SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true  
        });
    </script>
@endif


@if(session('error'))
    <script>
        Swal.fire({
            title: 'Lỗi!',
            text: '{{ session("error") }}',
            icon: 'error',
            showConfirmButton: true,
            confirmButtonText: 'Đóng',
            backdrop: true  
        });
    </script>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                </div>
                
                @if($wallets->isEmpty())
                    <p class="text-center mt-3">Không có ví tiền nào.</p>
                @else
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Số Dư</th>
                            <th>Loại Tiền</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $key => $wallet)
                        <tr>
                            <td width="10"><input type="checkbox" name="check1" value="{{ $wallet->id }}"></td>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $wallet->user->id ?? 'N/A' }}</td>
                            <td>{{ number_format($wallet->balance, 0, ',', '.') }} {{ $wallet->currency }}</td>
                            <td>{{ strtoupper($wallet->currency) }}</td>
                            <td>{{ \Carbon\Carbon::parse($wallet->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('wallet.toggleStatus', $wallet->id) }}" method="POST">
                                    @csrf
                                    <input type="checkbox" class="toggle-status"
                                           {{ $wallet->status === 'active' ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chọn tất cả checkbox
        document.getElementById("all").addEventListener("change", function() {
            document.querySelectorAll('input[name="check1"]').forEach(el => el.checked = this.checked);
        });
    });
</script>

@endsection
