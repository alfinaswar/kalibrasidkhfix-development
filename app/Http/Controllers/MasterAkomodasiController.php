<?php

namespace App\Http\Controllers;

use App\Models\AkomodasiDetail;
use App\Models\MasterAkomodasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laraindo\RupiahFormat;
use Yajra\DataTables\Facades\DataTables;

class MasterAkomodasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterAkomodasi::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('Tarif', function ($row) {
                    $Tarif = RupiahFormat::currency($row->Tarif);

                    return $Tarif;
                })
                ->rawColumns(['action', 'Tarif'])
                ->make(true);
        }
        return view('master.akomodasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function getTarif($AkomodasiID)
    {
        $data = MasterAkomodasi::find($AkomodasiID);
        if (!$data) {
            return response()->json(['error' => 'Akomodasi Tidak Ditemukan'], 404);
        }
        // dd($data);
        return response()->json(['Tarif' => $data->Tarif]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
            'Tarif' => 'required',
            'NA' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Tarif'] = str_replace('.', '', $data['Tarif']);
        $data['idUser'] = auth()->user()->id;
        MasterAkomodasi::create($data);

        return redirect()->route('akomodasi.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAkomodasi $masterAkomodasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $akomodasi = MasterAkomodasi::find($id);
        return response()->json($akomodasi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
            'Tarif' => 'required',
            'NA' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Tarif'] = str_replace('.', '', $data['Tarif']);
        $alat = MasterAkomodasi::find($id);
        $alat->update($data);

        return redirect()->route('akomodasi.index')->with('success', 'Data Berhasil Diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cek = AkomodasiDetail::where('AkomodasiId', $id)->get();
        if (count($cek) <= 0) {

            $data = MasterAkomodasi::find($id);
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
