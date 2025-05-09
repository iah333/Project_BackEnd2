@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Người dùng</h5>
                        <p class="card-text">Tổng số người dùng: <strong>150</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Bài viết</h5>
                        <p class="card-text">Tổng số bài viết: <strong>85</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Truy cập hôm nay</h5>
                        <p class="card-text">Lượt truy cập: <strong>320</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
