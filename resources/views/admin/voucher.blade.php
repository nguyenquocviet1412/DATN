@extends('admin.layout')
@section('title')
Danh sách Voucher | Quản trị Admin
@endsection
@section('title2')
Danh sách Voucher
@endsection
@section('content')

<!-- jQuery (Cần thiết cho Bootstrap Toggle) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Toggle -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script>




<div class=" mt-4">
    <h2 class="mb-4"><i class="fas fa-ticket-alt"></i> Quản Lý Voucher</h2>

    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">

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


                      <a class="btn btn-add btn-sm" href="{{route('voucher.create')}}" title="Thêm">
                        <i class="fas fa-plus"></i> Thêm Voucher</a>
                        @if(session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                        @endif
                    </div>
                  </div>
              <table class="table table-bordered table-hover js-copytextarea" cellpadding="0" cellspacing="0" border="0"
                id="sampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Loại Giảm Giá</th>
                        <th>Giảm Giá</th>
                        <th>Giá Trị Tối Thiểu</th>
                        <th>Giảm Tối Đa</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Ngày Kết Thúc</th>
                        <th>Giới Hạn Sử Dụng</th>
                        <th>Đã Sử Dụng</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $key => $voucher)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ ucfirst($voucher->discount_type) }}</td>
                        <td>
                            @if($voucher->discount_type == 'percentage')
                                {{ $voucher->discount_value }}%
                            @else
                                {{ number_format($voucher->discount_value, 0, ',', '.') }} VNĐ
                            @endif
                        </td>
                        <td>{{ number_format($voucher->min_order_value, 0, ',', '.') }} VNĐ</td>
                        <td>{{ number_format($voucher->max_discount, 0, ',', '.') }} VNĐ</td>
                        <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</td>
                        <td>{{ $voucher->usage_limit }}</td>
                        <td>{{ $voucher->used_count }}</td>
                        <td>
                            <form action="{{ route('voucher.toggleStatus', $voucher->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="{{ $voucher->status == 'active' ? 'disabled' : 'active' }}">
                                <input type="checkbox" class="toggle-status"
                                       data-toggle="toggle"
                                       data-on="Hoạt động"
                                       data-off="Vô hiệu hóa"
                                       data-onstyle="success"
                                       data-offstyle="danger"
                                       {{ $voucher->status == 'active' ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp">
                                <i class="fas fa-edit"></i> Sửa
                            </a>

                            <form action="{{ route('voucher.delete', $voucher->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



</div>

<script>
    <script>
        $(document).ready(function () {
    console.log("Khởi tạo DataTable...");

    var table = $('#sampleTable').DataTable();

    // Khởi tạo toggle sau khi DataTable đã load xong
    $('.toggle-status').bootstrapToggle();

    table.on('draw', function () {
        console.log("Cập nhật lại Bootstrap Toggle...");
        $('.toggle-status').bootstrapToggle('destroy');
        $('.toggle-status').bootstrapToggle();
    });
});

</script>




<!--
  MODAL
-->

  <script>
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
    jQuery(function () {
      jQuery(".trash").click(function () {
        swal({
          title: "Cảnh báo",

          text: "Bạn có chắc chắn là muốn xóa khách hàng này?",
          buttons: ["Hủy bỏ", "Đồng ý"],
        })
          .then((willDelete) => {
            if (willDelete) {
              swal("Đã xóa thành công.!", {

              });
            }
          });
      });
    });
    oTable = $('#sampleTable').dataTable();
    $('#all').click(function (e) {
      $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
      e.stopImmediatePropagation();
    });

    //EXCEL
    // $(document).ready(function () {
    //   $('#').DataTable({

    //     dom: 'Bfrtip',
    //     "buttons": [
    //       'excel'
    //     ]
    //   });
    // });


    //Thời Gian
    function time() {
      var today = new Date();
      var weekday = new Array(7);
      weekday[0] = "Chủ Nhật";
      weekday[1] = "Thứ Hai";
      weekday[2] = "Thứ Ba";
      weekday[3] = "Thứ Tư";
      weekday[4] = "Thứ Năm";
      weekday[5] = "Thứ Sáu";
      weekday[6] = "Thứ Bảy";
      var day = weekday[today.getDay()];
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      nowTime = h + " giờ " + m + " phút " + s + " giây";
      if (dd < 10) {
        dd = '0' + dd
      }
      if (mm < 10) {
        mm = '0' + mm
      }
      today = day + ', ' + dd + '/' + mm + '/' + yyyy;
      tmp = '<span class="date"> ' + today + ' - ' + nowTime +
        '</span>';
      document.getElementById("clock").innerHTML = tmp;
      clocktime = setTimeout("time()", "1000", "Javascript");

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
    }
    //In dữ liệu
    var myApp = new function () {
      this.printTable = function () {
        var tab = document.getElementById('sampleTable');
        var win = window.open('', '', 'height=700,width=700');
        win.document.write(tab.outerHTML);
        win.document.close();
        win.print();
      }
    }
    //     //Sao chép dữ liệu
    //     var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

    // copyTextareaBtn.addEventListener('click', function(event) {
    //   var copyTextarea = document.querySelector('.js-copytextarea');
    //   copyTextarea.focus();
    //   copyTextarea.select();

    //   try {
    //     var successful = document.execCommand('copy');
    //     var msg = successful ? 'successful' : 'unsuccessful';
    //     console.log('Copying text command was ' + msg);
    //   } catch (err) {
    //     console.log('Oops, unable to copy');
    //   }
    // });


    //Modal
    $("#show-emp").on("click", function () {
      $("#ModalUP").modal({ backdrop: false, keyboard: false })
    });
  </script>


@endsection
