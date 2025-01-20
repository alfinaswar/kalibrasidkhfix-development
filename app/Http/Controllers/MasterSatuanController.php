<?php

namespace App\Http\Controllers;

use App\Models\MasterSatuan;
use App\Models\Sertifikat;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Yajra\DataTables\Facades\DataTables;

class MasterSatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterSatuan::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('satuan.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.satuan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'Satuan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        MasterSatuan::create($data);
        return redirect()->back()->with('success', 'Data Telah Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterSatuan $masterSatuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MasterSatuan::find($id);
        return view('master.satuan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Satuan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = MasterSatuan::find($id);
        $data->update($request->all());

        return redirect()->route('route.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cek = Sertifikat::where('Kategori', $id)->get();
        if (count($cek) <= 0) {

            $data = MasterSatuan::find($id);
            if ($data) {
                $data->delete();
                return response()->json(['message' => 'data berhasil dihapus'], 200);
            } else {
                return response()->json(['message' => 'data tidak ditemukan'], 404);
            }
        } else {
            return response()->json(['message' => 'Data Sedang Digunakan'], 404);
        }
    }
}
