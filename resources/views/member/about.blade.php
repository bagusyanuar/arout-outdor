@extends('member.layout')

@section('content')
    <div class="banner-container">
        <div class="banner-image" style="width: 100%">
            <img src="{{ asset('/assets/icon/banner.png') }}" alt="Gambar Banner" class="banner-item" height="400">
        </div>
        <div class="banner-text-container">
            <div class="d-flex justify-content-center align-items-center" style="height: 300px">
                <p class="banner-text" style="opacity: 1">Selamat Datang Web Di E-Commerce </p>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="d-flex align-items-center justify-content-start mb-2">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tentang Kami
                </li>
            </ol>
        </div>
        <div class="mt-3">
            <p class="font-weight-bold">Arout Outdoor</p>
            <p>Kami Adalah Tempat Persewaan Outdoor di daerah Wonogiri</p>
        </div>
    </div>
@endsection

@section('js')
@endsection
