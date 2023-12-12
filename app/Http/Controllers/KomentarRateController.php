<?php

namespace App\Http\Controllers;

use App\Models\KomentarRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomentarRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $orderBy = $request->get('orderBy', 'id');  // Default to 'id' if not provided
        $sortBy = $request->get('sortBy', 'desc');  // Default to 'desc' if not provided
        $paginate = $request->get('paginate', 10);  // Default to 10 if not provided

        $data = KomentarRate::with('userKomentar')->where('id_pemancingan', $id)->orderBy($orderBy, $sortBy)->paginate($paginate);

        return response()->json([
            'message' => 'Getting Komentar Rate',
            'status' => 200,
            'data' => $data
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
                'id_user' => 'required',
                'komentar' => 'required',
                'rate' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = KomentarRate::create($request->all());
        return response()->json([
            'message' => 'Komentar Rate has Created',
            'status' => 201,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $findData = KomentarRate::where('id', $id)->first();
        if ($findData) {
            $validator = Validator::make(
                $request->all(),
                [
                    'komentar' => 'required',
                    'rate' => 'required'
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $findData->update($request->all());
            return response()->json([
                'message' => 'Komentar Rate Updated!',
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
        $findData = KomentarRate::where('id', $id)->first();
        if ($findData) {
            $findData->delete();
            return response()->json([
                'message' => 'Komentar Rate Deleted!',
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
}
