@extends('layouts.user')

@section('title', 'Rekap Presensi'. auth()->user()->employee->full_name)

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
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row align-middle justify-content-between mx-3">
        <div class="col-6">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Presensi {{ auth()->user()->employee->full_name }}</h1>
            <p class="mb-4">Seluruh data Presensi {{ auth()->user()->employee->full_name }} CakeCode</p>
        </div>
        {{-- <td><a href="#" class="status" data-type="select" data-pk="1" data-value="1" data-url="{{ url('api/admin/active') }}"
        data-title="Select status"></a></td> --}}
        <div class="col-4 justify-content-end">
            <form action={{ url('presensi/rekap-presensi') }} method="post">
                <div class="input-group mr-3 mt-3" style="height: 48px;">
                    @csrf
                    <select name="month" class="custom-select text-primary text-center"
                        style="text-align: center; font-weight: bolder; width: 125px;">
                        @foreach ($monthUnique as $m)
                        @if(Carbon\Carbon::parse('7-'.$m.'-2020')->month !=
                        Carbon\Carbon::parse($presences[0]->created_at)->month)
                        <option class="text-center" value="{{ Carbon\Carbon::parse('1-'.$m.'-2020')->month }}">
                            {{ Carbon\Carbon::parse('7-'.$m.'-2020')->locale('id')->monthName }}</option>
                        @else
                        <option selected class="text-center"
                            value="{{ Carbon\Carbon::parse($presences[0]->created_at)->month }}">
                            {{ Carbon\Carbon::parse($presences[0]->created_at)->locale('id')->monthName }}</option>
                        @endif
                        @endforeach
                    </select>
                    <select name="year" class="custom-select text-primary mr-3"
                        style="text-align: center; font-weight: bolder;">
                        @foreach ($yearUnique as $y)
                        @if(Carbon\Carbon::parse('7-8-'.$y)->year !=
                        Carbon\Carbon::parse($presences[0]->created_at)->year)
                        <option class="text-center" value="{{ Carbon\Carbon::parse('7-8-'.$y)->year }}">
                            {{ Carbon\Carbon::parse('7-8-'.$y)->year }}</option>
                        @else
                        <option selected class="text-center"
                            value="{{ Carbon\Carbon::parse($presences[0]->created_at)->year }}">
                            {{ Carbon\Carbon::parse($presences[0]->created_at)->year }}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="submit" class="btn btn-sm btn-primary" style="height: 38px;" value="submit">
                </div>
            </form>
        </div>

    </div>
    @if (session()->has('presensi_update'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('presensi_update') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableAbsensiUser" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presences as $presence)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($presence->created_at)->locale('id')->dayName }}</td>
                            <td><span
                                    style="display:none;">{{ Carbon\Carbon::parse($presence->created_at)->getTimestamp() }}</span>
                                {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->day }}
                                {{ Carbon\Carbon::parse($presence->created_at)->locale('id')->monthName }}
                                {{ Carbon\Carbon::parse($presence->created_at)->year }}</td>
                            <td>{{ $presence->datetime ? Carbon\Carbon::parse($presence->datetime)->toTimeString() : '-' }}
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

<!-- Page level custom scripts -->
<script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

<script>
    $(function(){            
            $(".alert").delay(3000).slideUp(300);
        });
</script>
@endsection