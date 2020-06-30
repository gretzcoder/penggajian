<?php

namespace App\Http\Controllers;

use App\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllowanceController extends Controller
{
    public function index()
    {
        $penambahan = Allowance::where('type', 'penambahan')->get();
        $potongan = Allowance::where('type', 'potongan')->get();
        // foreach ($penambahan as $i) {
        //     echo $i->hitungPotongan;
        // }
        // die;
        return view('admin/penambahanPotongan', compact('penambahan', 'potongan'));
    }

    public function storePenambahan(Request $request)
    {
        if (empty($request->sp)) {
            $request->sp = 1;
        }

        $request->validate([
            'np' => 'required|unique:allowances,name|max:100',
            'rp' => 'required|regex:/[0-9\+\-\*\/\(\)\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/',
            'sp' => 'regex:/[0-9\+\-\*\/\(\)\=\<\>\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/|nullable'
        ]);


        Allowance::create([
            'name' => $request->np,
            'formula' => $request->rp,
            'condition' => $request->sp,
            'type' => 'penambahan',
        ]);
        session()->flash('penambahan', 'Berhasil ditambahkan.');
        return redirect()->back();
    }

    public function storePotongan(Request $request)
    {

        if (empty($request->spo)) {
            $request->spo = 1;
        }

        $request->validate([
            'npo' => 'required|unique:allowances,name|max:100',
            'rpo' => 'required|regex:/[0-9\+\-\*\/\(\)\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/',
            'spo' => 'regex:/[0-9\+\-\*\/\(\)\=\<\>\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/|nullable'
        ]);

        Allowance::create([
            'name' => $request->npo,
            'formula' => $request->rpo,
            'condition' => $request->spo,
            'type' => 'potongan',
        ]);

        session()->flash('potongan', 'Berhasil ditambahkan.');
        return redirect()->back();
    }

    public function patchPotongan(Request $request, Allowance $allowance)
    {

        if (empty($request->spot)) {
            $request->spot = 1;
        }

        $validator = Validator::make($request->all(), [
            'npot' => 'required|exists:allowances,name|max:100',
            'rpot' => 'required|regex:/[0-9\+\-\*\/\(\)\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/',
            'spot' => 'regex:/[0-9\+\-\*\/\(\)\=\<\>\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/|nullable'
        ]);

        if ($validator->fails()) {
            session()->flash('gagal_potongan', 'Gagal dirubah.');
            return redirect()->back()->withErrors($validator)
                ->withInput();;
        }

        Allowance::where('id', $allowance->id)->update([
            'name' => $request->npot,
            'formula' => $request->rpot,
            'condition' => $request->spot,
            'type' => 'potongan',
        ]);

        session()->flash('updated_potongan', 'Berhasil dirubah.');
        return redirect()->back();
    }

    public function patchPenambahan(Request $request, Allowance $allowance)
    {

        if (empty($request->spe)) {
            $request->spe = 1;
        }

        $validator = Validator::make($request->all(), [
            'npe' => 'required|exists:allowances,name|max:100',
            'rpe' => 'required|regex:/[0-9\+\-\*\/\(\)\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]//',
            'spe' => 'regex:/[0-9\+\-\*\/\(\)\=\<\>\g\h\a\t\m\c ]/|not_regex:/[bdefijklnopqrsuvwxyz]/|nullable'
        ]);

        if ($validator->fails()) {
            session()->flash('gagal_penambahan', 'Gagal dirubah.');
            return redirect()->back()->withErrors($validator)
                ->withInput();;
        }

        Allowance::where('id', $allowance->id)->update([
            'name' => $request->npe,
            'formula' => $request->rpe,
            'condition' => $request->spe,
            'type' => 'penambahan',
        ]);

        session()->flash('updated_penambahan', 'Berhasil dirubah.');
        return redirect()->back();
    }

    public function destroy(Allowance $allowance)
    {
        if ($allowance->type == 'penambahan') {
            session()->flash('deleted_penambahan', 'Data berhasil dihapus.');
        } else {
            session()->flash('deleted_potongan', 'Data berhasil dihapus.');
        }

        Allowance::where('id', $allowance->id)->delete();

        return redirect('admin/penambahan-potongan');
    }
}
