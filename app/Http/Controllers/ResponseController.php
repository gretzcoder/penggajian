<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\Response;
use App\ResponseImage;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function show(Complaint $complaint)
    {
        return view('admin/response', compact('complaint'));
    }

    public function store(Request $request, Complaint $complaint)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'isi' => 'required',
            'status' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $response = Response::create([
            'complaint_id' => $complaint->id,
            'subject' => $request->judul,
            'response' => $request->isi,
            'status' => $request->status
        ]);

        if (!empty($request->images)) {
            foreach ($request->images as $key => $value) {
                $imageName = time() . $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('img/responseImg/'), $imageName);
                $responseImage = new ResponseImage;
                $responseImage->response_image = $imageName;
                $response->response_images()->save($responseImage);
            }
        }

        $complaints = Complaint::orderBy('created_at', 'desc')->get();
        session()->flash('response', 'Berhasil mengirimkan respon');
        return view('admin/komplain', compact('complaints'));
    }
}
