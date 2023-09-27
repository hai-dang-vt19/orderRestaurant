@extends('admin.layout')

@section('title')
    Index
@endsection

@section('navbar')
    @php
        use App\Models\area;
        use App\Models\menu;
        use App\Models\title_menu;
        use App\Models\orders;
        $area = area::all();
        $menu = DB::table('menu')
                            ->join('title_menu','menu.title','=','title_menu.title')
                            ->orderBy('title')
                            ->select('menu.*','title_menu.name_title')->get();
        // $menu = menu::orderby('title')->get();
        $title_menu = title_menu::all();
    @endphp
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index_admin') }}">Enggo Korea</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('index_admin') }}">Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('view_other') }}">Quản lý chung</a>
                    </li>
                </ul>
                <button class="btn btn-warning btn-sm me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    QUẢN LÝ MENU
                </button>
                <button class="btn btn-warning btn-sm me-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    QUẢN LÝ BÀN
                </button>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end text-bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasMenuLabel">Quản lý menu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('create_menu') }}" method="POST"  class="needs-validation mb-3" novalidate>
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="title_menu" class="form-label">Nhóm món</label>
                            <select class="form-control @error('title_menu') is-invalid @enderror" id="title_menu" name="title_menu">
                                @foreach ($title_menu as $itm_ttmn_datalst) 
                                    <option value="{{ $itm_ttmn_datalst->title}}">{{ $itm_ttmn_datalst->name_title }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" class="form-control @error('title_menu') is-invalid @enderror" id="title_menu" name="title_menu" required> --}}
                            <div class="invalid-feedback">
                                Not null
                            </div>
                            @error('title_menu')<div class="valid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="name_menu" class="form-label">Tên món</label>
                            <input type="text" class="form-control @error('name_menu') is-invalid @enderror" id="name_menu" name="name_menu" required>
                            <div class="invalid-feedback">
                                Not null
                            </div>
                            @error('name_menu')<div class="valid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="size_menu" class="form-label">Size</label>
                        <select name="size_menu" id="size_menu" class="form-select">
                            <option selected></option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="Một phần">Một Phần</option>
                            <option value="Nửa con">Nửa con</option>
                            <option value="Một con">Một con</option>
                            <option value="Một chai">Một chai</option>
                            <option value="Một lon">Một lon</option>
                            <option value="Một cốc">Một cốc</option>
                        </select>
                    </div>
                    <div class="col-lg">
                        <label for="price_menu" class="form-label">Giá tiền</label>
                        <input type="number" class="form-control @error('price_menu') is-invalid @enderror" id="price_menu" name="price_menu" required>
                        <div class="invalid-feedback">
                            Not null
                        </div>
                        @error('price_menu')<div class="valid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Descriptions" id="TextareaDesMenu" style="height: 100px" name="des_menu"></textarea>
                    <label for="TextareaDesMenu">Ghi Chú</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
            <hr>
            <table class="table mt-3">
                <thead class=" text-center">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">FUn</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($menu as $item)
                        <tr data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $item->des }}">
                            <th scope="row" class=" text-center">{{ $item->id_menu }}</th>
                            <th>
                                {{ $item->name }}
                                <br>
                                Size: <span class="text-danger">{{ $item->size }} </span> <span class="text-primary">{{ number_format($item->price) }}</span> 
                                <br>
                                <span class="text-danger">{{ $item->des }}</span>
                            </th>
                            <th class=" text-center">@md0</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-end text-bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Thông tin tạo bàn</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('create_table') }}" method="POST"  class="needs-validation mb-3" novalidate>
                @csrf
                <div class="row mb-3">
                    <div class="col-lg">
                        <div>
                            <label for="member" class="form-label">Số người</label>
                            <input type="number" min="2" max="6" step="2" class="form-control @error('member') is-invalid @enderror" id="member" name="member" required>
                            <div class="invalid-feedback">
                                Not null
                            </div>
                            @error('member')<div class="valid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-lg">
                        <label for="select_area" class="form-label">Khu vực</label>
                        <select name="id_area" class="form-select" id="select_area">
                            @foreach ($area as $item_area)
                                <option value="{{ $item_area->id_area }}">{{ $item_area->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Descriptions" id="floatingTextarea2" style="height: 100px" name="des"></textarea>
                    <label for="floatingTextarea2">Ghi Chú</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
            <hr>
            <table class="table text-center mt-3">
                <thead>
                  <tr>
                    <th scope="col">Số bàn</th>
                    <th scope="col">Số người</th>
                    <th scope="col">Khu vực</th>
                    <th scope="col">Fun</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($table_offcanvas as $item)
                        <tr class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $item->des }}">
                            <th scope="row">{{ $item->id_table }}</th>
                            <th>{{ $item->member }}</th>
                            <th>{{ $item->title }}</th>
                            <th>@md0</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('body_web')
    <div class="row">
        <div class="col-lg">
            <div class="shadow rounded-3 py-3">
                <div class="overflow-y-scroll" style="height: 70vh">
                    <div class="dropdown px-3">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Chọn khu vực hiển thị
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            @foreach ($area as $itm_dd_area)
                                <li><a class="dropdown-item" href="{{ route('pic_area_index', ['data'=>$itm_dd_area->id_area]) }}">{{ $itm_dd_area->title }}</a></li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('pic_area_index', ['data'=>0]) }}">Tất cả</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        @foreach ($table_offcanvas as $itm_tbl)
                            <div class="col-sm-2 mb-4 text-center">
                                <i class='bx bxs-card' style="font-size: 15vh;color: @if ($itm_tbl->status == 0) #f2f2f2 @else #0ca03b @endif;"
                                    data-bs-toggle="modal" data-bs-target="#model_{{$itm_tbl->id_table}}"
                                >
                                </i>
                                <div>
                                    <span style="font-size: 2vh;color: @if ($itm_tbl->status == 0) #c6c3c3 @else #0ca03b @endif;@if ($itm_tbl->status != 0) font-weight: bold @endif">Bàn {{ $itm_tbl->id_table }}</span>
                                </div>
                            </div>
                            <!-- Modal -->
                            @if ($itm_tbl->status == 0)
                            <div class="modal fade" id="model_{{$itm_tbl->id_table}}" tabindex="-1" aria-labelledby="eML{{$itm_tbl->id_table}}" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <form action="{{ route('order', ['id'=>$itm_tbl->id_table]) }}" method="GET">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="eML{{$itm_tbl->id_table}}">BÀN {{ $itm_tbl->id_table }}</h1>&emsp;<span>( {{ $itm_tbl->member }} chỗ ngồi )</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    @foreach ($title_menu as $itm_ttmn)
                                                        <div class="ms-4 d-flex @if($itm_ttmn->title > 1) mt-5 @endif">
                                                            <p class="fw-bold fs-5">{{ $itm_ttmn->name_title }}</p>
                                                        </div>
                                                        @php
                                                            $title_menu_order = menu::where('title',$itm_ttmn->title)->get();
                                                        @endphp
                                                        <div class="row">
                                                            @foreach ($title_menu_order as $itm_menuOrder)
                                                                <div class="col-md-4">
                                                                    <div class="card shadow mb-3 p-3">
                                                                        <h5 class="card-title">{{ $itm_menuOrder->name }}</h5>
                                                                        <p class="card-text">Size: 
                                                                            <span class="text-danger">
                                                                                {{ $itm_menuOrder->size }}
                                                                                @empty($itm_menuOrder->size) Đồ gọi thêm @endempty
                                                                            </span>
                                                                        </p>
                                                                        <p class="card-text">Giá tiền: <span class="text-primary">{{ number_format($itm_menuOrder->price) }} &#8363;</span></p>
                                                                        <p class="card-text"><small class="text-body-secondary">{{ $itm_menuOrder->des }}</small></p>
                                                                        <input type="hidden" name="itemCard_name_menu[]" value="{{ $itm_menuOrder->name }}" class="form-control">
                                                                        <input type="hidden" name="itemCard_size_menu[]" value="{{ $itm_menuOrder->size }}" class="form-control">
                                                                        <input type="hidden" name="itemCard_price_menu[]" value="{{ $itm_menuOrder->price }}" class="form-control">
                                                                        <div class="input-group">
                                                                            <label class="input-group-text" for="imQuality{{$itm_menuOrder->id_menu}}">Số lượng </label>
                                                                            <input type="number" min="0" name="itemCard_quality[]" class="form-control w-25" id="imQuality{{$itm_menuOrder->id_menu}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                                <div class="modal fade" id="model_{{$itm_tbl->id_table}}" tabindex="-1" aria-labelledby="eML{{$itm_tbl->id_table}}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="eML{{$itm_tbl->id_table}}">BÀN {{ $itm_tbl->id_table }}</h1>&emsp;<span>( {{ $itm_tbl->member }} chỗ ngồi )</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $order = orders::where('id_table',$itm_tbl->id_table)->where('check_bill','!=',0)->where('status',null)->get();
                                                @endphp
                                                <div>
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">SL</th>
                                                                <th scope="col" colspan="2">Tên món</th>
                                                                <th scope="col">Size</th>
                                                                <th scope="col">Giá món</th>
                                                                <th scope="col">Giá tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order as $item)
                                                                    @php
                                                                        $ex_data1 = explode(',', $item->name_menu);
                                                                        $total = 0;
                                                                        foreach ($ex_data1 as $vl_exdata1) {
                                                                            $ex_data2 = explode('-',$vl_exdata1);
                                                                            echo    '<tr>
                                                                                        <td>'.$ex_data2[0].'</td>
                                                                                        <td colspan="2">'.$ex_data2[1].'</td>
                                                                                        <td>'.$ex_data2[2].'</td>
                                                                                        <td>'.number_format($ex_data2[3]).' &#8363;</td>
                                                                                        <td>'.number_format($ex_data2[3]*$ex_data2[0]).' &#8363;</td>
                                                                                    </tr>
                                                                            ';
                                                                            $total += $ex_data2[3]*$ex_data2[0];
                                                                        }
                                                                    @endphp
                                                            @endforeach
                                                            <tr class="table-light text-center">
                                                                <td colspan="6">Mã hóa đơn: <strong>{{ $item->id_order }}</strong></td>
                                                            </tr>
                                                            <tr class="table-dark">
                                                                <td colspan="4" class="fw-bolder text-center">
                                                                    @if ($item->check_bill == 4) Phương thức thanh toán 
                                                                    @else Khách hàng đã thanh toán 
                                                                        @if ($item->check_bill == 1)
                                                                            bằng thẻ ATM
                                                                        @elseif ($item->check_bill == 2)
                                                                            bằng QRCODE
                                                                        @elseif ($item->check_bill == 3)
                                                                            bằng tiền mặt
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td colspan="2" class="text-center fw-bolder">Tổng tiền: <span class="text-warning">{{ number_format($total) }} &#8363;</span></td>
                                                            </tr>
                                                            @if ($item->check_bill == 4)
                                                                <form action="" method="POST">@csrf
                                                                    <tr class="table-dark">
                                                                        <td colspan="5">
                                                                            <div class="row">
                                                                                <div class="col-lg">
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" name="methods" value="1" id="atm">
                                                                                        <label class="form-check-label" for="atm">ATM</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg">
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" name="methods" value="2" id="qrcode">
                                                                                        <label class="form-check-label" for="qrcode">QRCODE</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg">
                                                                                    <div class="form-check">
                                                                                        <input type="radio" class="form-check-input" name="methods" value="3" id="cash" checked>
                                                                                        <label class="form-check-label" for="cash">Tiền mặt</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="1"><Button type="submit" class="btn btn-primary w-100">Thanh toán</Button></td>
                                                                    </tr>
                                                                </form>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('destroy_BillOrder', ['id_table'=>$itm_tbl->id_table, 'id_order'=>$item->id_order]) }}" class="btn btn-danger">Hủy</a>
                                                @if ($item->check_bill < 4)
                                                    <form action="{{ route('checkout', ['id_table'=>$itm_tbl->id_table, 'id_order'=>$item->id_order]) }}" method="POST">@csrf
                                                        <button type="submit" class="btn btn-success">Checkout</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection