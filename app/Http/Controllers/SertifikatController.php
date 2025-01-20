<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BabyIncubatorController;
use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\PengukuranListrik;
use App\Models\Sertifikat;
use App\Models\SertifikatCentrifugePengujian;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatHal;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatManual;
use App\Models\SertifikatPatientMonitorPengujuan;
use App\Models\SertifikatTelaahTeknis;
use App\Models\User;
use App\Models\ValidasiMutu;
use App\Models\VerifTeknis;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Sertifikat::with([
                'getCustomer',
                'getNamaAlat',
                'getVerif',
                'getValid',
                'getKaryawan',
                'getValidateUser',
                'getVerifUser',
                'getPO'
            ])
                ->whereHas('getPO', function ($q) {
                    $q->where('Approve', 'Y');
                })
                ->orderBy('id', 'Desc');
            if ($request->filled('nama_alat')) {
                $query->whereHas('getNamaAlat', function ($q) use ($request) {
                    $q->where('Nama', 'like', '%' . $request->nama_alat . '%');
                });
            }

            if ($request->filled('status_sertifikat')) {
                $query->where('Status', $request->status_sertifikat);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->TanpaLK == 'Y') {
                        $action = '
<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Aksi
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="' . route('job.kalibrasi', $row->id) . '" title="Kalibrasi" target="_blank"><i class="fas fa-file-signature"></i> Kalibrasi</a></li>
        <li><a class="dropdown-item" href="' . route('job.downloadExcel', $row->id) . '" title="Download Excel" target="_blank"><i class="fas fa-file-excel"></i> Download Excel</a></li>
        <li><a class="dropdown-item" href="' . route('job.hasilpdf', $row->id) . '" title="Download PDF" target="_blank"><i class="fas fa-file-pdf"></i> Download PDF</a></li>
    </ul>
</div>';
                    } else {
                        $action = '
<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Aksi
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="' . route('job.kalibrasi', $row->id) . '" title="Kalibrasi" target="_blank"><i class="fas fa-file-signature"></i> Kalibrasi</a></li>
        <li><a class="dropdown-item" href="' . route('job.HasilKalibrasi', $row->id) . '" title="Hasil Kalibrasi" target="_blank"><i class="fas fa-file-signature"></i> Hasil Kalibrasi</a></li>
        <li><a class="dropdown-item" href="' . route('job.downloadExcel', $row->id) . '" title="Download Excel" target="_blank"><i class="fas fa-file-excel"></i> Download Excel</a></li>
        <li><a class="dropdown-item" href="' . route('job.hasilpdf', $row->id) . '" title="Download PDF" target="_blank"><i class="fas fa-file-pdf"></i> Download PDF</a></li>
    </ul>
</div>';
                    }


                    return $action;
                })
                ->addColumn('statsertifikat', function ($row) {
                    if ($row->Disetujui == null) {
                        $stat = '<span class="badge bg-warning">DRAFT</span>';
                    } elseif ($row->Disetujui = "Y") {
                        $stat = '<span class="badge bg-success">TERBIT</span>';
                    }
                    return $stat;
                })
                ->addColumn('Approve', function ($row) {
                    if ($row->TanggalPelaksanaan === null) {
                        $Approve = '<span class="badge bg-warning">BELUM KALIBRASI</span>';
                    } else {

                        if ($row->Disetujui == null) {
                            $Approve = ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-secondary mb-2 showModal" ><i class="fas fa-clipboard-check"></i></a>';
                        } else {
                            if ($row->Disetujui == 'Y') {
                                $Approve = '<span class="badge light badge-success text-dark">
<i class="fas fa-check-circle text-success me-1"></i>
' . ($row->getKaryawan->name ?? 'error') . '
t</span>';
                            } else {
                                $Approve = '<span class="badge light badge-danger text-dark">
<i class="fas fa-times-circle text-danger me-1"></i>
' . ($row->getKaryawan->name ?? 'error') . '
</span>';
                            }
                        }
                    }

                    return $Approve;
                })
                ->addColumn('Verfifteknis', function ($row) {
                    if ($row->TanggalPelaksanaan === null) {
                        $Verfifteknis = '<span class="badge bg-warning">BELUM KALIBRASI</span>'; // Not calibrated
                    } else {

                        if ($row->getVerif === null) {
                            $Verfifteknis = '<a href="javascript:void(0)" data-nosert="' . $row->NoSertifikat . '" data-id="' . $row->id . '" class="btn btn-sm btn-primary mb-2 ModalVerif"><i class="fa-solid fa-file-signature"></i></a>';
                        } else {
                            $Verfifteknis = '<span class="badge light badge-success text-dark">
                <i class="fas fa-check-circle text-success me-1"></i>
                ' . ($row->getVerifUser->name ?? 'Tidak Ada') . '
            </span>';
                        }
                    }
                    return $Verfifteknis;
                })
                ->addColumn('Validmutu', function ($row) {
                    if ($row->TanggalPelaksanaan === null) {
                        $Validmutu = '<span class="badge bg-warning">BELUM KALIBRASI</span>'; // Not calibrated
                    } else {

                        if ($row->getValid === null) {
                            $Validmutu = '<a href="javascript:void(0)" data-nosert="' . $row->NoSertifikat . '" data-id="' . $row->id . '" class="btn btn-sm btn-primary mb-2 ModalMutu"><i class="fa-solid fa-file-signature"></i></a>';
                        } else {
                            $Validmutu = '<span class="badge light badge-success text-dark">
                <i class="fas fa-check-circle text-success me-1"></i>
                ' . ($row->getVerifUser->name ?? 'Tidak Ada') . '
            </span>';
                        }
                    }

                    return $Validmutu;
                })
                ->addColumn('SertifikatNumber', function ($row) {
                    $prefix = substr($row->NoSertifikat, 0, 3);
                    $number = substr($row->NoSertifikat, 3);
                    return $prefix . '-' . $number;
                })
                ->addColumn('OrderNumber', function ($row) {
                    $prefix = substr($row->SertifikatOrder, 0, 3);
                    $number = substr($row->SertifikatOrder, 3);
                    return $prefix . '-' . $number;
                })
                ->rawColumns(['action', 'statsertifikat', 'Approve', 'Verfifteknis', 'Validmutu', 'SertifikatNumber', 'OrderNumber'])
                ->make(true);
        }
        $instrumen = Instrumen::get();
        return view('sertifikat.index', compact('instrumen'));
    }

    public function Approval(Request $request)
    {
        $id = $request->id;
        $data = Sertifikat::find($id);

        if ($data) {
            $data->Disetujui = $request->Approve;
            $data->DisetujuiOleh = auth()->user()->id;
            $data->DisetujuiPada = now();
            $data->Catatan = $request->Catatan ?? null;

            $data->save();
        }

        if ($request->Approve == 'Y') {
            $ket = 'Disetujui';
        } else {
            $ket = 'Ditolak';
        }

        return redirect()->back()->with('success', 'Sertifikat Telah di' . $ket);
    }

    public function getVerifTeknis($id, Request $request)
    {
        $data = VerifTeknis::where('SertifikatId', $id)->first();

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json(['error' => 'Data Tidak Ditemukan'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $cek = Sertifikat::find($id);
        // dd($id);
        $cekNamaFunction = instrumen::where('id', $cek->InstrumenId)->first()->NamaFunction;
        $sertifikat = Sertifikat::with(
            'getCustomer',
            'getNamaAlat',
            'getSertifikatTanpaLK',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getTeganganUtama',
            'getPengukuranListrik',
            'getNebulizerPengujian',
            'getTelaahTeknis'
        )->where('id', $id)->first();
        // dd($sertifikat);
        $satuan = MasterSatuan::get();
        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        // $function = 'Store' . $cekNamaFunction;
        // $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
        // $function = 'Store' . $cekNamaFunction;
        // $namaController = $cekNamaFunction . 'Controller';
        // $cont = "App" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $namaController;
        // $cont = new $cont;
        $namaController = $cekNamaFunction . 'Controller';
        $controllerClass = 'App\\Http\\Controllers\\' . $namaController;
        // dd($controllerClass);
        if (!class_exists($controllerClass)) {
            return view('sertifikat.form-lk.administrasi', compact('sertifikat', 'satuan', 'getAlatUkur'));
        } else {
            $controllerInstance = new $controllerClass;
            return $controllerInstance->create($id);
        }
    }

    public function HasilKalibrasi($id)
    {
        $Sertifikat = Sertifikat::where('id', $id)->first();
        $data = SertifikatHal::where('Sertifikatid', $id)->first();

        return view('sertifikat.hasil-kalibrasi', compact('Sertifikat', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $sertifikat = Sertifikat::where('id', $data['sertifikatid'])->update([
            'Merk' => $data['merk'],
            'Type' => $data['type_model'],
            'SerialNumber' => $data['nomor_seri'],
            'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
            'TanggalDiterima' => $data['tanggal_terima'],
            'TanggalTerbit' => null,
            'Ruangan' => $data['instansi_ruangan'],
            'Hasil' => $data['HasilAdm'],
            'Resolusi' => $data['resolusi'],
            'MetodeId' => $data['MetodeId'],
            'Satuan' => $data['Satuan'],
            'Status' => 'AKTIF',
            'idUser' => auth()->user()->id,
            'TanpaLK' => 'N',
            'filename' => $newFileName ?? null,
        ]);

        $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
        // $function = 'Store' . $cekNamaFunction;
        // $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
        // $function = 'Store' . $cekNamaFunction;
        // $namaController = $cekNamaFunction . 'Controller';
        // $cont = "App" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $namaController;
        // $cont = new $cont;
        $namaController = $cekNamaFunction . 'Controller';
        $controllerClass = 'App\\Http\\Controllers\\' . $namaController;
        if (!class_exists($controllerClass)) {
            return redirect()->route('job.index')->with('success', 'Data Berhasil Disimpan');
        } else {
            $controllerInstance = new $controllerClass;
            return $controllerInstance->store($data);
        }

    }

    //COBA COBA
    public function StoreTanpaLK(Request $request)
    {
        $data = $request->all();
        $sertifikat = Sertifikat::where('id', $data['sertifikatid'])->update([
            'Merk' => $data['merk'],
            'Type' => $data['type_model'],
            'SerialNumber' => $data['nomor_seri'],
            'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
            'TanggalDiterima' => $data['tanggal_terima'],
            'TanggalTerbit' => null,
            'Ruangan' => $data['instansi_ruangan'],
            'Hasil' => $data['HasilAdm'],
            'Resolusi' => $data['resolusi'],
            'MetodeId' => $data['MetodeId'],
            'Satuan' => $data['Satuan'],
            'Status' => 'AKTIF',
            'idUser' => auth()->user()->id,
            'TanpaLK' => 'Y',
            'filename' => $newFileName ?? null,
        ]);

        $KondisiLingkungan = SertifikatKondisiLingkungan::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'TempraturAwal' => $data['KondisiAwal'][0],
                'TempraturAkhir' => $data['KondisiAkhir'][0],
                'KelembapanAwal' => $data['KondisiAwal'][1],
                'KelembapanAkhir' => $data['KondisiAkhir'][1],
                'idUser' => auth()->user()->id
            ]
        );
        if (!empty($request->Tegangan_LN)) {
            $kondisiListrik = SertifikatKondisiKelistrikan::updateOrCreate(
                ['SertifikatId' => $data['sertifikatid']],
                [
                    'InstrumenId' => $data['idinstrumen'],
                    'Tegangan_LN' => $data['val'][0],
                    'Tegangan_LPE' => $data['val'][1],
                    'Tegangan_NPE' => $data['val'][2],
                    'idUser' => auth()->user()->id
                ]
            );
        }

        // $halaman2 = $request->Halaman2;
        // $halaman2 = str_replace('<table style="border-collapse: collapse; width: 100%;" border="1" width="525pt" cellspacing="0" cellpadding="0">', '<table id="tablehal2" width="100%" border="1px" style="border-collapse: collapse;  border: 1px solid #000000;">', $halaman2);
        $Halaman2 = $request->Halaman2;
        $Halaman2 = str_replace('<table style="border-collapse: collapse; width: 100%;" border="1" width="525pt" cellspacing="0" cellpadding="0">', '<table id="tablehal2" width="100%" border="1px" style="border-collapse: collapse;  border: 1px solid #000000;">', $Halaman2);
        $Halaman3 = $request->Halaman3;
        $Halaman3 = str_replace('<table style="border-collapse: collapse; width: 100%;" border="1" width="525pt" cellspacing="0" cellpadding="0">', '<table id="tablehal2" width="100%" border="1px" style="border-collapse: collapse;  border: 1px solid #000000;">', $Halaman3);
        $Isi = SertifikatManual::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Halaman2' => $Halaman2 ?? null,
                'Halaman3' => $Halaman3 ?? null,
                'Halaman4' => $data['Halaman4'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        return redirect()->route('job.index')->with('success', 'Data Berhasil Disimpan');
    }
    public function storeHasil(Request $request)
    {
        $replace = $request->HasilKalibrasi;
        $replace = str_replace('<table>', '<table id="tablehal2" width="100%" border="1px" style="border-collapse: collapse;  border: 1px solid #000000;">', $replace);
        SertifikatHal::updateOrCreate(
            ['SertifikatId' => $request->SertifikatId],
            [
                'HasilKalibrasi' => $replace,
                'idUser' => auth()->user()->id,
            ]
        );

        return redirect()->route('job.index')->with('success', 'Sertifikat Halaman Ketiga Berhasil Di Perbarui');
    }

    public function StoreVerif(Request $request)
    {
        $data = $request->all();
        $data['SertifikatId'] = $request->idSertifikat;
        $data['idUser'] = auth()->user()->id;
        VerifTeknis::create($data);

        $dataSertifikat = Sertifikat::find($request->idSertifikat);
        $dataSertifikat->update([
            'ValidTeknisOleh' => auth()->user()->id,
            'ValidTeknisPada' => now(),
        ]);

        return redirect()->back()->with('success', 'Sertifikat Telah Di Verifikasi');
    }

    public function StoreMutu(Request $request)
    {
        $data = $request->all();
        $data['SertifikatId'] = $request->idSertifikat;
        $data['idUser'] = auth()->user()->id;
        // dd($data);
        ValidasiMutu::create($data);

        $dataSertifikat = Sertifikat::find($request->idSertifikat);
        $dataSertifikat->update([
            'ValidMutuOleh' => auth()->user()->id,
            'ValidMutuPada' => now(),
        ]);
        return redirect()->back()->with('success', 'Sertifikat Telah Di Validasi');
    }

    /**
     * Display the specified resource.
     */
    public function downloadExcel($id)
    {
        $cek = Sertifikat::where('id', $id)->first()->SerialNumber;
        if (!$cek) {
            return redirect()->back()->with('error', 'Maaf, Alat Belum Dikalibrasi');
        }

        $getIdInstrumen = sertifikat::where('id', $id)->first()->InstrumenId;
        $cek = instrumen::where('id', $getIdInstrumen)->first()->LK;
        $filePath = storage_path('app/public/file_lk/' . $cek);
        // LOAD EXCEL
        $spreadsheet = IOFactory::load($filePath);
        // AMBIL SHEET
        $sheet = $spreadsheet->getSheetByName('LK yg diisi');

        $cekNamaFunction = instrumen::where('id', $getIdInstrumen)->first()->NamaFunction;
        $namaController = $cekNamaFunction . 'Controller';
        $controllerClass = 'App\\Http\\Controllers\\' . $namaController;

        $controllerInstance = new $controllerClass;
        return $controllerInstance->cetakExcel($id, $sheet, $spreadsheet);
    }

    public function HasilPdf($id)
    {
        $cek = Sertifikat::where('id', $id)->first()->SerialNumber;
        if (!$cek) {
            return redirect()->back()->with('error', 'Maaf, Alat Belum Dikalibrasi');
        }
        $data = Sertifikat::with([
            'getNamaAlat',
            'getCustomer',
            'getHasilKalibrasi',
            'getPengukuranKondisiLingkungan' => function ($query) {
                $query->selectRaw('*, (TempraturAwal + TempraturAkhir) / 2 as SuhuRataRata, (KelembapanAwal + KelembapanAkhir) / 2 as KelembapanRataRata');
            },
            'getNamaAlat',
            'getMetode',
            'getSatuan',
            'getPmeriksaanFisikFungsi',
            'getUser'
        ])->where('id', $id)->first();
        $alatUkurId = $data->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        $ttd = User::where('jabatan', 'General Manager')->first()->DigitalSign;
        //cek untuk ke halaman administrasi aja
        if ($data->TanpaLK == 'Y') {
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('sertifikat.sertifikat-pdf-administrasi-only', compact('data', 'getAlatUkur', 'ttd'));
            $pdf->output();
            $domPdf = $pdf->getDomPDF();
            $canvas = $domPdf->get_canvas();

            $canvas->page_text(330, 827, "Sertifikat ini terdiri dari / This certificate consists of : {PAGE_NUM} of {PAGE_COUNT}", null, 10, [255, 255, 255]);
        } else {
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('sertifikat.sertifikat-pdf', compact('data', 'getAlatUkur', 'ttd'));
            $pdf->output();
            $domPdf = $pdf->getDomPDF();
            $canvas = $domPdf->get_canvas();

            $canvas->page_text(330, 827, "Sertifikat ini terdiri dari / This certificate consists of : {PAGE_NUM} of {PAGE_COUNT}", null, 10, [255, 255, 255]);
        }

        return $pdf->stream('sertifikat_pdf' . $data->getNamaAlat->NamaAlat . '.pdf');
    }
}
