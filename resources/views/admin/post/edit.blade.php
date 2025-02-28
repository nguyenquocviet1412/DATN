@extends('admin.layout')

@section('title')
Chỉnh sửa Bài Viết | Quản trị Admin
@endsection

@section('title2')
Chỉnh sửa Bài Viết
@endsection

@section('content')
<form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa bài viết</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="username" value="{{ $post->employee->username }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Title</label>
                            <input class="form-control" type="text" name="title" value="{{ $post->title }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Content</label>
                            <input class="form-control" type="text" name="content" value="{{ $post->content }}" required>
                        </div>
                        {{-- <div class="form-group col-md-3">
                            <label class="control-label">Image</label>
                            <input class="form-control" type="number" name="phone" value="" required>
                        </div> --}}
                        <div class="form-group col-md-3">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose status --</option>
                                <option value="Published" @if($post->status == 'Published') selected @endif>Đã xuất bản</option>
                                <option value="Draft" @if($post->status == 'Draft') selected @endif>Nháp</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('post.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection