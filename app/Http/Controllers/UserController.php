<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', '1')->get();
        return view('admin/kelolaAkun', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/inputAkun');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|size:8|unique:users,nip',
            'fullname' => 'required',
            'position' => 'required'
        ]);

        $user = new User;
        $user->nip = $request->nip;
        $user->password = bcrypt('cakecode');
        $user->is_active = 1;
        $user->save();
        $id = $user->id;

        $employee = new Employee;
        $employee->full_name = $request->fullname;
        $employee->user_id = $id;
        $employee->position_id = $request->position;
        $employee->save();

        session()->flash('akun_store', 'Akun berhasil dibuat.');
        return redirect('admin/akun/kelola-akun');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akun = User::find($id);
        $akun->delete();

        session()->flash('deleted', 'Akun berhasil dihapus.');

        return redirect()->back();
    }

    public function updateIsActive(Request $request)
    {
        $findId = User::find($request->pk);
        $findIsActive = $request->value;
        if ($findIsActive == 2) {
            $findId->is_active = 0;
            $findId->save();
            return true;
        } else {
            $findId->is_active = 1;
            $findId->save();
            return true;
        }
    }
}
