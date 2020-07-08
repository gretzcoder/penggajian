<?php

namespace App\Http\Controllers;

use App\Allowance;
use App\Employee;
use App\PayrollHistory;
use App\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \PDF;

class PayrollHistoryController extends Controller
{
    public function index()
    {
        //penanggalan
        $now = Carbon::now();
        $firstMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->endOfMonth();
        $postMonth = Carbon::now()->month;
        $postYear = Carbon::now()->year;

        $date = Presence::get();

        $month = array();
        $year = array();
        foreach ($date as $d) {
            $month[] = Carbon::parse($d->created_at)->month;
            $year[] = Carbon::parse($d->created_at)->year;
        }
        if (count($date) == 0) {
            $month[] = Carbon::now()->month;
            $year[] = Carbon::now()->year;
        }

        //penambahan
        $penambahan = Allowance::where('type', 'penambahan')->get();
        $potongan = Allowance::where('type', 'potongan')->get();
        $employees = Employee::get();

        $hasilPenambahan = array();
        $hasilPotongan = array();
        $penambahanPerKaryawan = array();
        $potonganPerKaryawan = array();
        foreach ($employees as $emplyee) {
            $pe = 0;
            $po = 0;
            foreach ($penambahan as $nambah) {
                $pe = $pe + $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                $penambahanPerKaryawan[$emplyee->id][] = $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
            }
            foreach ($potongan as $potong) {
                $po = $po + $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                $potonganPerKaryawan[$emplyee->id][] = $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
            }
            $hasilPenambahan[] = $pe;
            $hasilPotongan[] = $po;
        }

        $monthUnique = array_unique($month);
        $yearUnique = array_unique($year);

        return view('admin/penggajian', compact('employees', 'monthUnique', 'yearUnique', 'firstMonth', 'lastMonth', 'postMonth', 'postYear', 'hasilPenambahan', 'hasilPotongan', 'potonganPerKaryawan', 'penambahanPerKaryawan', 'penambahan', 'potongan'));
    }

    public function indexPost(Request $request)
    {
        //penanggalan
        $now = Carbon::now();
        $firstMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->startOfMonth();
        $lastMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->endOfMonth();
        $postMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->month;
        $postYear = Carbon::parse('15-' . $request->month . '-' . $request->year)->year;

        if ($request->month == Carbon::now()->month) {

            $date = Presence::get();

            $month = array();
            $year = array();
            foreach ($date as $d) {
                $month[] = Carbon::parse($d->created_at)->month;
                $year[] = Carbon::parse($d->created_at)->year;
            }
            if (count($date) == 0) {
                $month[] = Carbon::now()->month;
                $year[] = Carbon::now()->year;
            }

            //penambahan
            $penambahan = Allowance::where('type', 'penambahan')->get();
            $potongan = Allowance::where('type', 'potongan')->get();
            $employees = Employee::get();

            $hasilPenambahan = array();
            $hasilPotongan = array();
            $penambahanPerKaryawan = array();
            $potonganPerKaryawan = array();
            foreach ($employees as $emplyee) {
                $pe = 0;
                $po = 0;
                foreach ($penambahan as $nambah) {
                    $pe = $pe + $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                    $penambahanPerKaryawan[$emplyee->id][] = $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                }
                foreach ($potongan as $potong) {
                    $po = $po + $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                    $potonganPerKaryawan[$emplyee->id][] = $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                }
                $hasilPenambahan[] = $pe;
                $hasilPotongan[] = $po;
            }

            $gajiBersih = 0;
            $monthUnique = array_unique($month);
            $yearUnique = array_unique($year);
        } else {
            $employees = Employee::where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->get();
            $hasilPenambahan = array();
            $hasilPotongan = array();
            $potonganPerKaryawan = array();
            $penambahanPerKaryawan = array();
            $potongan = array();
            $penambahan = array();
            $gajiBersih = array();
            foreach ($employees as $employee) {
                foreach ($employee->payrollHistories->where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->all() as $row => $gaji) {
                    $hasilPenambahan[] = $gaji->penambahan;
                    $hasilPotongan[] = $gaji->potongan;
                    $potonganPerKaryawan[$employee->id][] = $gaji->potongan;
                    $penambahanPerKaryawan[$employee->id][] = $gaji->penambahan;
                    $potongan[] = $gaji->potongan;
                    $penambahan[] = $gaji->penambahan;
                    $gajiBersih[] = $gaji->gaji_bersih;
                }
            }

            $date = Presence::get();

            $month = array();
            $year = array();
            foreach ($date as $d) {
                $month[] = Carbon::parse($d->created_at)->month;
                $year[] = Carbon::parse($d->created_at)->year;
            }
            if (count($date) == 0) {
                $month[] = Carbon::now()->month;
                $year[] = Carbon::now()->year;
            }

            $monthUnique = array_unique($month);
            $yearUnique = array_unique($year);
        }


        return view('admin/penggajian', compact('gajiBersih', 'employees', 'monthUnique', 'yearUnique', 'firstMonth', 'lastMonth', 'postMonth', 'postYear', 'hasilPenambahan', 'hasilPotongan', 'potonganPerKaryawan', 'penambahanPerKaryawan', 'penambahan', 'potongan'));
    }

    public function indexPostUser(Request $request)
    {
        //penanggalan
        $now = Carbon::now();
        $firstMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->startOfMonth();
        $lastMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->endOfMonth();
        $postMonth = Carbon::parse('15-' . $request->month . '-' . $request->year)->month;
        $postYear = Carbon::parse('15-' . $request->month . '-' . $request->year)->year;

        if ($request->month == Carbon::now()->month) {

            $date = Presence::get();

            $month = array();
            $year = array();
            foreach ($date as $d) {
                $month[] = Carbon::parse($d->created_at)->month;
                $year[] = Carbon::parse($d->created_at)->year;
            }
            if (count($date) == 0) {
                $month[] = Carbon::now()->month;
                $year[] = Carbon::now()->year;
            }

            //penambahan
            $penambahan = Allowance::where('type', 'penambahan')->get();
            $potongan = Allowance::where('type', 'potongan')->get();
            $employees = Employee::where('id', auth()->user()->employee->id)->get();

            $hasilPenambahan = array();
            $hasilPotongan = array();
            $penambahanPerKaryawan = array();
            $potonganPerKaryawan = array();
            foreach ($employees as $emplyee) {
                $pe = 0;
                $po = 0;
                foreach ($penambahan as $nambah) {
                    $pe = $pe + $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                    $penambahanPerKaryawan[$emplyee->id][] = $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                }
                foreach ($potongan as $potong) {
                    $po = $po + $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                    $potonganPerKaryawan[$emplyee->id][] = $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                }
                $hasilPenambahan[] = $pe;
                $hasilPotongan[] = $po;
            }

            $gajiBersih = 0;
            $monthUnique = array_unique($month);
            $yearUnique = array_unique($year);
        } else {
            $employees = Employee::where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->where('id', auth()->user()->employee->id)->get();
            $hasilPenambahan = array();
            $hasilPotongan = array();
            $potonganPerKaryawan = array();
            $penambahanPerKaryawan = array();
            $potongan = array();
            $penambahan = array();
            $gajiBersih = array();
            foreach ($employees as $employee) {
                foreach ($employee->payrollHistories->where('created_at', '>=', $firstMonth)->where('created_at', '<=', $lastMonth)->all() as $row => $gaji) {
                    $hasilPenambahan[] = $gaji->penambahan;
                    $hasilPotongan[] = $gaji->potongan;
                    $potonganPerKaryawan[$employee->id][] = $gaji->potongan;
                    $penambahanPerKaryawan[$employee->id][] = $gaji->penambahan;
                    $potongan[] = $gaji->potongan;
                    $penambahan[] = $gaji->penambahan;
                    $gajiBersih[] = $gaji->gaji_bersih;
                }
            }

            $date = Presence::get();

            $month = array();
            $year = array();
            foreach ($date as $d) {
                $month[] = Carbon::parse($d->created_at)->month;
                $year[] = Carbon::parse($d->created_at)->year;
            }
            if (count($date) == 0) {
                $month[] = Carbon::now()->month;
                $year[] = Carbon::now()->year;
            }

            $monthUnique = array_unique($month);
            $yearUnique = array_unique($year);
        }


        return view('user/penggajian', compact('gajiBersih', 'employees', 'monthUnique', 'yearUnique', 'firstMonth', 'lastMonth', 'postMonth', 'postYear', 'hasilPenambahan', 'hasilPotongan', 'potonganPerKaryawan', 'penambahanPerKaryawan', 'penambahan', 'potongan'));
    }

    public function store(Employee $employee, Request $request)
    {
        // dd(PayrollHistory::where('employee_id', $employee->id)->latest('id')->first()->created_at);
        foreach (PayrollHistory::where('employee_id', $employee->id)->get() as $c) {
            if (Carbon::parse($c->created_at)->month == Carbon::now()->month && Carbon::parse($c->created_at)->month == Carbon::parse(PayrollHistory::where('employee_id', $employee->id)->latest('id')->first()->created_at)->month) {
                session()->flash('sudah', 'Sudah pernah dikirim');
                return redirect('admin/penggajian');
            }
        }
        if (Carbon::now()->endOfMonth()->diffInDays(Carbon::now()) >= 7) {
            session()->flash('not_time', 'Belum Waktunya');
            return redirect('admin/penggajian');
        }

        PayrollHistory::create([
            'employee_id' => $employee->id,
            'gaji_pokok' => $request->gapok,
            'penambahan' => $request->penambahan,
            'potongan' => $request->potongan,
            'gaji_bersih' => $request->bersih
        ]);


        session()->flash('time', 'Berhasil Terkirim.');
        return redirect('admin/penggajian');
    }

    public function indexUser()
    {
        //penanggalan
        $now = Carbon::now();
        $firstMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->endOfMonth();
        $postMonth = Carbon::now()->month;
        $postYear = Carbon::now()->year;

        $date = Presence::where('employee_id', auth()->user()->employee->id)->get();

        $month = array();
        $year = array();
        foreach ($date as $d) {
            $month[] = Carbon::parse($d->created_at)->month;
            $year[] = Carbon::parse($d->created_at)->year;
        }
        if (count($date) == 0) {
            $month[] = Carbon::now()->month;
            $year[] = Carbon::now()->year;
        }

        //penambahan
        $penambahan = Allowance::where('type', 'penambahan')->get();
        $potongan = Allowance::where('type', 'potongan')->get();
        $employees = Employee::where('id', auth()->user()->employee->id)->get();

        $hasilPenambahan = array();
        $hasilPotongan = array();
        $penambahanPerKaryawan = array();
        $potonganPerKaryawan = array();
        foreach ($employees as $emplyee) {
            $pe = 0;
            $po = 0;
            foreach ($penambahan as $nambah) {
                $pe = $pe + $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                $penambahanPerKaryawan[$emplyee->id][] = $nambah->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
            }
            foreach ($potongan as $potong) {
                $po = $po + $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
                $potonganPerKaryawan[$emplyee->id][] = $potong->hitungPenambahanPotongan($emplyee, $firstMonth, $lastMonth);
            }
            $hasilPenambahan[] = $pe;
            $hasilPotongan[] = $po;
        }
        // dd($hasilPenambahan);
        $monthUnique = array_unique($month);
        $yearUnique = array_unique($year);


        return view('user/penggajian', compact('employees', 'monthUnique', 'yearUnique', 'firstMonth', 'lastMonth', 'postMonth', 'postYear', 'hasilPenambahan', 'hasilPotongan', 'potonganPerKaryawan', 'penambahanPerKaryawan', 'penambahan', 'potongan'));
    }

    public function printPDF(Employee $employee, $month, $year)
    {
        $penambahan = Allowance::where('type', 'penambahan')->get();
        $potongan = Allowance::where('type', 'potongan')->get();

        $firstMonth = Carbon::parse('15-' . $month . '-' . $year)->startOfMonth();
        $lastMonth = Carbon::parse('15-' . $month . '-' . $year)->endOfMonth();

        $hasilPenambahan = array();
        $hasilPotongan = array();

        $totalA = 0;
        $totalB = 0;
        foreach ($penambahan as $nambah) {
            $hasilPenambahan[] = $nambah->hitungPenambahanPotongan($employee, $firstMonth, $lastMonth);
            $totalA = $totalA + $nambah->hitungPenambahanPotongan($employee, $firstMonth, $lastMonth);
        }
        foreach ($potongan as $potong) {
            $hasilPotongan[] = $potong->hitungPenambahanPotongan($employee, $firstMonth, $lastMonth);
            $totalB = $totalB + $potong->hitungPenambahanPotongan($employee, $firstMonth, $lastMonth);
        }


        set_time_limit(300);
        $nama = strtolower("slip-gaji-" . $employee->user->nip . "-" .
            Carbon::parse('15-' . $month . '-' . $year)->locale('id')->monthName . "-" . Carbon::parse('15-' . $month . '-' . $year)->year .  ".pdf");
        $pdf = PDF::loadView('printSlipGaji', compact('employee', 'month', 'year', 'hasilPenambahan', 'hasilPotongan', 'penambahan', 'potongan', 'totalA', 'totalB'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($nama);


        return view('printSlipGaji', compact('employee', 'month', 'year', 'hasilPenambahan', 'hasilPotongan', 'penambahan', 'potongan', 'totalA', 'totalB'));
    }
}
