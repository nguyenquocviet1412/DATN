@extends('master.main')
@section('title', 'Thêm đánh giá')
@section('main')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card" style="background-color: #f8f9fa;">
        <div class="card-header bg-secondary text-white">
            <h4>Thêm Đánh Giá</h4>
        </div>
        <div class="card-body">
            <form id="rateForm">
                @csrf
                <div class="mb-3">
                    <label for="id_user" class="form-label">ID Người dùng:</label>
                    <input type="hidden" id="id_user" name="id_user" value="{{ $id_user }}">
                    <p>{{ $id_user }}</p>
                </div>
                
                <div class="mb-3">
                    <label for="id_product" class="form-label">ID Sản phẩm:</label>
                    <input type="hidden" id="id_product" name="id_product" value="{{ $id_product }}">
                    <p>{{ $id_product }}</p>
                </div>
                
                <div class="mb-3">
                    <label for="id_order_item" class="form-label">ID Đơn hàng:</label>
                    <input type="hidden" id="id_order_item" name="id_order_item" value="{{ $id_order_item }}">
                    <p>{{ $id_order_item }}</p>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Đánh giá (1-5):</label>
                    <input type="number" id="rating" name="rating" class="form-control" min="1" max="5" required>
                </div>

                <div class="mb-3">
                    <label for="review" class="form-label">Nhận xét:</label>
                    <textarea id="review" name="review" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-danger">Gửi đánh giá</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('rateForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('{{ url('/api/rate') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm CSRF token vào header
            },
            body: formData,
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message);
        } else {
            alert('Có lỗi xảy ra: ' + JSON.stringify(result.errors));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Không thể gửi đánh giá.');
    }
});
</script>
@endsection