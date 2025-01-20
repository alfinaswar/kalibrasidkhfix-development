<?php

namespace App\Http\Controllers;

use App\Models\AdjustLK;
use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterAlat;
use App\Models\MasterFisikFungsi;
use App\Models\MasterKeselamatanListrik;
use App\Models\MasterMetode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InstrumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instrumen::with('getMetode')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('NamaAlat', function ($row) {
                    $NamaAlat = '';
                    if (!empty($row->AlatUkur)) {
                        foreach ($row->AlatUkur as $key => $value) {
                            $alat = inventori::where('id', $value)->first();
                            $NamaAlat .= '<span class="badge bg-dark m-1">' . $alat->Nama . '</span>';
                        }
                    } else {
                        $NamaAlat = '<span class="badge bg-warning m-1">Belum Di isi</span>';
                    }
                    return $NamaAlat;
                })
                ->addColumn('MetodeInst', function ($row) {
                    $MetodeInst = '';
                    if (!empty($row->getMetode->Nama)) {
                        $MetodeInst = $row->getMetode->Nama;
                    } else {
                        $MetodeInst = '<span class="badge bg-warning m-1">Belum Di isi</span>';
                    }
                    return $MetodeInst;
                })
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('instrumen.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . ' ' . $btnDelete;
                })
                ->addColumn('TarifRp', function ($row) {
                    $TarifRp = 'Rp ' . number_format($row->Tarif, 0, ',', '.');
                    return $TarifRp;
                })
                ->addColumn('UpdateAkre', function ($row) {
                    $selectedAktif = ($row->Akreditasi == 'AKTIF') ? 'selected' : '';
                    $selectedTidak = ($row->Akreditasi == 'TIDAK') ? 'selected' : '';

                    $UpdateAkre = '<select name="UpdateAkre" data-row-id="' . $row->id . '" class="form-control UpdateAkre">
                    <option value="">Pilih</option>
                    <option value="AKTIF" ' . $selectedAktif . '>AKTIF</option>
                    <option value="TIDAK" ' . $selectedTidak . '>TIDAK</option>
                    </select>';

                    return $UpdateAkre;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'AKTIF') {
                        $Stat = '<span class="badge bg-success">Aktif</span>';
                    } else {
                        $Stat = '<span class="badge bg-danger">Tidak AKtif</span>';
                    }
                    return $Stat;
                })
                ->rawColumns(['action', 'NamaAlat', 'Stat', 'TarifRp', 'UpdateAkre', 'MetodeInst'])
                ->make(true);
        }
        return view('master.instrumen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ParameterFisik = MasterFisikFungsi::orderBy('Parameter', 'ASC')->get();
        $ParameterListrik = MasterKeselamatanListrik::orderBy('Parameter', 'ASC')->get();
        $data = inventori::where('Kategori', 'ALATUKUR')->get();
        $metode = MasterMetode::get();
        return view('master.instrumen.create', compact('data', 'metode', 'ParameterFisik', 'ParameterListrik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
            'Nama' => 'required',
            'Tarif' => 'required',
            'Akreditasi' => 'required',
            'AlatUkur' => 'nullable',
            'Metode' => 'required',
            'LK' => 'nullable|file|max:1024',
            'Status' => 'required',
        ]);
        // dd($validator->->withErrors($validator);
        if ($validator->fails()) {
            // dd(withErrors($validator)->withInput());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd('23');
        $data = $request->all();
        $data['Tarif'] = str_replace('.', '', $data['Tarif']);
        if ($request->hasFile('LK')) {
            $file = $request->file('LK');
            $file->storeAs('public/file_lk', $file->getClientOriginalName());
            $data['LK'] = $file->getClientOriginalName();
        } else {
            $data['LK'] = null;
        }
        $data['KodeInstrumen'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        Instrumen::create($data);
        $FisikFungsi = [];
        foreach ($request->ParameterIndo as $key => $value) {
            $FisikFungsi[] = [
                $value,
                $request->MappingExcel[$key]
            ];
        }
        $ParameterListrikIndo = [];
        foreach ($request->ParameterListrikIndo as $key2 => $value2) {
            $ParameterListrikIndo[] = [
                $value2,
                $request->MappingExcelKelistrikan[$key2]
            ];
        }
        AdjustLK::create([
            'InstrumenId' => Instrumen::latest()->first()->id,
            'PengukuranSuhu' => $data['PengukuranSuhu'],
            'TeganganUtama' => $data['TeganganUtama'],
            'FisikFungsi' => $FisikFungsi,
            'KeselamatanListrik' => $ParameterListrikIndo,
            'idUser' => auth()->user()->id,
        ]);

        // $viewContent = "@extends('layouts.app') @section('content') @ @endsection";
        // $viewPath = resource_path('views' . DIRECTORY_SEPARATOR . 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $request->NamaFile . '.blade.php');

        // file_put_contents($viewPath, $viewContent);


        return redirect()->route('instrumen.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function getHarga($id)
    {
        $instrumen = Instrumen::find($id);

        if (!$instrumen) {
            return response()->json(['error' => 'Instrumen Tidak Ditemukan'], 404);
        }
        // dd($instrumen);
        return response()->json(['harga' => $instrumen->Tarif]);
    }
    public function CekInstrumen(Request $request)
    {
        $cek = Instrumen::where('Nama', 'LIKE', '%' . $request->Nama . '%')->first();
        if (!$cek) {
            $pesan = '<div class="alert alert-secondary alert-dismissible fade show">
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
									<strong>Berhasil!</strong> Instrumen Dengan Nama <b>' . $request->Nama . '</b> Belum Terdaftar.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    </button>
                                </div>';
        } else {
            $pesan = '<div class="alert alert-danger alert-dismissible fade show">
									<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
									<strong>Success!</strong> Ditemukan Instrumen Serupa Dengan Nama <b>' . $cek->Nama . '</b> Telah Terdaftar.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    </button>
								</div>';
        }
        return response()->json(['success' => $pesan]);
    }
    /**
     * Display the specified resource.
     */
    public function show(MasterAlat $masterAlat)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $metode = MasterMetode::get();
        $instrumen = Instrumen::find($id);
        $data = inventori::where('Kategori', 'ALATUKUR')->get();
        return view('master.instrumen.edit', compact('instrumen', 'data', 'metode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'Kategori' => 'required',
            'Nama' => 'required',
            'Tarif' => 'required',
            'Akreditasi' => 'required',
            'AlatUkur' => 'required',
            'Metode' => 'required',
            'Status' => 'required',
        ]);
        if ($validatedData->fails()) {
            return redirect()
                ->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $data = $request->all();
        $data['Tarif'] = str_replace('.', '', $data['Tarif']);
        $instrumen = Instrumen::find($id);
        if (!$instrumen) {
            return redirect()->route('instrumen.index')->withErrors(['Instrumen tidak ditemukan.']);
        }

        if ($request->hasFile('LK')) {
            $file = $request->file('LK');
            $file->storeAs('public/file_lk', $file->getClientOriginalName());
            $data['LK'] = $file->getClientOriginalName();
        }

        $instrumen->update($data);

        return redirect()->route('instrumen.index')->with('success', 'Data Berhasil Diupdate');
    }
    public function updateAkre(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->all();
        $query = Instrumen::find($id);
        $data['Akreditasi'] = $request->Akreditasi;
        $query->update($data);

        return response()->json(['message' => 'Berhasil Update']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = Instrumen::find($id);
        if ($alat) {
            $alat->delete();
            return response()->json(['message' => 'instrumen berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Instrumen    tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = Instrumen::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeInstrumen, 0, 4);
            $KodeAlat = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/INST-DKH/' . $month . '/' . $year;
        } else {
            $KodeAlat = '0001/INST-DKH/' . $month . '/' . $year;
        }
        return $KodeAlat;
    }
}
