@extends('layouts.admin')

@section('title', 'Penggajian Karyawan CakeCode')

@section('head-link')
<!-- Custom fonts for this template-->
<link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<!-- Custom styles for this page -->
<link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row align-middle justify-content-between mx-3">
        <div class="col-6">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Penggajian Karyawan CakeCode</h1>
            <p class="mb-4">Seluruh data Penggajian karyawan yang ada di Database Aplikasi Penggajian CakeCode</p>
        </div>
        {{-- <td><a href="#" class="status" data-type="select" data-pk="1" data-value="1" data-url="{{ url('api/admin/active') }}"
        data-title="Select status"></a></td> --}}
        <div class="col-4 justify-content-end">
            <form action={{ url('admin/penggajian') }} method="post">
                <div class="input-group mr-3 mt-3" style="height: 48px;">
                    @csrf
                    <select name="month" class="custom-select text-primary text-center"
                        style="text-align: center; font-weight: bolder; width: 125px;">
                        @foreach ($monthUnique as $m)
                        @if ($postMonth == $m);
                        <option selected class="text-center" value="{{ Carbon\Carbon::parse('1-'.$m.'-2020')->month }}">
                            {{ Carbon\Carbon::parse('7-'.$m.'-2020')->locale('id')->monthName }}</option>
                        @else
                        <option class="text-center" value="{{ Carbon\Carbon::parse('1-'.$m.'-2020')->month }}">
                            {{ Carbon\Carbon::parse('7-'.$m.'-2020')->locale('id')->monthName }}</option>
                        @endif
                        @endforeach
                    </select>
                    <select name="year" class="custom-select text-primary mr-3"
                        style="text-align: center; font-weight: bolder;">
                        @foreach ($yearUnique as $y)
                        @if ($postYear == $y);
                        <option selected class="text-center" value="{{ Carbon\Carbon::parse('7-8-'.$y)->year }}">
                            {{ Carbon\Carbon::parse('7-8-'.$y)->year }}</option>
                        @else
                        <option class="text-center" value="{{ Carbon\Carbon::parse('7-8-'.$y)->year }}">
                            {{ Carbon\Carbon::parse('7-8-'.$y)->year }}</option>

                        @endif
                        @endforeach
                    </select>
                    <input type="submit" class="btn btn-sm btn-primary" style="height: 38px;" value="submit">
                </div>
            </form>
        </div>

    </div>
    @if (session()->has('not_time'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('not_time') }}
    </div>
    @endif
    @if (session()->has('time'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('time') }}
    </div>
    @endif
    @if (session()->has('sudah'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('sudah') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataPenggajian" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Nip</th>
                            <th class="text-center align-middle">Nama Lengkap</th>
                            <th class="text-center align-middle">Jabatan</th>
                            <th class="text-center align-middle">Gaji Pokok</th>
                            <th class="text-center align-middle">Penambahan</th>
                            <th class="text-center align-middle">Potongan</th>
                            <th class="text-center align-middle">Gaji Bersih</th>
                            <th class="text-center align-middle"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $row => $e)
                        @if ($postMonth.$postYear != Carbon\Carbon::now()->month.Carbon\Carbon::now()->year)
                        <tr>
                            <td>{{ $e->user->nip }}</td>
                            <td>{{ $e->full_name }}</td>
                            <td>{{ $e->position->position }}</td>
                            <td>Rp. {{ number_format($e->position->salary,0,'','.') }}</td>
                            <td>Rp. {{ number_format($hasilPenambahan[$row],0,'','.') }}
                            </td>
                            <td>Rp. {{ number_format($hasilPotongan[$row],0,'','.') }}</td>
                            <td>Rp.
                                {{ number_format($gajiBersih[$row],0,'','.') }}
                            </td>
                            <td class="text-center align-middle">
                                <button title="Info Gaji" type="button" class="btn btn-info btn-sm" style="width: 50px;"
                                    data-toggle="modal" data-target=".bd-example-modal-lg{{ $e->id }}"><i
                                        class="fas fa-info-circle fa-lg"></i></button>
                                <button disabled type="submit" class="btn btn-primary btn-sm" style="width: 50px;"
                                    value="submit" disabled title="Download Slip"><i
                                        class="fas fa-file-download fa-lg"></i></button>
                            </td>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg{{ $e->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rekap Gaji {{ $e->full_name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            <div class="row">
                                                <div class="col-9 pl-5">
                                                    <h2 class="text-left text-dark font-weight-bold mb-0 mt-1">
                                                        CakeCode
                                                    </h2>
                                                    <h4 class="text-left text-dark">learn code with
                                                        some cake</h4>
                                                </div>
                                                <div class="col-3 pr-4">
                                                    <img src="{{ asset('img/logoWarna.png') }}" height="80px;">
                                                </div>
                                            </div>
                                            <hr class="sidebar-divider d-none d-md-block">

                                            <div class="container text-monospace">
                                                <div class="row">
                                                    <div class="col-12 mb-1">
                                                        <h6 class="text-center font-weight-bold mb-0"><u> GAJI KARYAWAN
                                                            </u></h6>
                                                        <p class="text-center">Periode 1
                                                            {{ Carbon\Carbon::parse('7-'.$postMonth.'-2020')->locale('id')->monthName }}
                                                            {{ $postYear }} -
                                                            {{ Carbon\Carbon::parse('10-'.$postMonth.'-'.$postYear)->endOfMonth()->day }}
                                                            {{ Carbon\Carbon::parse('7-'.$postMonth.'-2020')->locale('id')->monthName }}
                                                            {{ $postYear }}</p>
                                                    </div>
                                                    <br><br><br><br><br>
                                                    <div class="col-3">
                                                        <p class="text-left mb-0" style="font-size: 12px">Nip</p>
                                                        <p class="text-left mb-0" style="font-size: 12px">Nama Lengkap
                                                        </p>
                                                        <p class="text-left mb-0" style="font-size: 12px">Jabatan</p>
                                                    </div>
                                                    <div class="col-5">
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->user->nip }}</p>
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->full_name }}</p>
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->position->position }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <h6 class="font-weight-bold mb-1"><u> Penghasilan
                                                            </u></h6>
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-left mb-0" style="font-size: 12px">Gaji
                                                                    Pokok</p>
                                                                <p class="text-left mb-0" style="font-size: 12px">
                                                                    Penambahan</p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($e->position->salary,0,'','.') }}
                                                                </p>
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($hasilPenambahan[$row],0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="font-weight-bold mb-1"><u> Potongan
                                                            </u></h6>
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-left mb-0" style="font-size: 12px">
                                                                    Potongan</p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($hasilPotongan[$row],0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-right mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">
                                                                    Total (A)
                                                                </p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                <p class="text-left mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($e->position->salary+$hasilPenambahan[$row] ,0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-right mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">
                                                                    Total (B)
                                                                </p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                <p class="text-left mt-1 mb-0 font-weight-bold"
                                                                    style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($hasilPotongan[$row] ,0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 py-0">
                                                    <div
                                                        class="col-12 bg-primary text-light text-center font-weight-bold py-0">
                                                        <h5 class="py-1 my-0">PENERIMAAN BERSIH
                                                            (A-B)&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;Rp.
                                                            {{ number_format($gajiBersih[$row] ,0,'','.') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @else
                        <tr>
                            <td>{{ $e->user->nip }}</td>
                            <td>{{ $e->full_name }}</td>
                            <td>{{ $e->position->position }}</td>
                            <td>Rp. {{ number_format($e->position->salary,0,'','.') }}</td>
                            <td>Rp. {{ number_format($hasilPenambahan[$row]+$e->position->job_allowance,0,'','.') }}
                            </td>
                            <td>Rp. {{ number_format($hasilPotongan[$row],0,'','.') }}</td>
                            <td>Rp.
                                {{ number_format($e->position->salary+$e->position->job_allowance+$hasilPenambahan[$row]-$hasilPotongan[$row],0,'','.') }}
                            </td>
                            <td class="text-center align-middle">
                                <button title="Info Gaji" type="button" class="btn btn-info btn-sm" style="width: 50px;"
                                    data-toggle="modal" data-target=".bd-example-modal-lg{{ $e->id }}"><i
                                        class="fas fa-info-circle fa-lg"></i></button>
                                @php
                                $c = App\PayrollHistory::where('employee_id', $e->id)->latest('created_at')->first();
                                @endphp
                                @if(empty($c))
                                <form action="{{ url('admin/post/penggajian/'.$e->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="gapok" value={{ $e->position->salary }}>
                                    <input type="hidden" name="penambahan"
                                        value={{ $hasilPenambahan[$row]+$e->position->job_allowance }}>
                                    <input type="hidden" name="potongan" value={{ $hasilPotongan[$row] }}>
                                    <input type="hidden" name="bersih"
                                        value={{ $e->position->salary+$e->position->job_allowance+$hasilPenambahan[$row]-$hasilPotongan[$row] }}>
                                    <button type="submit" class="btn btn-primary btn-sm mt-1" style="width: 50px;"
                                        value="submit" title="Kirim Slip"><i
                                            class="fas fa-paper-plane fa-lg"></i></button>
                                </form>
                                @else
                                @if (Carbon\Carbon::parse($c->created_at)->month != Carbon\Carbon::now()->month)
                                <form action="{{ url('admin/post/penggajian/'.$e->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="gapok" value={{ $e->position->salary }}>
                                    <input type="hidden" name="penambahan"
                                        value={{ $hasilPenambahan[$row]+$e->position->job_allowance }}>
                                    <input type="hidden" name="potongan" value={{ $hasilPotongan[$row] }}>
                                    <input type="hidden" name="bersih"
                                        value={{ $e->position->salary+$e->position->job_allowance+$hasilPenambahan[$row]-$hasilPotongan[$row] }}>
                                    <button type="submit" class="btn btn-primary btn-sm mt-1" style="width: 50px;"
                                        value="submit" title="Kirim Slip"><i
                                            class="fas fa-paper-plane fa-lg"></i></button>
                                </form>
                                @else
                                <button disabled type="submit" class="btn btn-primary btn-sm mt-1" style="width: 50px;"
                                    value="submit" title="Kirim Slip"><i class="fas fa-paper-plane fa-lg"></i></button>
                                @endif
                                @endif
                            </td>

                            <!-- Large modal -->


                            <div class="modal fade bd-example-modal-lg{{ $e->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rekap Gaji {{ $e->full_name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            <div class="row">
                                                <div class="col-9 pl-5">
                                                    <h2 class="text-left text-dark font-weight-bold mb-0 mt-1">
                                                        CakeCode
                                                    </h2>
                                                    <h4 class="text-left text-dark">learn code with
                                                        some cake</h4>
                                                </div>
                                                <div class="col-3 pr-4">
                                                    <img src="{{ asset('img/logoWarna.png') }}" height="80px;">
                                                </div>
                                            </div>
                                            <hr class="sidebar-divider d-none d-md-block">

                                            <div class="container text-monospace">
                                                <div class="row">
                                                    <div class="col-12 mb-1">
                                                        <h6 class="text-center font-weight-bold mb-0"><u> GAJI KARYAWAN
                                                            </u></h6>
                                                        <p class="text-center">Periode 1
                                                            {{ Carbon\Carbon::now()->locale('id')->monthName }}
                                                            {{ $postYear }} -
                                                            {{ Carbon\Carbon::now()->endOfMonth()->day }}
                                                            {{ Carbon\Carbon::now()->locale('id')->monthName }}
                                                            {{ $postYear }}</p>
                                                    </div>
                                                    <br><br><br><br><br>
                                                    <div class="col-3">
                                                        <p class="text-left mb-0" style="font-size: 12px">Nip</p>
                                                        <p class="text-left mb-0" style="font-size: 12px">Nama Lengkap
                                                        </p>
                                                        <p class="text-left mb-0" style="font-size: 12px">Jabatan</p>
                                                    </div>
                                                    <div class="col-5">
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->user->nip }}</p>
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->full_name }}</p>
                                                        <p class="text-left mb-0 font-weight-bold"
                                                            style="font-size: 12px">:
                                                            &nbsp;{{ $e->position->position }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <h6 class="font-weight-bold mb-1"><u> Penghasilan
                                                            </u></h6>
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-left mb-0" style="font-size: 12px">Gaji
                                                                    Pokok</p>
                                                                <p class="text-left mb-0" style="font-size: 12px">
                                                                    Tunjangan Jabatan</p>
                                                                @foreach ($penambahan as $row => $pe)
                                                                @if ($penambahanPerKaryawan[$e->id][$row] != 0)
                                                                <p class="text-left mb-0" style="font-size: 12px">
                                                                    {{ $pe->name }}</p>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($e->position->salary,0,'','.') }}
                                                                </p>
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($e->position->job_allowance,0,'','.') }}
                                                                </p>
                                                                @foreach ($penambahan as $row => $pe)
                                                                @if ($penambahanPerKaryawan[$e->id][$row] != 0)
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($penambahanPerKaryawan[$e->id][$row],0,'','.') }}
                                                                </p>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="font-weight-bold mb-1"><u> Potongan
                                                            </u></h6>
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                @foreach ($potongan as $row => $pe)
                                                                @if ($potonganPerKaryawan[$e->id][$row] != 0)
                                                                <p class="text-left mb-0" style="font-size: 12px">
                                                                    {{ $pe->name }}</p>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                @foreach ($potongan as $row => $pe)
                                                                @if ($potonganPerKaryawan[$e->id][$row] != 0)
                                                                <p class="text-left mb-0" style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($potonganPerKaryawan[$e->id][$row],0,'','.') }}
                                                                </p>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-right mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">
                                                                    Total (A)
                                                                </p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                @php
                                                                $totalPenambahan = 0;
                                                                @endphp
                                                                @foreach ($penambahan as $row => $pe)
                                                                @php
                                                                $totalPenambahan = $totalPenambahan +
                                                                $penambahanPerKaryawan[$e->id][$row];
                                                                @endphp
                                                                @endforeach
                                                                <p class="text-left mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($e->position->salary+$e->position->job_allowance+$totalPenambahan ,0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-7 pr-1">
                                                                <p class="text-right mb-0 mt-1 font-weight-bold"
                                                                    style="font-size: 12px">
                                                                    Total (A)
                                                                </p>
                                                            </div>
                                                            <div class="col-5 p-0">
                                                                @php
                                                                $totalPotongan = 0;
                                                                @endphp
                                                                @foreach ($potongan as $row => $pe)
                                                                @php
                                                                $totalPotongan = $totalPotongan +
                                                                $potonganPerKaryawan[$e->id][$row];
                                                                @endphp
                                                                @endforeach
                                                                <p class="text-left mt-1 mb-0 font-weight-bold"
                                                                    style="font-size: 12px">:
                                                                    &nbsp;Rp.
                                                                    {{ number_format($totalPotongan ,0,'','.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 py-0">
                                                    <div
                                                        class="col-12 bg-primary text-light text-center font-weight-bold py-0">
                                                        <h5 class="py-1 my-0">PENERIMAAN BERSIH
                                                            (A-B)&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;Rp.
                                                            {{ number_format($e->position->salary+$e->position->job_allowance+$totalPenambahan-$totalPotongan ,0,'','.') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            @php
                                            $c = App\PayrollHistory::where('employee_id',
                                            $e->id)->latest('created_at')->first();
                                            @endphp
                                            @if(empty($c))
                                            <form action="{{ url('admin/post/penggajian/'.$e->id)}}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <input type="hidden" name="gapok" value={{ $e->position->salary }}>
                                                <input type="hidden" name="penambahan"
                                                    value={{ $hasilPenambahan[$row]+$e->position->job_allowance }}>
                                                <input type="hidden" name="potongan" value={{ $hasilPotongan[$row] }}>
                                                <input type="hidden" name="bersih"
                                                    value={{ $e->position->salary+$e->position->job_allowance+$hasilPenambahan[$row]-$hasilPotongan[$row] }}>
                                                <button type="submit" class="btn btn-primary mr-0" style="width: 60px;"
                                                    value="submit" title="Kirim Slip"><i
                                                        class="fas fa-paper-plane fa-lg"></i></button>
                                            </form>
                                            @else
                                            @if (Carbon\Carbon::parse($c->created_at)->month !=
                                            Carbon\Carbon::now()->month)
                                            <form action="{{ url('admin/post/penggajian/'.$e->id)}}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <input type="hidden" name="gapok" value={{ $e->position->salary }}>
                                                <input type="hidden" name="penambahan"
                                                    value={{ $hasilPenambahan[$row]+$e->position->job_allowance }}>
                                                <input type="hidden" name="potongan" value={{ $hasilPotongan[$row] }}>
                                                <input type="hidden" name="bersih"
                                                    value={{ $e->position->salary+$e->position->job_allowance+$hasilPenambahan[$row]-$hasilPotongan[$row] }}>
                                                <button type="submit" class="btn btn-primary mr-0" style="width: 60px;"
                                                    title="Kirim Slip"><i class="fas fa-paper-plane fa-lg"></i></button>
                                            </form>
                                            @else
                                            <button disabled type="submit" class="btn btn-primary mr-0"
                                                style="width: 60px;" value="submit" title="Kirim Slip"><i
                                                    class="fas fa-paper-plane fa-lg"></i></button>
                                            @endif
                                            @endif
                                            <form action="{{ url('printPdf/'.$e->id.'/'.$postMonth.'/'.$postYear)}}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning ml-0" style="width: 60px"
                                                    title="Download Slip"><i
                                                        class="fas fa-file-download fa-lg"></i></button>
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@section('foot-link')
<!-- Bootstrap core JavaScript-->
<script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ URL::asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('vendor/datatables/buttons.colVis.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

<script>
    $(function(){
            $(".alert").delay(3000).slideUp(300);
        });
</script>
@endsection