<?php

namespace App\Http\Controllers;

use App\Models\CatatanKajiUlang;
use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\MasterMetode;
use App\Models\SerahTerima;
use App\Models\SerahTerimaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class KajiUlangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SerahTerima::with('dataKaji', 'getCustomer')->orderBy('id', 'Desc')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $ikl = '<a href="' . route('ku.cetak', $row->id) . '" target="_blank" class="btn btn-secondary btn-sm btn-edit" title="Instruksi Kerja PDF"><i class="fas fa-file-pdf"></i></a>';
                    $ku = '<a href="' . route('ku.cetak-kup', $row->id) . '" target="_blank" class="btn btn-primary btn-sm btn-edit" title="Kaji Ulang Permintaan Tender"><i class="fas fa-file-pdf"></i></a>';
                    // $delete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    if ($row->dataKaji->isEmpty()) {
                        $edit = '';
                    } else {
                        $edit = '<a href="' . route('ku.edit', $row->id) . '" class="btn btn-warning btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    }

                    return $edit . ' ' . $ikl . ' ' . $ku;
                })
                ->addColumn('StatusKaji', function ($row) {
                    if ($row->dataKaji->isEmpty()) {
                        $stat = '<span class="badge light badge-danger text-dark">
<i class="fa fa-circle text-danger me-1"></i>
Belum dikaji ulang
</span>';
                    } else {
                        $stat = '<span class="badge light badge-success text-dark">
<i class="fa fa-circle text-success me-1"></i>
Telah dikaji ulang
</span>';
                    }

                    return $stat;
                })
                ->addColumn('Lokasi', function ($row) {
                    if ($row->Lokasi == 'INSITU') {
                        $Lokasi = '<span class="badge bg-success text-dark">INSITU</span>';
                    } else {
                        $Lokasi = '<span class="badge bg-secondary">EKSITU</span>';
                    }
                    return $Lokasi;
                })
                ->rawColumns(['action', 'StatusKaji', 'Lokasi'])
                ->make(true);
        }
        $dataSerahTerima = SerahTerima::with([
            'getCustomer',
            'dataKaji'
        ])
            ->doesntHave('dataKaji')
            // ->whereHas('dataKaji', function ($query) {
            //     $query->where('Tambahan', 'TIDAK')->whereNull('Metode1');
            // })
            ->latest()
            ->get();
        // dd($dataSerahTerima);
        return view('kaji-ulang.index', compact('dataSerahTerima'));
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
        // dd($request->all());
        $cek = SerahTerima::with('Stdetail')->find($request->SerahTerimaId);
        foreach ($request->InstrumenId as $index => $instrumenId) {
            $data = explode('-', $request->InstrumenId[$index]);
            $InstrumenId = $data[0];
            $JumlahAlat = $data[1];
            for ($i = 0; $i < $JumlahAlat; $i++) {
                KajiUlang::create([
                    'KodeKajiUlang' => $this->GenerateKode(),
                    'SerahTerimaId' => $request->SerahTerimaId,
                    'InstrumenId' => $InstrumenId,
                    'Metode1' => $request->Metode1[$index],
                    'Metode2' => $request->Metode2[$index],
                    'Status' => $request->Status[$index],
                    'Kondisi' => $request->Kondisi[$index],
                    'Catatan' => $request->Catatan[$index],
                    'Tambahan' => 'TIDAK',
                    'idUser' => auth()->user()->id,
                ]);
            }
        }

        CatatanKajiUlang::create([
            'KajiUlangId' => $request->SerahTerimaId,
            'Catatan' => $request->CatatanKajiUlang,
            'idUser' => auth()->user()->id,
        ]);
        // } else {
        //     $data = explode("-", $request->InstrumenId[$index]);
        //     $InstrumenId = $data[0];
        //     $JumlahAlat = $data[1];
        //     foreach ($request->InstrumenId as $index => $instrumenId) {
        //         $data = explode("-", $request->InstrumenId[$index]);
        //         $InstrumenId = $data[0];
        //         $JumlahAlat = $data[1];
        //             KajiUlang::create([
        //                 'KodeKajiUlang' => $this->GenerateKode(),
        //                 'SerahTerimaId' => $request->SerahTerimaId,
        //                 'InstrumenId' => $InstrumenId,
        //                 'Metode1' => $request->Metode1[$index],
        //                 'Metode2' => $request->Metode2[$index],
        //                 'Status' => $request->Status[$index],
        //                 'Kondisi' => $request->Kondisi[$index],
        //                 'Catatan' => $request->Catatan[$index],
        //                 'idUser' => auth()->user()->id,
        //             ]);
        //     }
        // }
        return redirect()->route('ku.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = SerahTerima::with('Stdetail', 'dataKaji', 'getCustomer', 'dataKaji.getInstrumen', 'getCatatan')->where('id', $id)->first();
        if ($data->dataKaji->isEmpty()) {
            return redirect()->back()->with('error', 'Kaji ulang belum dilakukan.');
        }
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('kaji-ulang.CetakInstruksiKerja', compact('data'));
        return $pdf->stream('Instruksi Kerja' . $data->id . '.pdf');
    }

    public function cetakKup($id)
    {
        $data = SerahTerima::with([
            'Stdetail',
            'dataKaji' => function ($query) use ($id) {
                $query
                    ->select('*', DB::raw('COUNT(InstrumenId) as Qty'))
                    ->with('getInstrumen')
                    ->where('SerahTerimaId', $id)
                    // ->where('Status', '!=', 2)
                    ->groupBy('InstrumenId');
            },
            'getCustomer',
            'getCatatan',
            'dataKaji.getInstrumen',
            'dataKaji.getMetode1',
            'dataKaji.getMetode2',
            'Stdetail.getNamaAlat'
        ])->where('id', $id)->first();
        // dd($data);

        // Cek apakah dataKaji kosong
        if ($data->dataKaji->isEmpty()) {
            return redirect()->back()->with('error', 'Kaji ulang belum dilakukan.');
        }

        // Lanjutkan dengan pembuatan PDF jika dataKaji tidak kosong
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('kaji-ulang.KajiUlangPermintaan', compact('data'));
        return $pdf->stream('Instruksi Kerja' . $data->id . '.pdf');
    }

    public function formKaji($id)
    {
        $cek = SerahTerima::with('Stdetail')->find($id);
        if ($cek->Lokasi == 'INSITU') {
            $data = SerahTerima::with([
                'Stdetail' => function ($query) {
                    $query
                        ->groupBy('InstrumenId')
                        ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'))
                        ->groupBy('InstrumenId');
                }
                ,
                'Stdetail.getNamaAlat'
            ])->find($id);
        } else {
            // $data = SerahTerima::with(
            //     'Stdetail'
            // )->find($id);
            $data = SerahTerima::with([
                'Stdetail' => function ($query) {
                    $query
                        ->groupBy('InstrumenId')
                        ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'))
                        ->groupBy('InstrumenId');
                }
                ,
                'Stdetail.getNamaAlat'
            ])->find($id);
        }
        // dd($data);
        $customer = MasterCustomer::where('Status', 'AKTIF')->get();
        $instrumen = Instrumen::where('Status', 'AKTIF')->get();
        $metode = MasterMetode::get();
        return view('kaji-ulang.form-kaji-ulang', compact('metode', 'data', 'instrumen', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cek = SerahTerima::with('dataKaji')->find($id);
        if ($cek->Lokasi == 'INSITU') {
            $data = SerahTerima::with([
                'dataKaji' => function ($query) {
                    $query
                        ->groupBy('InstrumenId')
                        ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'))
                        ->groupBy('InstrumenId');
                },
                'getCatatan',
                'dataKaji.getInstrumen'
            ])->find($id);
        } else {
            // $data = SerahTerima::with([
            //     'Stdetail' => function ($query) {
            //         $query->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            //     }
            // ])->find($id);
            $data = SerahTerima::with([
                'dataKaji' => function ($query) {
                    $query
                        ->groupBy('InstrumenId')
                        ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'))
                        ->groupBy('InstrumenId');
                },
                'getCatatan',
                'dataKaji.getInstrumen'
            ])->find($id);
        }
        // dd($data);
        // $data = SerahTerima::with('dataKaji')->find($id);
        $customer = MasterCustomer::where('Status', 'AKTIF')->get();
        $instrumen = Instrumen::where('Status', 'AKTIF')->get();
        $metode = MasterMetode::get();
        return view('kaji-ulang.edit', compact('metode', 'data', 'instrumen', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $hapusdata = KajiUlang::where('SerahTerimaId', $id)->delete();
        foreach ($request->InstrumenId as $index => $instrumenId) {
            $data = explode('-', $instrumenId);
            $InstrumenId = $data[0];
            $JumlahAlat = $data[1];
            $existingRecords = KajiUlang::where('SerahTerimaId', $id)
                ->where('InstrumenId', $InstrumenId)
                ->get();

            for ($i = 0; $i < $JumlahAlat; $i++) {
                if (isset($existingRecords[$i])) {
                    // update yang udah ada
                    $existingRecords[$i]->create([
                        'KodeKajiUlang' => $this->GenerateKode(),
                        'Metode1' => $request->Metode1[$index],
                        'Metode2' => $request->Metode2[$index],
                        'Status' => $request->Status[$index],
                        'Kondisi' => $request->Kondisi[$index],
                        'Catatan' => $request->Catatan[$index],
                        'idUser' => auth()->user()->id,
                    ]);
                } else {
                    // jika tidak ada create baru
                    KajiUlang::create([
                        'KodeKajiUlang' => $this->GenerateKode(),
                        'SerahTerimaId' => $id,
                        'InstrumenId' => $InstrumenId,
                        'Metode1' => $request->Metode1[$index],
                        'Metode2' => $request->Metode2[$index],
                        'Status' => $request->Status[$index],
                        'Kondisi' => $request->Kondisi[$index],
                        'Catatan' => $request->Catatan[$index],
                        'idUser' => auth()->user()->id,
                    ]);
                }
            }
        }
        $catatanKajiUlang = CatatanKajiUlang::where('KajiUlangId', $id);
        $catatanKajiUlang->update([
            'Catatan' => $request->CatatanKajiUlang,
            'idUser' => auth()->user()->id,
        ]);
        return redirect()->route('ku.index')->with('success', 'Kaji Ulang Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KajiUlang $kajiUlang)
    {
        //
    }

    private function GenerateKode()
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
