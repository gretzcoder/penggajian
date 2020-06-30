@extends('layouts.user')

@section('title', 'Presensi Karyawan CakeCode')

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body overflow-auto pb-0 pt-3">
            <h4>{{ Carbon\Carbon::now()->locale('id')->dayName.', '.Carbon\Carbon::now()->day.' '.Carbon\Carbon::now()->locale('id')->monthName.' '.Carbon\Carbon::now()->year}}
            </h4>
            <div class="row mb-4">
                <div class="col-12 justify-content-center d-flex mb-2">
                    <h1 class="font-weight-bold" style="font-size: 80px;"></h1>
                </div>
                <div class="col-12 justify-content-center d-flex">
                    @if (session()->has('sudah'))
                    <button class="btn btn-sm btn-secondary rounded-pill font-weight-bold"
                        style="width: 400px; height: 56px; font-size: 32px;"
                        disabled>{{ session()->get('sudah') }}</button>
                    @else
                    <form action="{{ url('presensi') }}" method="post">
                        @csrf
                        @if (Carbon\Carbon::now()->toTimeString() > '10:00:00' || '08:00:00' > Carbon\Carbon::now()->
                        toTimeString() || !Carbon\Carbon::now()->isWeekDay())
                        <button class="btn btn-sm btn-secondary rounded-pill font-weight-bold"
                            style="width: 360px; height: 56px; font-size: 32px;" disabled>DILUAR JAM MASUK</button>
                        @elseif(Carbon\Carbon::now()->toTimeString() >= '09:00:00' && '10:00:00' >=
                        Carbon\Carbon::now()->toTimeString() && Carbon\Carbon::now()->isWeekDay())
                        <button type="submit" class="btn btn-sm btn-warning rounded-pill font-weight-bold"
                            style="width: 240px; height: 56px; font-size: 32px;">TERLAMBAT</button>
                        @else
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill font-weight-bold"
                            style="width: 240px; height: 56px; font-size: 32px;">ABSEN</button>
                        @endif
                    </form>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">Riwayat</a>
                        </li>
                    </ul>
                </div>
                <div class="col-8">
                    <table class="table mt-3 table-hover">
                        <tbody class="text-center">
                            @foreach ($presences as $presence)
                            <tr>
                                <td class="text-left" style="width: 33.3%">
                                    {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->dayName }},
                                    {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->day }}
                                    {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->monthName }}
                                    {{ Carbon\Carbon::parse($presence->created_at)->year }}</td>
                                <td style="width: 33.3%">
                                    {{ $presence->datetime ? Carbon\Carbon::parse($presence->datetime)->toTimeString() : '-' }}
                                </td>
                                <td style="font-weight: bolder"
                                    class="@if($presence->status ==  'h') text-primary @elseif($presence->status ==  'a') text-danger @else text-warning @endif">
                                    {{ ($presence->status == 'h' ? 'Hadir' : ($presence->status == 'a' ? 'Tidak Hadir' : 'Terlambat')) }}
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
@endsection

@section('foot-link')
<!-- Bootstrap core JavaScript-->
<script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script>

<script>
    $(function(){
                $(".alert").delay(3000).slideUp(300);

                setInterval(function(){
                    var d = new Date;
                    var h = ("0" + d.getHours()).slice(-2)
                    var m = ("0" + d.getMinutes()).slice(-2)
                    var s = ("0" + d.getSeconds()).slice(-2)
                    $("h1").html(h+':'+m+':'+s);
                }, 1000);
            });
</script>

@endsection