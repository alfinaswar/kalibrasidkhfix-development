<?php

namespace App\Http\Controllers;

use App\Models\inventori;
use App\Models\kategoriInventori;
use App\Models\MasterAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class InventoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = inventori::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('inv.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('gambar', function ($row) {
                    $gambar = '<img src="' . url('storage/foto_inventori/' . $row->Foto) . '" width="100" height="100">';
                    return $gambar;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('master.inventori.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = kategoriInventori::get();
        // dd($data);
        return view('master.inventori.create', compact('data'));
    }
    public function KategoriInventori(Request $request)
    {
        if ($request->ajax()) {
            $data = kategoriInventori::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('inv.edit-kategori', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data = kategoriInventori::all();
        return view('master.inventori.create-kategori');
    }
    public function storeKategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['idKategori'] = strtoupper(str_replace(' ', '', $data['Kategori']));
        kategoriInventori::create($data);
        return redirect()->route('inv.create-kategori')->with('success', 'Data Berhasil Disimpan');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cek = inventori::where('Sn', $request->input('Sn'))->get();
        if (count($cek) > 0) {
            return redirect()
                ->back()
                ->withErrors([
                    'Sn' => 'Nomor seri (SN) sudah ada.',
                    'Nama' => 'Alat Sudah Terdaftar',
                ])
                ->withInput();
        }
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
            'Kategori' => 'required',
            'Merk' => 'required',
            'Tipe' => 'required',
            'Sn' => 'required',
            'BuyDate' => 'required',
            'KalibrasiDate' => 'required',
            'KalibrasiDueDate' => 'required',
            'Tertelusur' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $existingInventori = inventori::where('Sn', $request->input('Sn'))->first();
        if ($existingInventori) {
            return redirect()
                ->back()
                ->withErrors(['Sn' => 'Nomor seri (SN) sudah ada.'])
                ->withInput();
        }
        $data = $request->all();
        if ($request->hasFile('Foto')) {
            $foto = $request->file('Foto');
            $foto->storeAs('public/foto_inventori', $foto->hashName());
            $foto = $foto->hashName();
        } else {
            $foto = null;
        }
        $data['Kode'] = $this->GenerateKode();
        $data['Foto'] = $foto;
        $data['UserId'] = auth()->user()->id;
        inventori::create($data);
        return redirect()->route('inv.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAlat $masterAlat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alat = inventori::find($id);
        $data = kategoriInventori::all();
        return view('master.inventori.edit', compact('alat', 'data'));
    }
    public function editKategori($id)
    {
        $data = kategoriInventori::find($id);
        return view('master.inventori.edit-Kategori', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
            'Kategori' => 'required',
            'Merk' => 'required',
            'Tipe' => 'required',
            'Sn' => 'required',
            'BuyDate' => 'required',
            'KalibrasiDate' => 'required',
            'KalibrasiDueDate' => 'required',
            'Tertelusur' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('Foto')) {
            $foto = $request->file('Foto');
            $foto->storeAs('public/foto_inventori', $foto->hashName());
            $foto = $foto->hashName();
        } else {
            $foto = null;
        }
        $data = $request->all();
        $data['Foto'] = $foto;
        $alat = inventori::find($id);
        $alat->update($data);

        return redirect()->route('inv.index')->with('success', 'Data Berhasil Diupdate');
    }
    public function updateKategori(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = kategoriInventori::find($id);
        $data->update($request->all());

        return redirect()->route('inv.create-kategori')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = inventori::find($id);
        if ($alat) {
            $alat->delete();
            return response()->json(['message' => 'data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
    }
    public function destroyKategori($id)
    {
        // dd($id);
        $cek = inventori::where('Kategori', $id)->get();
        if (count($cek) <= 0) {

            $data = kategoriInventori::find($id);
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

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = inventori::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->Kode, 0, 4);
            $KodeAlat = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/AS-DKH/' . $month . '/' . $year;
        } else {
            $KodeAlat = '0001/AS-DKH/' . $month . '/' . $year;
        }
        return $KodeAlat;
    }


}
