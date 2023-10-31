<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = $request->get('orderBy', 'id'); // Default to 'id' if not provided
        $sortBy = $request->get('sortBy', 'desc'); // Default to 'desc' if not provided
        $paginate = $request->get('paginate', 10); // Default to 10 if not provided

        $data = Acara::orderBy($orderBy, $sortBy)->paginate($paginate);

        return response()->json([
            'message' => 'Getting Acara',
            'status' => 200,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_pemancingan' => 'required',
                'nama_acara' => 'required|min:5',
                'deskripsi' => 'required|min:10',
                'mulai' => 'required',
                'akhir' => 'required',
                'gambar' => 'required|mimes:jpg,jpeg,png|max:1048',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Acara::create([
            'id_pemancingan' => $request->input('id_pemancingan'),
            'nama_acara' => $request->input('nama_acara'),
            'deskripsi' => $request->input('deskripsi'),
            'mulai' => $request->input('mulai'),
            'akhir' => $request->input('akhir'),
            'gambar' => $request->file('image')->storeAs('public/pemancingan', $request->file('image')->hashName()),
        ]);
        return response()->json([
            'message' => 'Acara has Created!',
            'status' => 201,
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Acara::where('id', $id)->first();
        if ($data) {
            return response()->json([
                'message' => 'Getting Acara!',
                'status' => 201,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Sorry, Data with ' . $id . ' not found',
                'status' => 404,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Acara::where('id', $id)->first();
        if ($data) {
            $data->update($request->all());
            return response()->json([
                'message' => 'Acara has Updated!',
                'status' => 201,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Sorry, Data with ' . $id . ' not found',
                'status' => 404,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Acara::where('id', $id)->first();
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Acara has Deleted!',
                'status' => 201,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Sorry, Data with ' . $id . ' not found',
                'status' => 404,
            ]);
        }
    }
}
