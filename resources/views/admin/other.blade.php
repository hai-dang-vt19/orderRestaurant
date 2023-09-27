@extends('admin.layout')

@section('title')
    Quản lý chung
@endsection

@section('navbar')
@php
    use App\Models\area;
    use App\Models\menu;
    use App\Models\title_menu;
    use App\Models\User;
    $area = area::all();
    $menu = DB::table('menu')
                        ->join('title_menu','menu.title','=','title_menu.title')
                        ->orderBy('title')
                        ->select('menu.*','title_menu.name_title')->get();
    $title_menu = title_menu::all();
    $user = User::all();
@endphp
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index_admin') }}">Enggo</a>
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
        <div class="col-lg shadow rounded-3 me-2 p-3">
            <table class="table table-bordered border-success table-hover">
                <h5 class="text-center">
                    Danh sách nhân viên
                    <button class="btn btn-primary btn-sm" title=""><i class='bx bx-user-plus'></i></button>
                </h5>
                
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">IDU</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Fun</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key => $itm_user)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td>{{ $itm_user->id_user }}</td>
                            <td>{{ $itm_user->name }}</td>
                            <td>{{ $itm_user->email }}</td>
                            <td>{{ $itm_user->phone }}</td>
                            <td>{{ $itm_user->roles }}</td>
                            <td>@mdo</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-5 shadow rounded-3">
            <div class="row p-3">
                <div class="col-lg-5">
                    <form action="{{ route('create_area_other') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control mb-1" name="title" placeholder="Tên khu vực">
                        <button type="submit" class="btn btn-success w-100">Create area</button>
                    </form>
                </div>
                <div class="col-lg">
                    <table class="table table-bordered border-success">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Fun</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($area as $itm_area)
                                <tr>
                                    <th scope="row">{{ $itm_area->id_area }}</th>
                                    <td>{{ $itm_area->title }}</td>
                                    <td>@mdo</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection