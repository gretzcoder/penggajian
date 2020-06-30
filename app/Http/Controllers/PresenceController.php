<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    //
    public function index()
    {

        $first = Carbon::parse(Presence::latest('id')->first()->datetime)->format('Y-m-d');
        $last = Carbon::parse(Presence::latest('id')->first()->datetime)->format('Y-m-d');
        $min = Carbon::parse(Presence::get()->first()->datetime)->format('Y-m-d');
        $max = Carbon::parse(Presence::latest('id')->first()->datetime)->format('Y-m-d');
        $presences = Presence::where('created_at', '>=', $max)->get();

        if (session()->has('first')) {
            $first = session()->get('first');
            $last = session()->get('last');
            $presences = Presence::where('created_at', '<', Carbon::parse($last)->addDay())->where('created_at', '>=', $first)->get();
        }

        return view('admin/presensi', compact('first', 'last', 'min', 'max', 'presences'));
    }

    public function indexSearch(Request $request)
    {
        $first = $request->tanggalAwal;
        $last = $request->tanggal;
        $min = Carbon::parse(Presence::get()->first()->datetime)->format('Y-m-d');
        $max = Carbon::parse(Presence::latest('id')->first()->datetime)->format('Y-m-d');
        $presences = Presence::where('created_at', '<', Carbon::parse($last)->addDay())->where('created_at', '>=', $first)->get();
        return view('admin/presensi', compact('first', 'last', 'min', 'max', 'presences'));
    }

    public function edit(Request $request)
    {
        $data = Presence::where('id', $request->id)->first();
        $first = $request->first;
        $last = $request->last;

        return view('admin/editPresensi', compact('data', 'first', 'last'));
    }

    public function update(Request $request, Presence $presence)
    {
        $presensi = Presence::find($presence->id);
        $presensi->status = $request->status;
        $presensi->save();

        session()->flash('presensi_update', 'Presensi berhasil dirubah.');
        return redirect('admin/presensi')->with(['first' => $request->first, 'last' => $request->last]);
    }

    public function indexUser()
    {

        if (!is_null(Presence::where('employee_id', auth()->user()->employee->id)->latest('id')->first())) {
            if (Carbon::parse(Presence::where('employee_id', auth()->user()->employee->id)->latest('id')->first()->created_at)->toDateString() == Carbon::now()->toDateString() && Presence::where('employee_id', auth()->user()->employee->id)->latest('created_at')->first()->datetime != null) {
                session()->flash('sudah', 'ANDA SUDAH ABSEN');
            }
        }

        $presences = Presence::where('employee_id', auth()->user()->employee->id)->latest('id')->limit(5)->get();
        return view('user/presensi', compact('presences'));
    }


    public function postPresensi()
    {
        if (Carbon::now()->isWeekday()) {
            if (!is_null(Presence::where('employee_id', auth()->user()->employee->id)->latest('id')->first())) {
                if (Carbon::parse(Presence::where('employee_id', auth()->user()->employee->id)->latest('id')->first()->created_at)->toDateString() != Carbon::now()->toDateString()) {
                    $d = Carbon::now();
                    Presence::create([
                        'datetime' => $d->toTimeString() <= '08:00:00' || $d->toTimeString() >= '10:00:00'  ? null : $d->toDatetimeString(),
                        'employee_id' => auth()->user()->employee->id,
                        'status' => ($d->toTimeString() >= '08:00:00' && $d->toTimeString() <= '09:00:00'  ? 'h' : ($d->toTimeString() >= '09:00:00' && $d->toTimeString() <= '10:00:00' ? 't' : 'a')),
                    ]);
                }
            } else {
                $d = Carbon::now();
                Presence::create([
                    'datetime' => $d->toTimeString() <= '08:00:00' || $d->toTimeString() >= '10:00:00'  ? null : $d->toDatetimeString(),
                    'employee_id' => auth()->user()->employee->id,
                    'status' => ($d->toTimeString() >= '08:00:00' && $d->toTimeString() <= '09:00:00'  ? 'h' : ($d->toTimeString() >= '09:00:00' && $d->toTimeString() <= '10:00:00' ? 't' : 'a')),
                ]);
            }
        }
        return redirect('presensi');
    }

    public function rekapPresensi()
    {
        $id = auth()->user()->employee->id;

        $monthBefore = Carbon::now()->startOfMonth();
        $monthafter = Carbon::now()->endOfMonth();

        $presences = Presence::where([['employee_id', $id], ['created_at', '>=', $monthBefore], ['created_at', '<=', $monthafter]])->get();
        $date = Presence::where([['employee_id', $id]])->get();
        $month = array();
        $year = array();
        foreach ($date as $d) {
            $month[] = Carbon::parse($d->created_at)->month;
            $year[] = Carbon::parse($d->created_at)->year;
        }

        $monthUnique = array_unique($month);
        $yearUnique = array_unique($year);

        return view('user/rekapPresensi', compact('presences', 'monthUnique', 'yearUnique'));
    }

    public function rekapPresensiSearch(Request $request)
    {
        $id = auth()->user()->employee->id;

        $monthBefore = Carbon::parse('15-' . $request->month . '-' . $request->year)->startOfMonth();
        $monthafter = Carbon::parse('15-' . $request->month . '-' . $request->year)->endOfMonth();

        $presences = Presence::where([['employee_id', $id], ['created_at', '>=', $monthBefore], ['created_at', '<=', $monthafter]])->get();
        $date = Presence::where([['employee_id', $id]])->get();
        $month = array();
        $year = array();
        foreach ($date as $d) {
            $month[] = Carbon::parse($d->created_at)->month;
            $year[] = Carbon::parse($d->created_at)->year;
        }

        $monthUnique = array_unique($month);
        $yearUnique = array_unique($year);

        return view('user/rekapPresensi', compact('presences', 'monthUnique', 'yearUnique'));
    }
}
