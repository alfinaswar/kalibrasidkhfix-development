<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\SerahTerima;
use App\Models\SerahTerimaDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class SerahTerimaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SerahTerima::with('getCustomer')->orderBy('id', 'Desc')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '
<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Actions
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="' . route('st.edit', $row->id) . '" title="Edit"><i class="fas fa-edit"></i> Edit</a></li>
        <li><a class="dropdown-item" href="' . route('st.pdf', $row->id) . '" target="_blank" title="Pdf"><i class="fas fa-print"></i> Pdf</a></li>
        <li><a class="dropdown-item" href="' . route('st.detail', $row->id) . '" target="_blank" title="Detail"><i class="fas fa-tags"></i> Detail</a></li>
    </ul>
</div>';
                    $btnDel = '<a class="btn btn-sm btn-danger btn-delete" href="javascript:void(0)" data-id="' . $row->id . '" title="Hapus"><i class="fas fa-trash-alt"></i> </a>';
                    return $btnDel . ' ' . $action;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'AKTIF') {
                        $Stat = '<span class="badge light badge-success text-dark">
														<i class="fa fa-circle text-success me-1"></i>
														AKTIF
													</span>';
                    } else {
                        $Stat = '<span class="badge light badge-danger text-dark">
														<i class="fa fa-circle text-danger me-1"></i>
														TIDAK AKTIF
													</span>';
                    }
                    return $Stat;
                })
                ->addColumn('Diserahkan', function ($row) {
                    if ($row->TanggalDiajukan == null) {
                        $update = '';
                        $Diserahkan = '<a href="javascript:void(0)" class="fw-bold text-blue" data-bs-toggle="modal" data-bs-target="#updateDiserahkanModal' . $row->id . '">
                                            Update
                                        </a>
                                        <div class="modal fade" id="updateDiserahkanModal' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Tanggal Diserahkan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="datetime-local" class="form-control TanggalDiserahkan"
                                                            placeholder="' . now() . '" name="Tanggal" data-row-id="' . $row->id . '"  id="updateDiserahkan">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>';
                    } else {
                        $Diserahkan = $row->TanggalDiajukan;
                        $update = '<a href="javascript:void(0)" class="fw-bold text-blue" data-bs-toggle="modal" data-bs-target="#updateDiserahkanModal' . $row->id . '">
                                            Update
                                        </a>
                                        <div class="modal fade" id="updateDiserahkanModal' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Tanggal Diserahkan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="datetime-local" class="form-control TanggalDiserahkan"
                                                            placeholder="' . now() . '" name="Tanggal" data-row-id="' . $row->id . '"  id="updateDiserahkan">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>';
                    }
                    return $Diserahkan . ' ' . $update;
                })
                ->addColumn('Lokasi', function ($row) {
                    if ($row->Lokasi == 'INSITU') {
                        $Lokasi = '<span class="badge bg-success text-dark">INSITU</span>';
                    } else {
                        $Lokasi = '<span class="badge bg-secondary">EKSITU</span>';
                    }
                    return $Lokasi;
                })
                ->rawColumns(['action', 'Stat', 'Diserahkan', 'Lokasi'])
                ->make(true);
        }
        $customer = MasterCustomer::latest()->get();
        return view('serah-terima.index', compact('customer'));
    }
    public function updateTanggalDiserahkan(Request $request, $id)
    {
        $data = SerahTerima::findOrFail($id);
        $data->TanggalDiajukan = $request->tanggalDiserahkan;
        $data->save();

        return response()->json(['message' => 'Telah Diserahkan']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $customer = MasterCustomer::where('Status', 'AKTIF')->get();
        $instrumen = Instrumen::where('Status', 'AKTIF')->get();
        return view('serah-terima.form-serah-terima', compact('user', 'instrumen', 'customer'));
    }

    public function detail($id)
    {
        $st = SerahTerima::with([
            'Stdetail'
        ])->where('id', $id)->first();
        // dd($st);
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.detail', compact('st', 'user', 'customer', 'instrumen'));
    }
    public function CetakStiker($id)
    {
        $data = SerahTerima::with(
            'Stdetail',
            'getCustomer',
            'Stdetail.getNamaAlat'
        )->where('id', $id)->first();
        $viewData = [
            'KodeSt' => $data->KodeSt,
            'data' => $data,
        ];
        // return $viewData;
        // die;

        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('serah-terima.format-stiker', $viewData)->setPaper([0, 0, 161.57, 70.00], 'portrait');

        return $pdf->stream('stiker.pdf');
    }
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'CustomerId' => 'required',
            'TanggalDiterima' => 'required',
            // 'Status' => 'required',
            'InstrumenId' => 'required|array',
            'InstrumenId.*' => 'required|integer|exists:instrumens,id',
            'Lokasi' => 'required',
            'Qty' => 'required|array',
            'Qty.*' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        // Proses data setelah validasi
        $data = $request->all();
        $data['KodeSt'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        $SerahTerima = SerahTerima::create($data);
        $latestId = SerahTerima::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            if ($request->Qty[$i] > 1) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    SerahTerimaDetail::create([
                        'SerahTerimaId' => $latestId,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Merk' => $request->Merk[$i],
                        'Type' => $request->Type[$i],
                        'SerialNumber' => $request->SerialNumber[$i],
                        'Qty' => 1,
                        'Deskripsi' => $request->Deskripsi[$i],
                        'Tambahan' => 'TIDAK',
                        'idUser' => auth()->user()->id,
                    ]);
                }
            } else {
                SerahTerimaDetail::create([
                    'SerahTerimaId' => $latestId,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Merk' => $request->Merk[$i],
                    'Type' => $request->Type[$i],
                    'SerialNumber' => $request->SerialNumber[$i],
                    'Qty' => $request->Qty[$i],
                    'Deskripsi' => $request->Deskripsi[$i],
                    'Tambahan' => 'TIDAK',
                    'idUser' => auth()->user()->id,
                ]);
            }

        }
        return redirect()->route('st.index')->with('success', 'Data Berhasil Disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function GeneratePdf($id)
    {
        $data = SerahTerima::with([
            'Stdetail',
            'Stdetail.getNamaAlat',
            'getCustomer'
        ])->where('id', $id)->first();
        // dd($data);
        $filename = str_replace(['/', '\\'], '_', $data->KodeSt) . '.pdf';
        $viewData = [
            'judul' => 'SERAH TERIMA BARANG',
            'KodeSt' => $data->KodeSt,
            'instrumen' => $data,
        ];
        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('serah-terima.formatPdf', $viewData);

        return $pdf->stream($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $st = SerahTerima::with([
            'Stdetail' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            }
        ])->where('id', $id)->first();
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.edit', compact('st', 'user', 'customer', 'instrumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'CustomerId' => 'required',
            'Lokasi' => 'required',
            'TanggalDiterima' => 'required',
        ]);
        $serahTerimaAlat = SerahTerima::find($id);
        $serahTerimaAlat->update($validatedData);
        $serahTerimaAlat->Stdetail()->delete();

        foreach ($request->InstrumenId as $key => $value) {
            if ($request->Tambahan[$key] == 'TIDAK') {
                $stat = 'TIDAK';
            } else {
                $stat = 'YA';
            }
            $getData = KajiUlang::select('*', DB::raw('COUNT(InstrumenId) as JumlahQty'))->groupBy('InstrumenId')->where('SerahTerimaId', $id)->where('InstrumenId', $value)->first();
            KajiUlang::where('SerahTerimaId', $id)
                ->whereNotIn('InstrumenId', $request->InstrumenId)
                ->delete();
            if ($getData) {
                if ($getData->JumlahQty > $request->Qty[$key]) {
                    $selisihQty = $getData->JumlahQty - $request->Qty[$key];
                    for ($i = 0; $i < $selisihQty; $i++) {
                        KajiUlang::where('SerahTerimaId', $id)->where('InstrumenId', $value)->latest()->first()->delete();
                    }
                } else {
                    $selisihQty = $request->Qty[$key] - $getData->JumlahQty;
                    if ($request->Tambahan[$key] == $stat) {
                        for ($j = 0; $j < $selisihQty; $j++) {
                            KajiUlang::create([
                                'KodeKajiUlang' => $this->GenerateKodeKaji(),
                                'SerahTerimaId' => $serahTerimaAlat->id,
                                'InstrumenId' => $value,
                                'Metode1' => $getData->Metode1 ?? null,
                                'Metode2' => $getData->Metode2 ?? null,
                                'Status' => $getData->Status ?? null,
                                'Kondisi' => $getData->Kondisi ?? null,
                                'Catatan' => $getData->Catatan ?? null,
                                'Tambahan' => $stat,
                                'idUser' => auth()->user()->id,
                            ]);
                        }
                    } else {
                        for ($j = 0; $j < $selisihQty; $j++) {
                            KajiUlang::create([
                                'KodeKajiUlang' => $this->GenerateKodeKaji(),
                                'SerahTerimaId' => $serahTerimaAlat->id,
                                'InstrumenId' => $value,
                                'Metode1' => $getData->Metode1 ?? null,
                                'Metode2' => $getData->Metode2 ?? null,
                                'Status' => $getData->Status ?? null,
                                'Kondisi' => $getData->Kondisi ?? null,
                                'Catatan' => $getData->Catatan ?? null,
                                'Tambahan' => $stat,
                                'idUser' => auth()->user()->id,
                            ]);
                        }
                    }
                }
            } else {
                $selisihQty = $request->Qty[$key];
                if ($request->Tambahan[$key] == $stat) {
                    for ($j = 0; $j < $selisihQty; $j++) {
                        KajiUlang::create([
                            'KodeKajiUlang' => $this->GenerateKodeKaji(),
                            'SerahTerimaId' => $serahTerimaAlat->id,
                            'InstrumenId' => $value,
                            'Metode1' => null,
                            'Metode2' => null,
                            'Status' => null,
                            'Kondisi' => null,
                            'Catatan' => null,
                            'Tambahan' => $stat,
                            'idUser' => auth()->user()->id,
                        ]);
                    }
                } else {
                    for ($j = 0; $j < $selisihQty; $j++) {
                        KajiUlang::create([
                            'KodeKajiUlang' => $this->GenerateKodeKaji(),
                            'SerahTerimaId' => $serahTerimaAlat->id,
                            'InstrumenId' => $value,
                            'Metode1' => null,
                            'Metode2' => null,
                            'Status' => null,
                            'Kondisi' => null,
                            'Catatan' => null,
                            'Tambahan' => $stat,
                            'idUser' => auth()->user()->id,
                        ]);
                    }
                }
            }

            if ($request->Qty[$key] > 1) {

                for ($j = 0; $j < $request->Qty[$key]; $j++) {
                    SerahTerimaDetail::create([
                        'SerahTerimaId' => $serahTerimaAlat->id,
                        'InstrumenId' => $value,
                        'Merk' => $request->Merk[$key],
                        'Type' => $request->Type[$key],
                        'SerialNumber' => $request->SerialNumber[$key],
                        'Qty' => 1,
                        'Deskripsi' => $request->Deskripsi[$key],
                        'Tambahan' => $stat,
                        'idUser' => auth()->user()->id,
                    ]);
                }

            } else {
                SerahTerimaDetail::create([
                    'SerahTerimaId' => $serahTerimaAlat->id,
                    'InstrumenId' => $value,
                    'Merk' => $request->Merk[$key],
                    'Type' => $request->Type[$key],
                    'SerialNumber' => $request->SerialNumber[$key],
                    'Qty' => $request->Qty[$key],
                    'Deskripsi' => $request->Deskripsi[$key],
                    'Tambahan' => $stat,
                    'idUser' => auth()->user()->id,
                ]);
            }

        }
        return redirect()->route('st.index')->with('success', 'Data Berhasil Diupdate');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $st = SerahTerima::find($id);
        if ($st) {
            $st->delete();
            $st->Stdetail()->delete();
            $st->dataKaji()->delete();
            return response()->json(['message' => 'instrumen berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Instrumen tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = SerahTerima::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeSt, 0, 4);
            $Kode = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/ST-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/ST-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
    private function GenerateKodeKaji()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKode = KajiUlang::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodeKajiUlang, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/KU-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/KU-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
