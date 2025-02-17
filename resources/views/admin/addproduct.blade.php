@extends('admin.layout')
@section('title')
Thêm sản phẩm | Quản trị Admin
@endsection
@section('title2')
Thêm sản phẩm
@endsection
@section('content')

<script>

    function readURL(input, thumbimage) {
      if (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#thumbimage").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
      else { // Sử dụng cho IE
        $("#thumbimage").attr('src', input.value);

      }
      $("#thumbimage").show();
      $('.filename').text($("#uploadfile").val());
      $('.Choicefile').css('background', '#14142B');
      $('.Choicefile').css('cursor', 'default');
      $(".removeimg").show();
      $(".Choicefile").unbind('click');

    }
    $(document).ready(function () {
      $(".Choicefile").bind('click', function () {
        $("#uploadfile").click();

      });
      $(".removeimg").click(function () {
        $("#thumbimage").attr('src', '').hide();
        $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
        $(".removeimg").hide();
        $(".Choicefile").bind('click', function () {
          $("#uploadfile").click();
        });
        $('.Choicefile').css('background', '#14142B');
        $('.Choicefile').css('cursor', 'pointer');
        $(".filename").text("");
      });
    })
  </script>

<style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>



<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Tạo mới sản phẩm</h3>
        <div class="tile-body">
          <div class="row element-button">
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
                  class="fas fa-folder-plus"></i> Thêm nhà cung cấp</a>
            </div>
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                  class="fas fa-folder-plus"></i> Thêm danh mục</a>
            </div>
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addtinhtrang"><i
                  class="fas fa-folder-plus"></i> Thêm tình trạng</a>
            </div>
          </div>
          <form class="row">
            <div class="form-group col-md-3">
              <label class="control-label">Mã sản phẩm </label>
              <input class="form-control" type="number" placeholder="">
            </div>
            <div class="form-group col-md-3">
              <label class="control-label">Tên sản phẩm</label>
              <input class="form-control" type="text">
            </div>


            <div class="form-group  col-md-3">
              <label class="control-label">Số lượng</label>
              <input class="form-control" type="number">
            </div>
            <div class="form-group col-md-3 ">
              <label for="exampleSelect1" class="control-label">Tình trạng</label>
              <select class="form-control" id="exampleSelect1">
                <option>-- Chọn tình trạng --</option>
                <option>Còn hàng</option>
                <option>Hết hàng</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="exampleSelect1" class="control-label">Danh mục</label>
              <select class="form-control" id="exampleSelect1">
                <option>-- Chọn danh mục --</option>
                <option>Bàn ăn</option>
                <option>Bàn thông minh</option>
                <option>Tủ</option>
                <option>Ghế gỗ</option>
                <option>Ghế sắt</option>
                <option>Giường người lớn</option>
                <option>Giường trẻ em</option>
                <option>Bàn trang điểm</option>
                <option>Giá đỡ</option>
              </select>
            </div>
            <div class="form-group col-md-3 ">
              <label for="exampleSelect1" class="control-label">Nhà cung cấp</label>
              <select class="form-control" id="exampleSelect1">
                <option>-- Chọn nhà cung cấp --</option>
                <option>Phong vũ</option>
                <option>Thế giới di động</option>
                <option>FPT</option>
                <option>Võ Trường</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label class="control-label">Giá bán</label>
              <input class="form-control" type="text">
            </div>
            <div class="form-group col-md-3">
              <label class="control-label">Giá vốn</label>
              <input class="form-control" type="text">
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Ảnh sản phẩm</label>
              <div id="myfileupload">
                <input type="file" id="uploadfile" name="ImageUpload" onchange="readURL(this);" />
              </div>
              <div id="thumbbox">
                <img height="450" width="400" alt="Thumb image" id="thumbimage" style="display: none" />
                <a class="removeimg" href="javascript:"></a>
              </div>
              <div id="boxchoice">
                <a href="javascript:" class="Choicefile"><i class="fas fa-cloud-upload-alt"></i> Chọn ảnh</a>
                <p style="clear:both"></p>
              </div>

            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Mô tả sản phẩm</label>
              <textarea class="form-control" name="mota" id="mota"></textarea>
              <script>CKEDITOR.replace('mota');</script>
            </div>

        </div>
        <button class="btn btn-save" type="button">Lưu lại</button>
        <a class="btn btn-cancel" href="table-data-product.html">Hủy bỏ</a>
      </div>


<script src="{{asset('admin/doc/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('admin/doc/js/popper.min.js')}}"></script>
<script src="{{asset('admin/doc/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/doc/js/main.js')}}"></script>
<script src="{{asset('admin/doc/js/plugins/pace.min.js')}}"></script>
<script>
  const inpFile = document.getElementById("inpFile");
  const loadFile = document.getElementById("loadFile");
  const previewContainer = document.getElementById("imagePreview");
  const previewContainer = document.getElementById("imagePreview");
  const previewImage = previewContainer.querySelector(".image-preview__image");
  const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
  inpFile.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewDefaultText.style.display = "none";
      previewImage.style.display = "block";
      reader.addEventListener("load", function () {
        previewImage.setAttribute("src", this.result);
      });
      reader.readAsDataURL(file);
    }
  });

</script>
@endsection
