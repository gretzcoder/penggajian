<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\Employee;
use App\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    public function dashboard()
    {
        $employees = Employee::get();
        foreach ($employees as $employee) {
            $id = $employee->id;
            $employee = \App\Employee::find($id);
            if (!is_null(Presence::where('employee_id', $id)->latest('id')->first())) {
                if (Carbon::now()->toDateTimeString() > Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at)->addDay()->toDateString() . " 10:00:00") {
                    $last = Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at);
                    $a = Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at)->diffInDays(Carbon::now());
                    if (Carbon::now()->toTimeString() < '10:00:00') {
                        $a = $a - 1;
                    }
                    $b = 1;
                    $c = 1;
                    for ($i = 1; $i <= $a; $i++) {
                        if ($last->addDays($i)->isWeekDay()) {
                            Presence::create([
                                'datetime' => null,
                                'employee_id' => $id,
                                'status' => 'a',
                                'created_at' => $last->toDateTimeString()
                            ]);
                            $last = Carbon::parse(Presence::where('employee_id', $id)->orderBy('id', 'desc')->skip($b)->take(1)->first()->created_at);
                            $b++;
                        } else {
                            $last = Carbon::parse(Presence::where('employee_id', $id)->orderBy('id', 'desc')->skip($i - $c)->take(1)->first()->created_at);
                            $c++;
                        }
                    }
                }
            } elseif (Carbon::now()->toDateTimeString() > Carbon::parse($employee->created_at)->toDateString() . '10:00:00') {
                $a = Carbon::parse($employee->created_at)->diffInDays(Carbon::now());
                $i = 1;

                for ($i; $i <= $a; $i++) {
                    if (Carbon::parse($employee->created_at)->addDays($i)->isWeekDay()) {
                        Presence::create([
                            'datetime' => null,
                            'employee_id' => $id,
                            'status' => 'a',
                            'created_at' => Carbon::parse($employee->created_at)->addDays($i)->toDateTimeString()
                        ]);
                    }
                }
            }
        }
        $komplen = Complaint::where('created_at', '<=', Carbon::now()->toDateTimeString())->where('created_at', '>=', Carbon::now()->startOfDay())->get();
        $absen = Presence::where('created_at', '<=', Carbon::now()->toDateTimeString())->where('created_at', '>=', Carbon::now()->startOfDay())->where('status', 'a')->get();
        $terlambat = Presence::where('created_at', '<=', Carbon::now()->toDateTimeString())->where('created_at', '>=', Carbon::now()->startOfDay())->where('status', 't')->get();

        return view('admin/dashboard', compact('komplen', 'absen', 'terlambat'));
    }
    public function index()
    {
        return view('admin/dataKaryawan');
    }

    public function show(Employee $employee)
    {
        return view('admin/detailKaryawan', compact('employee'));
    }

    public function profile()
    {
        $id = auth()->user()->employee->id;
        $employee = \App\Employee::find($id);
        if (!is_null(Presence::where('employee_id', $id)->latest('id')->first())) {
            if (Carbon::now()->toDateTimeString() > Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at)->addDay()->toDateString() . " 10:00:00") {
                $last = Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at);
                $a = Carbon::parse(Presence::where('employee_id', $id)->latest('id')->first()->created_at)->diffInDays(Carbon::now());
                if (Carbon::now()->toTimeString() < '10:00:00') {
                    $a = $a - 1;
                }
                $b = 1;
                $c = 1;
                for ($i = 1; $i <= $a; $i++) {
                    if ($last->addDays($i)->isWeekDay()) {
                        Presence::create([
                            'datetime' => null,
                            'employee_id' => $id,
                            'status' => 'a',
                            'created_at' => $last->toDateTimeString()
                        ]);
                        $last = Carbon::parse(Presence::where('employee_id', $id)->orderBy('id', 'desc')->skip($b)->take(1)->first()->created_at);
                        $b++;
                    } else {
                        $last = Carbon::parse(Presence::where('employee_id', $id)->orderBy('id', 'desc')->skip($i - $c)->take(1)->first()->created_at);
                        $c++;
                    }
                }
            }
        } elseif (Carbon::now()->toDateTimeString() > Carbon::parse($employee->created_at)->toDateString() . '10:00:00') {
            $a = Carbon::parse($employee->created_at)->diffInDays(Carbon::now());
            $i = 1;

            for ($i; $i <= $a; $i++) {
                if (Carbon::parse($employee->created_at)->addDays($i)->isWeekDay()) {
                    Presence::create([
                        'datetime' => null,
                        'employee_id' => $id,
                        'status' => 'a',
                        'created_at' => Carbon::parse($employee->created_at)->addDays($i)->toDateTimeString()
                    ]);
                }
            }
        }

        return view('user/profile', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser()
    {
        $id = auth()->user()->employee->id;
        $employee = \App\Employee::find($id);
        return view('user/editProfile', compact('employee'));
    }

    public function editAdmin(Employee $employee)
    {
        return view('admin/editProfile', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $id = auth()->user()->employee->id;

        $request->validate([
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = \App\Employee::find($id);

        if (!is_null($request->pernikahan) && auth()->user()->employee->marital_status == null) {
            $request->validate([
                'pernikahan' => 'required|numeric',
                'anak' => 'required|numeric',
            ]);

            if ($request->pernikahan == 0) {
                $request->anak = 0;
            }

            $employee->marital_status = $request->pernikahan;
            $employee->number_of_children = $request->anak;
        }

        if (!empty($request->image)) {
            $imageName = auth()->user()->employee->full_name . '.' . $request->image->extension();
            $request->image->move(public_path('img/employeePic/'), $imageName);
            $employee->profile_pic = $imageName;
        } else if ($request->alamat == auth()->user()->employee->address && $request->telp == auth()->user()->employee->phone) {
            session()->flash('profile_update_nochanges', 'Tidak ada data profile yang dirubah.');
            return redirect()->back();
        }

        $employee->address = $request->alamat;
        $employee->phone = $request->telp;
        $employee->save();

        session()->flash('profile_update', 'Profile berhasil dirubah.');
        return redirect()->back();
    }

    public function updateProfileFromAdmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'pernikahan' => 'required|numeric',
            'anak' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->pernikahan == 0) {
            $request->anak = 0;
        }

        $employee = \App\Employee::find($id);

        if (!empty($request->image)) {
            $imageName = $request->nama . '.' . $request->image->extension();
            $request->image->move(public_path('img/employeePic/'), $imageName);
            $employee->profile_pic = $imageName;
        }

        $employee->full_name = $request->nama;
        $employee->position_id = $request->posisi;
        $employee->address = $request->alamat;
        $employee->phone = $request->telp;
        $employee->marital_status = $request->pernikahan;
        $employee->number_of_children = $request->anak;
        $employee->save();

        session()->flash('profile_update', 'Profile berhasil dirubah.');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $id = auth()->user()->employee->id;


        $request->validate([
            'password' => 'required|same:cpassword|min:8',
            'cpassword' => 'required|min:8',
            'oldpassword' => 'required',
        ]);

        if (!Hash::check($request->oldpassword, auth()->user()->password)) {
            session()->flash('password_salah', 'Password lama yang anda masukan salah.');
            return redirect()->back();
        }

        $user = \App\User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();

        session()->flash('password_update', 'Password berhasil dirubah.');
        return redirect()->back();
    }

    public function updatePasswordFromAdmin(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|same:cpassword|min:8',
            'cpassword' => 'required|min:8',
        ]);

        $user = \App\User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();

        session()->flash('password_update', 'Password berhasil dirubah.');
        return redirect()->back();
    }

    public function updateJabatan(Request $request, Employee $employee)
    {
        $request->validate([
            'posisi' => 'required|exists:positions,id'
        ]);

        Employee::where('id', $employee->id)
            ->update([
                'position_id' => $request->posisi,
            ]);

        session()->flash('pegawai_update', 'Berhasil dirubah.');
        return redirect()->back();
    }
}
