<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    //
    public function index()
    {
        $positions = Position::get();
        return view('admin/kelolaJabatan', compact('positions'));
    }

    public function show(Position $position)
    {
        $employees = $position->employees()->get();
        return view('admin/showJabatan', compact('position', 'employees'));
    }

    public function create()
    {
        return view('admin/inputJabatan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|unique:positions,position',
            'gaji' => 'required|regex:/[0-9]\./',
            'tunjangan' => 'required|regex:/[0-9]\./',
        ]);
        Position::create([
            'position' => ucfirst($request->jabatan),
            'salary' => str_replace(".", "", $request->gaji),
            'job_allowance' => str_replace(".", "", $request->tunjangan),
        ]);

        session()->flash('jabatan_store', 'Jabatan berhasil ditambahkan.');
        return redirect('admin/jabatan');
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'jabatan' => 'required|max:50|unique:positions,position,' . $position->id,
            'gaji' => 'required|regex:/[0-9]\./',
            'tunjangan' => 'required|regex:/[0-9]\./',
        ]);

        Position::where('id', $position->id)
            ->update([
                'position' => ucfirst($request->jabatan),
                'salary' => str_replace(".", "", $request->gaji),
                'job_allowance' => str_replace(".", "", $request->tunjangan),
            ]);

        session()->flash('jabatan_update', 'Jabatan berhasil dirubah.');
        return redirect()->back();
    }

    public function destroy(Position $position)
    {
        if (count($position->employees) > 0) {
            session()->flash('delete_gagal', 'Ubah Jabatan atau Hapus Pegawai lebih dulu!');
            return redirect()->back();
        }
        Position::where('id', $position->id)->delete();

        session()->flash('deleted', 'Jabatan berhasil dihapus.');
        return redirect('admin/jabatan');
    }
}
