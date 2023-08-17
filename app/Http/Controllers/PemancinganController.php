<?php

namespace App\Http\Controllers;

use App\Models\Pemancingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($request->get('order') && $request->get('by')) {
            $order = $request->get('order');
            $by = $request->get('by');
        } else {
            $order = 'id';
            $by = 'desc';
        }

        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        } else {
            $paginate = 10;
        }

        $data = Pemancingan::when($search, function ($query) use ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('nama_pemancingan', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        })->when(($order && $by), function ($query) use ($order, $by) {
            $query->orderBy($order, $by);
        })->paginate($paginate);

        $query_string = [
            'search' => $search,
            'order' => $order,
            'by' => $by,
        ];

        $data->appends($query_string);

        return response()->json([
            'message' => 'Getting Pemancingan Data is Successfully!',
            'status' => 200,
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category' => 'required',
                'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:1048',
                'nama_pemancingan' => 'required|min:5',
                'deskripsi' => 'required|min:10',
                'provinsi' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'alamat' => 'required|min:10',
                'lokasi' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Errors',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = Pemancingan::create([
            'id_user' => $request->get('id_user'),
            'category' => $request->get('category'),
            'image' => $request->file('image')->hashName(),
            'path' => $request->file('image')->storeAs('public/pemancingan', $request->file('image')->hashName()),
            'nama_pemancingan' => $request->get('nama_pemancingan'),
            'deskripsi' => $request->get('deskripsi'),
            'provinsi' => $request->get('provinsi'),
            'kota' => $request->get('kota'),
            'kecamatan' => $request->get('kecamatan'),
            'alamat' => $request->get('alamat'),
            'lokasi' => $request->get('lokasi'),
            'status' => null
        ]);

        return response()->json([
            'message' => 'Pemancingan Created!',
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemancingan $fishingSpot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemancingan $fishingSpot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemancingan $fishingSpot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemancingan $fishingSpot)
    {
        //
    }
}
