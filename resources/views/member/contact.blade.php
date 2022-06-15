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
                <li class="breadcrumb-item active" aria-current="page">Hubungi Kami
                </li>
            </ol>
        </div>
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <p class="font-weight-bold">Arout Outdoor</p>
                    <p>Hubungi Kami Lewat Whatsapp : <a href="https://wa.me/6281227827967?text=Hai, Arout outdoor saya ingin bertanya tentang persewaan alat.." target="_blank">+6281227827967</a></p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.9708240940613!2d110.80701131432397!3d-7.578154676962924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16783dbd32eb%3A0xe852ba0aa1842158!2sFakultas%20Ilmu%20Komputer%20-%20Universitas%20Duta%20Bangsa!5e0!3m2!1sid!2sid!4v1655270195966!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
