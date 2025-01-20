<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\Sertifikat;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatTelaahTeknis;
use App\Models\SertifikatTensimeterDigitalPengujian;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TensimeterDigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $sertifikat = Sertifikat::with(
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getPengujianTensimeterDigital',
            'getTelaahTeknis'
        )->where('id', $id)->first();
        // dd($sertifikat);
        $InstrumenId = $sertifikat->InstrumenId;
        $cek = Instrumen::where('id', $InstrumenId)->first()->NamaFile;
        $FormLK = 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $cek;

        $metode = MasterMetode::get();
        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        $satuan = MasterSatuan::get();
        return view($FormLK, compact('sertifikat', 'metode', 'getAlatUkur', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($data)
    {
        // Kondisi Lingkungan
        $KondisiLingkungan = SertifikatKondisiLingkungan::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'TempraturAwal' => $data['KondisiAwal'][0],
                'TempraturAkhir' => $data['KondisiAkhir'][0],
                'KelembapanAwal' => $data['KondisiAwal'][1],
                'KelembapanAkhir' => $data['KondisiAkhir'][1],
                'idUser' => auth()->user()->id
            ]
        );

        // Fisik Fungsi
        $FisikFungsi = SertifikatFisikFungsi::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid']
            ],
            [
                'InstrumenId' => $data['idinstrumen'] ?? null,
                'Parameter1' => $data['Parameter1'] ?? null,
                'Parameter2' => $data['Parameter2'] ?? null,
                'Parameter3' => $data['Parameter3'] ?? null,
                'Parameter4' => $data['Parameter4'] ?? null,
                'Parameter5' => $data['Parameter5'] ?? null,
                'Parameter6' => $data['Parameter6'] ?? null,
                'Parameter7' => $data['Parameter7'] ?? null,
                'Parameter8' => $data['Parameter8'] ?? null,
                'Parameter9' => $data['Parameter9'] ?? null,
                'Parameter10' => $data['Parameter10'] ?? null,
                'Parameter11' => $data['Parameter11'] ?? null,
                'Parameter12' => $data['Parameter12'] ?? null,
                'Parameter13' => $data['Parameter13'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        // Pengukuran Kinerja
        for ($i = 0; $i < count($data['Titik_Ukur_Nama']); $i++) {

            $pengukurankinerja = SertifikatTensimeterDigitalPengujian::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                ],
                [
                    'TitikUkur' => $data['Titik_Ukur_Hasil'][$i],
                    'InstrumenId' => $data['idinstrumen'],
                    'TipePengujian' => 'TEKANANDARAH',
                    'TipeTitikUkur' => $data['Titik_Ukur_Nama'][$i],
                    'Pengulangan1' => $data['Pengulangan1_Tekanan_Darah'][$i],
                    'Pengulangan2' => $data['Pengulangan2_Tekanan_Darah'][$i],
                    'Pengulangan3' => $data['Pengulangan3_Tekanan_Darah'][$i],
                    'idUser' => auth()->user()->id
                ]
            );
        }
        // Telaah Teknis
        $telaahteknis = SertifikatTelaahTeknis::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'FisikFngsi' => $data['HasilTeknis'][0] ?? null,
                'KeselamatanListrik' => $data['HasilTeknis'][1] ?? null,
                'Kinerja' => $data['HasilTeknis'][2] ?? null,
                'Catatan' => $data['Catatan'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );
        return redirect()->route('job.index')->with('success', 'Data Berhasil Disimpan');
    }
    public function cetakExcel($idsertifikat, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getPengujianTensimeterDigital',
            'getTelaahTeknis'
        ])->find($idsertifikat);
        // dd($data);
        $sheet->setCellValue('C8', $data->SertifikatOrder);
        $sheet->setCellValue('C9', $data->Merk);
        $sheet->setCellValue('C10', $data->Type);
        $sheet->setCellValue('C11', $data->SerialNumber);
        $sheet->setCellValue('C12', $data->TanggalPelaksanaan);
        $sheet->setCellValue('C13', $data->Ruangan);
        $sheet->setCellValue('C14', $data->Resolusi);
        $sheet->setCellValue('F9', $data->getCustomer->Name);
        $sheet->setCellValue('F10', $data->getCustomer->Alamat);
        $sheet->setCellValue('F12', $data->TanggalDiterima);
        // DATA ALAT UKUR
        $RowAlatUkur = 20;
        foreach ($data->getNamaAlat as $alat) {
            if (is_object($alat) && isset($alat->AlatUkur)) {
                foreach ($alat->AlatUkur as $idAlatUkur) {
                    $alatUkur = inventori::find($idAlatUkur);
                    if ($alatUkur) {
                        $sheet->setCellValue('B' . $RowAlatUkur, $alatUkur->Nama);
                        $sheet->setCellValue('C' . $RowAlatUkur, $alatUkur->Merk);
                        $sheet->setCellValue('D' . $RowAlatUkur, $alatUkur->Tipe);
                        $sheet->setCellValue('E' . $RowAlatUkur, $alatUkur->Sn);
                        $sheet->setCellValue('F' . $RowAlatUkur, $alatUkur->Tertelusur);
                        $RowAlatUkur++;
                    }
                }
            }
        }
        // dd($data);
        $sheet->setCellValue('D26', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G26', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D27', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G27', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E33', $data->getPmeriksaanFisikFungsi->Parameter1[1]);
        $sheet->setCellValue('E34', $data->getPmeriksaanFisikFungsi->Parameter2[1]);
        $sheet->setCellValue('E35', $data->getPmeriksaanFisikFungsi->Parameter3[1]);
        $sheet->setCellValue('E36', $data->getPmeriksaanFisikFungsi->Parameter4[1]);
        $sheet->setCellValue('E37', $data->getPmeriksaanFisikFungsi->Parameter5[1]);
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter6[1]);
        // PENGUJIAN KINERJA HEARTRATE
        // dd($data->getPengujianTensimeterDigital);
        // PENGUJIAN KINERJA TEKANAN DARAH
        $tekanandarah = $data->getPengujianTensimeterDigital->where('TipePengujian', 'TEKANANDARAH');
        $rowtekanandarah = 44;
        foreach ($tekanandarah as $key => $d) {
            $sheet->setCellValue('D' . $rowtekanandarah, $d->TipeTitikUkur);
            $sheet->setCellValue('E' . $rowtekanandarah, $d->TitikUkur);
            $sheet->setCellValue('F' . $rowtekanandarah, $d->Pengulangan1);
            $sheet->setCellValue('G' . $rowtekanandarah, $d->Pengulangan2);
            $sheet->setCellValue('H' . $rowtekanandarah, $d->Pengulangan3);
            $rowtekanandarah++;
        }
        // TELAAH TEKNIS
        $sheet->setCellValue('C58', $data->getTelaahTeknis->FisikFungsi) ?? 0;
        $sheet->setCellValue('C59', $data->getTelaahTeknis->Kinerja) ?? 0;
        $sheet->mergeCells('C60:E60');
        $sheet->setCellValue('C60', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C60')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
