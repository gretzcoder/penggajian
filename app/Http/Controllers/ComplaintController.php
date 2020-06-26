<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\ComplaintImage;
use App\Employee;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    //
    public function indexUser()
    {
        $employee = Employee::where('id', auth()->user()->employee->id)->first();
        $complaints = Complaint::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
        return view('user/komplain', compact('employee', 'complaints'));
    }

    public function indexAdmin()
    {
        $complaints = Complaint::orderBy('created_at', 'desc')->get();
        return view('admin/komplain', compact('complaints'));
    }

    public function postKomplainUser(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'isi' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $complaint =  Complaint::create([
            'subject' => $request->judul,
            'body' => $request->isi,
            'employee_id' => auth()->user()->employee->id,
        ]);

        if (!empty($request->images)) {
            foreach ($request->images as $key => $value) {
                $imageName = time() . $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('img/complaintImg/'), $imageName);
                $complaintImage = new ComplaintImage;
                $complaintImage->complaint_image = $imageName;
                $complaint->complaint_images()->save($complaintImage);
            }
        }

        session()->flash('berhasil', 'Komplain berhasil terkirim!');
        return redirect()->back();
    }

    public function show(Complaint $complaint)
    {
        $complaints = Complaint::where('employee_id', auth()->user()->employee->id)->orderBy('created_at', 'desc')->get();
        return view('user/komplainShow', compact('complaint'));
    }
}
