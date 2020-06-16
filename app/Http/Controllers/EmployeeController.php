<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
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
}
