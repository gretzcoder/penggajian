<html>
<!-- Custom fonts for this template-->
<title>Print Pdf</title>

<style>
    .table {
        display: block;
        float: left;
        width: 250px;
    }
</style>

<body>
    <div style="margin: 50px 10px 50px 10px">
        <h1 style="text-align: center; margin-bottom: 5px;">CakeCode</h1>
        <h3 style="text-align: center; margin-top: 5px;">Learn Code With Some Cake</h3>
        <hr>
        <h4 style="text-align: center; margin-top: 5px; margin-bottom: 5px; text-decoration: underline;">GAJI KARYAWAN
        </h4>
        <p style="text-align: center; margin-top: 5px;">Periode 1
            {{ Carbon\Carbon::parse('7-'.$month.'-2020')->locale('id')->monthName }}
            {{ $year }} -
            {{ Carbon\Carbon::parse('10-'.$month.'-'.$year)->endOfMonth()->day }}
            {{ Carbon\Carbon::parse('7-'.$month.'-2020')->locale('id')->monthName }}
            {{ $year }}</p>
        <table style="margin-top: 20px;">
            <tr>
                <td width="100">NIP</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $employee->user->nip }}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $employee->full_name }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $employee->position->position }}</td>
            </tr>
        </table>
        <table style="margin-bottom: 0;">
            <tr>
                <td width="322">
                    <h4 style="margin-top: 15px; margin-bottom: 5px; text-decoration: underline;">
                        Penghasilan
                    </h4>
                </td>
                <td>
                    <h4 style="margin-top: 15px; margin-bottom: 5px; text-decoration: underline;">
                        Potongan
                    </h4>
                </td>
            </tr>
        </table>
        <div style="width: 250px; float: left;">

            <table style="column-width: 235px;">
                <tr>
                    <td width="115">
                        Gaji Pokok
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        Rp. {{ number_format($employee->position->salary,0,'','.') }}
                    </td>
                </tr>
                <tr>
                    <td width="115">
                        Tunjangan Jabatan
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        Rp. {{ number_format($employee->position->job_allowance,0,'','.') }}
                    </td>
                </tr>
                @foreach ($penambahan as $row=>$pe)
                <tr>
                    <td width="115">
                        {{ $pe->name }}
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        Rp. {{ number_format($hasilPenambahan[$row],0,'','.') }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td width="115">
                        <span style="font-weight: bold; text-align: right;"> TOTAL (A) </span>
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        <span style="font-weight: bold;">
                            Rp.{{ number_format($employee->position->salary + $employee->position->job_allowance + $totalA ,0,'','.') }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <div style="width: 250px; float: right">
            <table style="column-width: 235px;">
                @foreach ($potongan as $row=>$po)
                <tr>
                    <td width="115">
                        {{ $po->name }}
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        Rp. {{ number_format($hasilPotongan[$row],0,'','.') }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td width="115">
                        <span style="font-weight: bold; text-align: right;"> TOTAL (B) </span>
                    </td>
                    <td>
                        :
                    </td>
                    <td width="110">
                        <span style="font-weight: bold;">
                            Rp.{{ number_format($totalB ,0,'','.') }}</span>
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear:both;"></div>
        <h3 style="text-align: center; margin-top: 50px; padding-top: 25px;">PENERIMAAN BERSIH =
            Rp.
            {{ number_format($employee->position->salary + $employee->position->job_allowance + $totalA - $totalB,0,'','.') }}
        </h3>
    </div>
    {{-- <div class="row">
        <div class="col-6">
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
                    {{ Carbon\Carbon::parse('7-'.$month.'-2020')->locale('id')->monthName }}
                    {{ $year }} -
                    {{ Carbon\Carbon::parse('10-'.$month.'-'.$year)->endOfMonth()->day }}
                    {{ Carbon\Carbon::parse('7-'.$month.'-2020')->locale('id')->monthName }}
                    {{ $year }}</p>
            </div>
            <br><br><br><br><br>
            <div class="col-3">
                <p class="text-left mb-0" style="font-size: 12px">Nip</p>
                <p class="text-left mb-0" style="font-size: 12px">Nama Lengkap
                </p>
                <p class="text-left mb-0" style="font-size: 12px">Jabatan</p>
            </div>
            <div class="col-5">
                <p class="text-left mb-0 font-weight-bold" style="font-size: 12px">:
                    &nbsp;{{ $employee->user->nip }}</p>
                <p class="text-left mb-0 font-weight-bold" style="font-size: 12px">:
                    &nbsp;{{ $employee->full_name }}</p>
                <p class="text-left mb-0 font-weight-bold" style="font-size: 12px">:
                    &nbsp;{{ $employee->position->position }}
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
                        @foreach ($penambahan as $pe)
                        <p class="text-left mb-0" style="font-size: 12px">
                            {{ $pe->name }}</p>
                        @endforeach
                    </div>
                    <div class="col-5 p-0">
                        <p class="text-left mb-0" style="font-size: 12px">:
                            &nbsp;Rp.
                            {{ number_format($employee->position->salary,0,'','.') }}
                        </p>
                        <p class="text-left mb-0" style="font-size: 12px">:
                            &nbsp;Rp.
                            {{ number_format($employee->position->job_allowance,0,'','.') }}
                        </p>
                        @foreach ($hasilPenambahan as $hpe)
                        <p class="text-left mb-0" style="font-size: 12px">:
                            &nbsp;Rp.
                            {{ number_format($hasilPenambahan[$row],0,'','.') }}
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h6 class="font-weight-bold mb-1"><u> Potongan
                    </u></h6>
                <div class="row">
                    <div class="col-7 pr-1">
                        @foreach ($potongan as $po)
                        <p class="text-left mb-0" style="font-size: 12px">
                            {{ $po->name }}</p>
                        @endforeach
                    </div>
                    <div class="col-5 p-0">
                        @foreach ($hasilPotongan as $hpo)
                        <p class="text-left mb-0" style="font-size: 12px">:
                            &nbsp;Rp.
                            {{ number_format($hpo,0,'','.') }}
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-7 pr-1">
                        <p class="text-right mb-0 mt-1 font-weight-bold" style="font-size: 12px">
                            Total (A)
                        </p>
                    </div>
                    <div class="col-5 p-0">
                        <p class="text-left mb-0 mt-1 font-weight-bold" style="font-size: 12px">:
                            &nbsp;Rp.{{ number_format($employee->position->salary + @foreach($hasilPenambahan as $hpe) $hpe @endforeach ,0,'','.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-7 pr-1">
                        <p class="text-right mb-0 mt-1 font-weight-bold" style="font-size: 12px">
                            Total (B)
                        </p>
                    </div>
                    <div class="col-5 p-0">
                        <p class="text-left mt-1 mb-0 font-weight-bold" style="font-size: 12px">:
                            &nbsp;Rp.{{ number_format(@foreach($hasilPotongan as $hpo) $hpo @endforeach,0,'','.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 py-0">
            <div class="col-12 bg-primary text-light text-center py-0">
                <h5 class="py-1 my-0 font-weight-bold">PENERIMAAN BERSIH
                    (A-B)&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;Rp.
                </h5>
            </div>
        </div>
    </div>

    </div>
    </div> --}}
</body>


</html>