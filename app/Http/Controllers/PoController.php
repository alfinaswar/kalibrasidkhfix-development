<?php

namespace App\Http\Controllers;

use App\Models\AkomodasiDetail;
use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\KajiUlang;
use App\Models\MasterAkomodasi;
use App\Models\MasterCustomer;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\po;
use App\Models\poDetail;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\SerahTerima;
use App\Models\Sertifikat;
use App\Models\User;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PoController extends Controller
{
    public function index(Request $request)
    {
        $data = po::with('getCustomer', 'getKaryawan')->orderBy('id', 'Desc')->get();

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
        <li><a class="dropdown-item" href="' . route('po.edit', $row->id) . '" title="Edit"><i class="fas fa-edit"></i> Edit</a></li>
        <li><a class="dropdown-item" href="' . route('po.pdf', $row->id) . '" target="_blank" title="Pdf"><i class="fas fa-file-pdf"></i> PDF</a></li>
        <li><a class="dropdown-item" href="' . route('po.stiker', $row->id) . '" target="_blank" title="Detail"><i class="fas fa-tags"></i> Cetak Stiker</a></li>
    </ul>
</div>';
                    $btnDel = '<a class="btn btn-sm btn-danger btn-delete" href="javascript:void(0)" data-id="' . $row->id . '" title="Hapus"><i class="fas fa-trash-alt"></i> </a>';
                    return $btnDel . ' ' . $action;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'AKTIF') {
                        $Stat = '<span class="badge bg-success">AKTIF</span>';
                    } else {
                        $Stat = '<span class="badge bg-warning">TIDAK AKTIF</span>';
                    }

                    return $Stat;
                })
                ->addColumn('Approve', function ($row) {
                    if ($row->Approve == null) {
                        $Approve = ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-secondary mb-2 showModal" ><i class="fas fa-clipboard-check"></i></a>';
                    } else {
                        if ($row->Approve == 'Y') {
                            $Approve = "<span class=\"badge light badge-success text-dark\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-check-circle text-success me-1\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t" . $row->getKaryawan->name . "
\t\t\t\t\t\t\t\t\t\t\t\t\t</span>";
                        } else {
                            $Approve = "<span class=\"badge light badge-danger text-dark\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-times-circle text-danger me-1\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t" . $row->getKaryawan->name . "
\t\t\t\t\t\t\t\t\t\t\t\t\t</span>";
                        }
                    }
                    return $Approve;
                })
                ->rawColumns(['action', 'Stat', 'Approve'])
                ->make(true);
        }

        $dataQuotation = Quotation::with('getCustomer', 'getPO')
            ->doesntHave('getPO')
            ->where('Status', '!=', 'DITOLAK')
            ->where('Approve', 'Y')
            ->latest()
            ->get();
        // dd($dataQuotation);
        return view('po.index', compact('dataQuotation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $getQuotation = Quotation::with([
            'DetailQuotation' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            },
            'getAkomodasiDetail'
        ])
            ->where('id', $id)
            ->first();
        // dd($getQuotation);
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::get();
        $Akomodasi = MasterAkomodasi::all();
        // dd($instrumen);
        return view('po.form-po', compact('Akomodasi', 'customer', 'getQuotation', 'instrumen'));
    }

    public function createTanpaQo(Request $request)
    {
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::get();
        return view('po.form-po-mandiri', compact('customer', 'instrumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($this->GenerateNoSertifikat(), $this->GenerateSertifikatOrder());
        $data = $request->all();
        // dd($data);
        $data['KodePo'] = $this->GenerateKode();
        $data['QuotationId'] = $request->QuotationId;
        $data['TipeDiskon'] = $request->TipeDiskon ?? 'flat';
        $data['Diskon'] = str_replace('.', '', $request->TotalDiskon ?? 0);
        $data['Subtotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);
        $data['idUser'] = auth()->user()->id;
        po::create($data);
        $getid = po::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            $harga = str_replace('.', '', $request->Harga[$i]);
            if ($request->Qty[$i] > 1) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    poDetail::create([
                        'PoId' => $getid,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Qty' => '1',
                        'Harga' => $harga,
                        'Deskripsi' => '-',
                        'idUser' => auth()->user()->id,
                    ]);
                    Sertifikat::create([
                        'NoSertifikat' => $this->GenerateNoSertifikat(),
                        'SertifikatOrder' => $this->GenerateSertifikatOrder(),
                        'PoId' => $getid,
                        'Status' => 'AKTIF',
                        'Diserahkan' => 'N',
                        'InstrumenId' => $request->InstrumenId[$i],
                        'CustomerId' => $request->CustomerId,
                    ]);
                }
            } else {
                poDetail::create([
                    'PoId' => $getid,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Qty' => '1',
                    'Harga' => $harga,
                    'Deskripsi' => '-',
                    'idUser' => auth()->user()->id,
                ]);
                Sertifikat::create([
                    'NoSertifikat' => $this->GenerateNoSertifikat(),
                    'SertifikatOrder' => $this->GenerateSertifikatOrder(),
                    'PoId' => $getid,
                    'Status' => 'AKTIF',
                    'Diserahkan' => 'N',
                    'InstrumenId' => $request->InstrumenId[$i],
                    'CustomerId' => $request->CustomerId,
                ]);
            }
        }
        if ($request->AkomodasiId[0] != null) {
            $getAkomodasi = MasterAkomodasi::find($request->AkomodasiId);

            for ($i = 0; $i < count($request->AkomodasiId); $i++) {
                AkomodasiDetail::create([
                    'PoId' => $getid,
                    'AkomodasiId' => $request->AkomodasiId[$i],
                    'Qty' => $request->QtyAkomodasi[$i],
                    'Price' => str_replace('.', '', $request->HargaAkomodasi[$i]),
                    'Deskripsi' => $request->DeskripsiAkomodasi[$i] ?? null,
                    'idUser' => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('po.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function Approval(Request $request)
    {
        $id = $request->id;
        $Quotation = po::find($id);

        if ($Quotation) {
            $Quotation->Approve = $request->Approve;
            $Quotation->ApproveBy = auth()->user()->id;
            $Quotation->ApproveDate = now();
            $Quotation->Catatan = $request->Catatan ?? null;
            $Quotation->save();
        }

        if ($request->Approve == 'Y') {
            $ket = 'Disetujui';
        } else {
            $ket = 'Ditolak';
        }

        return redirect()->back()->with('success', 'Quotation Telah di' . $ket);
    }

    /**
     * Display the specified resource.
     */
    public function show(po $po)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = po::with([
            'DetailPo' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId');
            },
            'getAkomodasiDetail'
        ])->where('id', $id)->first();
        // dd($data);
        $user = User::all();
        $Akomodasi = MasterAkomodasi::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('po.edit', compact('data', 'user', 'customer', 'instrumen', 'Akomodasi'));
    }

    public function infoKalibrasi($NoSertifikat)
    {

        $sertifikat = Sertifikat::with('getCustomer', 'getNamaAlat')->where('NoSertifikat', $NoSertifikat)->first();
        $InstrumenId = $sertifikat->InstrumenId;
        $id = $sertifikat->id;
        $cek = Instrumen::where('id', $InstrumenId)->first()->NamaFile;
        $FormLK = 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $cek;

        $metode = MasterMetode::get();
        $satuan = MasterSatuan::get();
        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        if ($sertifikat->TanggalPelaksanaan == null) {
            $cekNamaFunction = instrumen::where('id', $InstrumenId)->first()->NamaFunction;
            // $function = 'Store' . $cekNamaFunction;
            // $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
            // $function = 'Store' . $cekNamaFunction;
            // $namaController = $cekNamaFunction . 'Controller';
            // $cont = "App" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $namaController;
            // $cont = new $cont;
            $namaController = $cekNamaFunction . 'Controller';
            $controllerClass = 'App\\Http\\Controllers\\' . $namaController;
            $controllerInstance = new $controllerClass;
            return $controllerInstance->create($id);
        } else {
            return redirect()->route('job.hasilpdf', $sertifikat->id);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'CustomerId' => 'required',
            'Status' => 'required',
            'TanggalPo' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Diskon'] = str_replace('.', '', $request->TotalDiskon);
        $data['Subtotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);

        $Quotation = po::find($id);
        $Quotation->update($data);
        $Quotation->DetailPo()->delete();

        foreach ($request->InstrumenId as $key => $value) {
            $harga = str_replace('.', '', $request->Harga[$key]);
            $subtotal = str_replace('.', '', $request->SubTotal[$key]);
            $qty = $request->Qty[$key];
            for ($i = 0; $i < $qty; $i++) {
                poDetail::create([
                    'PoId' => $request->id,
                    'InstrumenId' => $value,
                    'Qty' => 1,
                    'Harga' => $harga,
                    'idUser' => auth()->user()->id,
                ]);
            }
        }
        for ($i = 0; $i < count($request->AkomodasiId); $i++) {
            AkomodasiDetail::updateOrCreate(
                ['PoId' => $id, 'AkomodasiId' => $request->AkomodasiId[$i]],
                [
                    'Qty' => $request->QtyAkomodasi[$i],
                    'Price' => str_replace('.', '', $request->HargaAkomodasi[$i]),
                    'Deskripsi' => $request->DeskripsiAkomodasi[$i] ?? null,
                    'idUser' => auth()->user()->id,
                ]
            );
        }
        return redirect()->route('po.index')->with('success', 'Data Berhasil Diupdate');
    }

    public function generatePdf($id)
    {
        $data = po::with([
            'DetailPo' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            },
            'getCustomer',
            'getKaryawan',
            'getUser',
            'getAkomodasiDetail.getAkomodasi',
            'DetailPo.getNamaAlat'
        ])
            ->where('id', $id)
            ->first();
        $ttdAprove = $data->getKaryawan->DigitalSign ?? null;
        $ttdbuat = $data->getUser->DigitalSign ?? null;
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('po.cetak-pdf', compact('data', 'ttdAprove', 'ttdbuat'));
        return $pdf->stream('po.cetak-pdf' . $data->id . '.pdf');
    }

    public function CetakStiker($id)
    {
        $data = po::with(
            'DetailPo',
            'getCustomer',
            'DetailPo.getNamaAlat',
            'DetailPo.getSertifikat',
        )->where('id', $id)->first();
        // dd($data);
        // dd($data->DetailPo);
        // Generate Barcode garis Garis
        // $generator = new BarcodeGeneratorPNG();
        // $barcode = [];
        // foreach ($data->DetailPo as $item) {
        //     $barcode[$item->id] = base64_encode($generator->getBarcode($item->id, $generator::TYPE_CODE_128));
        // }
        // barcode QR
        // Generate QR code
        $writer = new PngWriter();
        $barcode = [];
        foreach ($data->DetailPo as $item) {
            $link = route('po.info', $item->getSertifikat->NoSertifikat);
            $qrCode = QrCode::create($link)
                ->setSize(50)
                ->setMargin(0);

            $barcode[$item->id] = base64_encode($writer->write($qrCode)->getString());
        }

        $viewData = [
            'KodePo' => $data->KodePo,
            'data' => $data,
            'barcode' => $barcode,  // Add barcode to view data
        ];

        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('po.format-stiker', $viewData)->setPaper([0, 0, 161.57, 70.0], 'portrait');

        return $pdf->stream('stiker.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = po::find($id);
        $data->DetailPo()->delete();
        $data->getAkomodasiDetail()->delete();
        $data->getSertifikat()->delete();
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKode = po::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodePo, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/POK-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/POK-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }

    private function GenerateNoSertifikat()
    {
        $month = date('m');
        $year = date('Y');
        $lastKode = Sertifikat::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->NoSertifikat, 9, 4);
            $NoReg = 'DKH' . $year . $month . str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $NoReg = 'DKH' . $year . $month . '0001';
        }
        return $NoReg;
    }

    private function GenerateSertifikatOrder()
    {
        $month = date('m');
        $year = date('Y');
        $lastKode = Sertifikat::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->SertifikatOrder, 9, 4);
            $NoReg = 'REG' . $year . $month . str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $NoReg = 'REG' . $year . $month . '0001';
        }
        return $NoReg;
    }
}
