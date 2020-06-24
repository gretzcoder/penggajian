<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    //
    public function indexUser()
    {
        $employee = Employee::find(auth()->user()->employee->id)->first();
        return view('user/komplain', compact('employee'));
    }

    public function postKomplainUser(Request $request)
    {
        request()->validate([

            'uploadFile' => 'required',

        ]);


        foreach ($request->file('uploadFile') as $key => $value) {

            $imageName = time() . $key . '.' . $value->getClientOriginalExtension();
            echo $imageName;
        }
        die;

        return response()->json(['success' => 'Images Uploaded Successfully.']);
    }
}
