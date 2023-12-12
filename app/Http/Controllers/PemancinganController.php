<?php

namespace App\Http\Controllers;

use App\Models\Pemancingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PemancinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        } else {
            $paginate = 10;
        }

        $data = Pemancingan::with('userPemancingan', 'acaraPemancingan', 'komentarPemancingan')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($sub_query) use ($search) {
                    $sub_query->where('nama_pemancingan', 'LIKE', "%{$search}%")
                        ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'asc')
            ->paginate($paginate);

        return response()->json([
            'message' => 'Getting Pemancingan Data is Successfully!',
            'status' => 200,
            'data' => $data,
        ], 200);
    }

    public function getPemancinganForUser(Request $request)
    {
        $search = $request->get('search');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        } else {
            $paginate = 10;
        }

        $data = Pemancingan::with('userPemancingan', 'acaraPemancingan', 'komentarPemancingan')
            ->where('status', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($sub_query) use ($search) {
                    $sub_query->where('nama_pemancingan', 'LIKE', "%{$search}%");
                });
            })
            ->orderByRaw(
                "6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))",
                [$latitude, $longitude, $latitude]
            )
            ->paginate($paginate);

        return response()->json([
            'message' => 'Getting Pemancingan Data is Successfully!',
            'status' => 200,
            'data' => $data,
        ], 200);
    }



    public function getPemancinganByUser(Request $request, $id_user)
    {
        $search = $request->get('search');

        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        } else {
            $paginate = 10;
        }

        $data = Pemancingan::with('userPemancingan', 'acaraPemancingan', 'komentarPemancingan')
            ->where('id_user', $id_user)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($sub_query) use ($search) {
                    $sub_query->where('nama_pemancingan', 'LIKE', "%{$search}%")
                        ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($paginate);

        return response()->json([
            'message' => 'Getting Pemancingan Data is Successfully!',
            'status' => 200,
            'data' => $data,
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
                'id_user' => 'required',
                'category' => 'required',
                'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:1048',
                'nama_pemancingan' => 'required',
                'deskripsi' => 'required',
                'provinsi' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'alamat' => 'required',
                'buka' => 'required',
                'tutup' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'id_provinsi' => 'required',
                'id_kota' => 'required',
                'id_kecamatan' => 'required',
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
            'buka' => $request->get('buka'),
            'tutup' => $request->get('tutup'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
            'id_provinsi' => $request->get('id_provinsi'),
            'id_kota' => $request->get('id_kota'),
            'id_kecamatan' => $request->get('id_kecamatan'),
            'status' => null,
            'pesan' => null,
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
    public function show($id)
    {
        $data = Pemancingan::with('userPemancingan', 'acaraPemancingan', 'komentarPemancingan.userKomentar')->where('id', $id)->first();
        if ($data) {
            return response()->json([
                'message' => 'Getting Pemancingan Data is Successfully!',
                'status' => 200,
                'data' => $data
            ], 200);
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
        $findData = Pemancingan::where('id', $id)->first();
        if ($findData) {
            $validator = Validator::make(
                $request->all(),
                [
                    'category' => 'required',
                    'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:1048',
                    'nama_pemancingan' => 'required',
                    'deskripsi' => 'required',
                    'provinsi' => 'required',
                    'kota' => 'required',
                    'kecamatan' => 'required',
                    'alamat' => 'required',
                    'buka' => 'required',
                    'tutup' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
                    'id_provinsi' => 'required',
                    'id_kota' => 'required',
                    'id_kecamatan' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Errors',
                    'errors' => $validator->errors(),
                ], 400);
            }
            Storage::delete($findData->path);
            $findData->update([
                'category' => $request->get('category'),
                'image' => $request->file('image')->hashName(),
                'path' => $request->file('image')->storeAs('public/pemancingan', $request->file('image')->hashName()),
                'nama_pemancingan' => $request->get('nama_pemancingan'),
                'deskripsi' => $request->get('deskripsi'),
                'provinsi' => $request->get('provinsi'),
                'kota' => $request->get('kota'),
                'kecamatan' => $request->get('kecamatan'),
                'alamat' => $request->get('alamat'),
                'buka' => $request->get('buka'),
                'tutup' => $request->get('tutup'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'id_provinsi' => $request->get('id_provinsi'),
                'id_kota' => $request->get('id_kota'),
                'id_kecamatan' => $request->get('id_kecamatan'),
                'status' => null,
                'pesan' => null,
            ]);
            return response()->json([
                'message' => 'Pemancingan Updated!',
                'status' => 200,
                'data' => $findData
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
        $findData = Pemancingan::where('id', $id)->first();
        if ($findData) {
            Storage::delete($findData->path);
            $findData->delete();
            return response()->json([
                'message' => 'Pemancingan Deleted!',
                'status' => 200,
                'data' => $findData
            ]);
        } else {
            return response()->json([
                'message' => 'Sorry, Data with ' . $id . ' not found',
                'status' => 404,
            ]);
        }
    }

    public function showImage($filename)
    {
        $path = 'public/pemancingan/' . $filename;
        if (Storage::exists($path)) {
            $file = Storage::get($path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        } else {
            return response('Image not found', 404);
        }
    }

    public function aprroveReject(Request $request, $id)
    {
        $findData = Pemancingan::with('userPemancingan', 'acaraPemancingan', 'komentarPemancingan.userKomentar')->where('id', $id)->first();
        $findData->update([
            'status' => $request->get('status'),
            'pesan' => $request->get('pesan')
        ]);
        return response()->json([
            'message' => 'Pemancingan Updated!',
            'status' => 200,
            'data' => $findData
        ]);
    }
}
