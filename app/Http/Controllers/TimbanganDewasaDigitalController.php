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
use App\Models\SertifikatTimbanganPengujian;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TimbanganDewasaDigitalController extends Controller
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
            'getPengujianTimbangan',
            'getTelaahTeknis'
        )->where('id', $id)->first();

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
            [
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen']
            ],
            [
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

        // Pengukuran Half
        $half = SertifikatTimbanganPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'KINERJA',
                'MassaHalf' => ['$exists' => true]
            ],
            [
                'MassaHalf' => $data['MassaHalf'] ?? null,
                'PengujianZ' => $data['PengujianZhalf'] ?? null,
                'PengujianM' => $data['PengujianMhalf'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        // Pengukuran Max
        $max = SertifikatTimbanganPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'KINERJA',
                'MassaMax' => ['$exists' => true]
            ],
            [
                'MassaMax' => $data['MassaMax'] ?? null,
                'PengujianZ' => $data['PengujianZmax'] ?? null,
                'PengujianM' => $data['PengujianMmax'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        // Pengukuran Nominal (SKALA)
        $nominal = SertifikatTimbanganPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'SKALA'
            ],
            [
                'PengujianZ' => $data['PengujianZnom'] ?? null,
                'PengujianM' => $data['PengujianMnom'] ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        // Telaah Teknis
        $telaahteknis = SertifikatTelaahTeknis::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen']
            ],
            [
                'FisikFungsi' => $data['HasilTeknis'][0] ?? null,
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
            'getPengujianTimbangan',
            'getTelaahTeknis'
        ])->find($idsertifikat);
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
        $sheet->setCellValue('D31', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G31', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D32', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G32', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter1[1]);
        $sheet->setCellValue('E39', $data->getPmeriksaanFisikFungsi->Parameter2[1]);
        $sheet->setCellValue('E40', $data->getPmeriksaanFisikFungsi->Parameter3[1]);
        // PENGUJIAN KINERJA TEKANAN DARAH


        $kinerja = $data->getPengujianTimbangan->where('TipePengujian', 'KINERJA');
        // dd($kinerja);
        $rowSkala = 44;
        $pengujianhalfCount = count($kinerja[0]->PengujianM);
        for ($key = 0; $key < $pengujianhalfCount; $key++) {
            // $d = $kinerja->PengujianM[$key];
            $sheet->setCellValue('D' . $rowSkala, $kinerja[0]->PengujianZ[$key]);
            $sheet->setCellValue('E' . $rowSkala, $kinerja[0]->PengujianM[$key]);
            $rowSkala++;
        }

        $pengujianMAXCount = count($kinerja[1]->PengujianM);
        $rowSkalaMax = 44;
        for ($key = 0; $key < $pengujianMAXCount; $key++) {
            // $d = $kinerja->PengujianM[$key];
            $sheet->setCellValue('J' . $rowSkalaMax, $kinerja[1]->PengujianZ[$key]);
            $sheet->setCellValue('K' . $rowSkalaMax, $kinerja[1]->PengujianM[$key]);
            $rowSkalaMax++;
        }
        $nominal = $data->getPengujianTimbangan->where('TipePengujian', 'SKALA')->first();
        $pengujianNOMCount = count($kinerja[1]->PengujianM);
        $rowNom = 57;
        for ($key = 0; $key < $pengujianNOMCount; $key++) {
            // $d = $kinerja->PengujianM[$key];
            $sheet->setCellValue('B' . $rowNom, $nominal->PengujianZ[$key]);
            $sheet->setCellValue('C' . $rowNom, $nominal->PengujianM[$key]);
            $rowNom++;
        }

        // TELAAH TEKNIS
        $sheet->setCellValue('C69', $data->getTelaahTeknis->FisikFungsi) ?? 0;
        $sheet->setCellValue('C70', $data->getTelaahTeknis->Kinerja) ?? 0;
        $sheet->mergeCells('C71:E71');
        $sheet->setCellValue('C71', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C71')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
