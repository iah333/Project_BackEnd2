
@extends('layouts.admin')
<style>
  .error-message {
    color: red;
}
</style>
@section('content')
    <main class="signup-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Update User</h3>
                        <div class="card-body">
                            <form action=" {{ Route('updateadmin') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input name="id" type="hidden" value="{{auth()->user()->id}}">
                            
                                <div class="row">
                                <div class="col-md-4" style="text-align: center">
                                        <p style="margin-top:20px">Name</p>
                                        <p style="margin-top:35px">Email</p>
                                        <p style="margin-top:28px">Nhập lại mặt khẩu</p>
                                        <p style="margin-top:30px">Phone</p>
                                        <p style="margin-top:30px">Address</p>
                                    </div>
                                <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <input type="text" style="border: solid 1px; width: 250px; margin-top:15px;" placeholder="Name" id="name" class="form-control" name="name"
                                           value="{{ auth()->user()->name }}"
                                           required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" style="border: solid 1px; width: 250px; margin-top:15px;" placeholder="Email" id="email_address" class="form-control"
                                           value="{{ auth()->user()->email }}"
                                           name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" style="border: solid 1px; width: 250px; margin-top:15px;" placeholder="Password" id="password" class="form-control"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" style="border: solid 1px; width: 250px; margin-top:15px;" placeholder="Phone" id="phone" class="form-control" name="phone"  
                                    value="{{ auth()->user()->phone }}">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" style="border: solid 1px; width: 250px; margin-top:15px;" placeholder="Address" id="address" class="form-control" name="address"  
                                    value="{{auth()->user()->address }}" >

                                    @if ($errors->has('address'))
                                     <span class="error-message">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                </div>
                                </div>

                                <!-- Hinh anh -->
                                <div class="row mb-3">
                                    <label for="picture" style="padding-right: 58px;" class="col-md-4 col-form-label text-md-end">{{ __('picture') }}</label>
  
                                    <div class="col-md-6">
                                        <input id="picture"  type="file" class="form-control @error('picture') is-invalid @enderror" name="picture" value="{{ old('picture') }}" required autocomplete="picture">
                                        <img src="{{ asset('uploads/'.auth()->user()->picture)  }}" width="70px" height="70px" alt="picture">
                                        @error('picture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>                                  
                                </div>

                                <div class="row">
                                    <div class="col-md-8" style="text-align: right; margin-top: 6px; margin-left:">
                                        <a href="http://127.0.0.1:8000/login" style="text-align: right; text-decoration: none; font-size: 13px;">Đã có tài khoản</a>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="" style="text-align: right; margin-right: 50px">
                                    <button type="submit" class="btn btn-primary btn-block" >Cập Nhật</button>
                                </div>                           
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
