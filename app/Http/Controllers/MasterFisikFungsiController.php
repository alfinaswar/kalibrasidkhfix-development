<?php

namespace App\Http\Controllers;

use App\Models\MasterFisikFungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterFisikFungsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = MasterFisikFungsi::with('getUser')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('fisikfungsi.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.parameter.fisik-fungsi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->Nama);
        $validator = Validator::make($request->all(), [
            'Parameter' => 'required',
            'ParameterEng' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        MasterFisikFungsi::create($data);
        return redirect()->route('fisikfungsi.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterFisikFungsi $masterFisikFungsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MasterFisikFungsi::find($id);
        return view('master.parameter.fisik-fungsi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Parameter' => 'required',
            'ParameterEng' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = MasterFisikFungsi::find($id);
        $data['edited_by'] = auth()->user()->id;
        $data->update($request->all());

        return redirect()->route('fisikfungsi.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MasterFisikFungsi::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => 'data berhasil dihapus'], 200);
        } else {
            return response()->json(['success' => 'data tidak ditemukan'], 404);
        }


    }
}
