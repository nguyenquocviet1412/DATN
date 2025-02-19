@extends('admin.layout')
@section('title')
Danh sách Voucher | Quản trị Admin
@endsection
@section('title2')
Danh sách Voucher
@endsection
@section('content')

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
                            @if(\Carbon\Carbon::now()->greaterThan($voucher->end_date))
                                <span class="badge bg-danger">Hết Hạn</span>
                            @else
                                <span class="badge bg-success">Còn Hạn</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <form action="{{ route('voucher.delete', $voucher->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Chỉnh Sửa Voucher -->
                    <div class="modal fade" id="editVoucherModal{{ $voucher->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chỉnh Sửa Voucher</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Mã Voucher</label>
                                            <input type="text" name="code" value="{{ $voucher->code }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Loại Giảm Giá</label>
                                            <select name="discount_type" class="form-select">
                                                <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                                                <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Tiền mặt</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giá Trị Giảm</label>
                                            <input type="number" name="discount_value" value="{{ $voucher->discount_value }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ngày Bắt Đầu</label>
                                            <input type="date" name="start_date" value="{{ $voucher->start_date }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ngày Kết Thúc</label>
                                            <input type="date" name="end_date" value="{{ $voucher->end_date }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Lưu</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



</div>

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
