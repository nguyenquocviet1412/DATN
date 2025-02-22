@extends('admin.layout')
@section('title', 'Danh sách sản phẩm | Quản trị Admin')
@section('title2', 'Danh sách sản phẩm')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

{{-- thông báo thêm thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true  // Làm tối nền
        });
    </script>
@endif


{{-- Thông báo lỗi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Lỗi!',
                text: '{{ session("error") }}',
                icon: 'error',
                showConfirmButton: true,  // Hiển thị nút đóng
                confirmButtonText: 'Đóng',  // Nội dung nút đóng
                backdrop: true  // Làm tối nền
            });
        </script>
    @endif


                    <div class="row element-button">
                        <div class="col-sm-6">
                            <a class="btn btn-add btn-sm" href="{{ route('product.create') }}" title="Thêm">
                                <i class="fas fa-plus"></i> Tạo mới sản phẩm
                            </a>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('product.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Tím kiếm  -->



                    <!-- Dropdown sắp xếp -->
                    <div class="mb-3">
                        <form method="GET" action="{{ route('product.index') }}">
                            <label for="sort_by">Sắp xếp theo:</label>
                            <select name="sort_by" id="sort_by" class="form-control d-inline-block w-auto">
                                <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>ID</option>
                                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                                <option value="price" {{ $sortBy == 'price' ? 'selected' : '' }}>Giá</option>
                                <option value="status" {{ $sortBy == 'status' ? 'selected' : '' }}>Tình trạng</option>
                            </select>

                            <select name="sort_order" id="sort_order" class="form-control d-inline-block w-auto">
                                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                            </select>

                            <button type="submit" class="btn btn-primary">Sắp xếp</button>
                        </form>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Tình trạng</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <input type="checkbox" name="check1" value="{{ $product->id }}">
                                    </td>
                                    <td class="text-center">{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-center">
                                        @php
                                            $image = optional($product->variants->first()->images->first())->image_url;
                                            $imageSrc = filter_var($image, FILTER_VALIDATE_URL) ? $image : asset( $image);
                                        @endphp
                                    <img src="{{ $image ? $imageSrc : asset('default-image.jpg') }}"
                                         width="80px"
                                         height="80px"
                                         class="rounded shadow-sm"
                                         alt="Ảnh sản phẩm">
                                    </td>
                                    <td class="text-center">{{ $product->variants->sum('quantity') }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </td>
                                    <td class="text-end">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                    <td class="text-center">{{ $product->category->name ?? 'Không có danh mục' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('product.delete', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Phân trang -->
                    <div class="pagination justify-content-center">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                    <script>
                        document.getElementById('select-all').addEventListener('change', function() {
                            let checkboxes = document.querySelectorAll('input[name="check1"]');
                            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection
