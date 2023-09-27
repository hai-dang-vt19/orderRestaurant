@extends('admin.layout')

@section('title')
    Đăng nhập
@endsection

@section('body_web')
    <div class="container formLogin">
        <div class="row justify-content-md-center">
            <div class="col col-lg-3 rounded-3 shadow py-2">
                <form action="{{ route('registerUser') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" name="email" required>
                        <div class="invalid-feedback">
                            Not null
                        </div>
                        @error('email')<div class="valid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="name@example.com" name="username" required>
                        <div class="invalid-feedback">
                            Not null
                        </div>
                        @error('username')<div class="valid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="12345678" required>
                        <div class="invalid-feedback">
                            Not null
                        </div>
                        @error('password')<div class="valid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_ck" class="form-label">Confirm password</label>
                        <input type="password" class="form-control @error('password_ck') is-invalid @enderror" id="password_ck" name="password_ck" value="12345678" required>
                        <div class="invalid-feedback">
                            Error
                        </div>
                        @error('password_ck')<div class="valid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </div>
                </form>         
            </div>
        </div>
    </div>
@endsection