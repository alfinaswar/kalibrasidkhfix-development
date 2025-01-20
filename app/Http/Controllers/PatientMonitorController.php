<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\PengukuranListrik;
use App\Models\Sertifikat;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatPatientMonitorPengujuan;
use App\Models\SertifikatTelaahTeknis;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PatientMonitorController extends Controller
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
            'getTeganganUtama',
            'getPengukuranListrik',
            'getPengujianPatientMonitor',
            'getTelaahTeknis'
        )->where('id', $id)->first();
        // dd($sertifikat);
        $heartrateData = $sertifikat->getPengujianPatientMonitor->filter(function ($item) {
            return $item->TipePengujian == 'HEARTRATE';
        });
        $respirasiData = $sertifikat->getPengujianPatientMonitor->filter(function ($item) {
            return $item->TipePengujian == 'RESPIRASI';
        });
        // dd($respirasiData);
        $saturasiData = $sertifikat->getPengujianPatientMonitor->filter(function ($item) {
            return $item->TipePengujian == 'SATURASI';
        });

        // dd($saturasiData);
        $tekanandarahData = $sertifikat->getPengujianPatientMonitor->filter(function ($item) {
            return $item->TipePengujian == 'TEKANANDARAH';
        });
        // dd($tekanandarahData);

        $InstrumenId = $sertifikat->InstrumenId;
        $cek = Instrumen::where('id', $InstrumenId)->first()->NamaFile;
        $FormLK = 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $cek;

        $metode = MasterMetode::get();
        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        $satuan = MasterSatuan::get();
        return view($FormLK, compact('sertifikat', 'metode', 'getAlatUkur', 'satuan', 'heartrateData', 'saturasiData', 'tekanandarahData', 'respirasiData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($data)
    {
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
        $kondisiListrik = SertifikatKondisiKelistrikan::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Tegangan_LN' => $data['val'][0],
                'Tegangan_LPE' => $data['val'][1],
                'Tegangan_NPE' => $data['val'][2],
                'idUser' => auth()->user()->id
            ]
        );
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
        $PengukuranListrik = PengukuranListrik::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'tipe' => $data['TipeListrik'],
                'kelas' => $data['Kelas'],
                'Parameter1' => $data['TerukurListrik2'][0],
                'Parameter2' => $data['TerukurListrik2'][1],
                'Parameter3' => $data['TerukurListrik2'][2],
                'Parameter4' => $data['TerukurListrik2'][3],
                'Parameter5' => $data['TerukurListrik2'][4],
                'Parameter6' => $data['TerukurListrik2'][5],
                'idUser' => auth()->user()->id
            ]
        );

        // pengukuran kinerja heartrate
        for ($i = 0; $i < count($data['Titik_Ukur_Heartrate']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                ],
                [
                    'InstrumenId' => $data['idinstrumen'],
                    'TitikUkur' => $data['Titik_Ukur_Heartrate'][$i],
                    'TipePengujian' => 'HEARTRATE',
                    'Pengulangan1' => $data['Pengulangan1_Heartrate'][$i],
                    'Pengulangan2' => $data['Pengulangan2_Heartrate'][$i],
                    'Pengulangan3' => $data['Pengulangan3_Heartrate'][$i],
                    'idUser' => auth()->user()->id
                ]
            );
        }
        // pengukuran kinerja respirasi
        for ($i = 0; $i < count($data['Titik_Ukur_Respirasi']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                ],
                [
                    'InstrumenId' => $data['idinstrumen'],
                    'TitikUkur' => $data['Titik_Ukur_Respirasi'][$i],
                    'TipePengujian' => 'RESPIRASI',
                    'Pengulangan1' => $data['Pengulangan1_Respirasi'][$i],
                    'Pengulangan2' => $data['Pengulangan2_Respirasi'][$i],
                    'Pengulangan3' => $data['Pengulangan3_Respirasi'][$i],
                    'idUser' => auth()->user()->id
                ]
            );
        }
        // pengukuran kinerja oksigen
        for ($i = 0; $i < count($data['Titik_Ukur_saturasi_oksigen']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                ],
                [
                    'InstrumenId' => $data['idinstrumen'],
                    'TitikUkur' => $data['Titik_Ukur_saturasi_oksigen'][$i],
                    'TipePengujian' => 'SATURASI',
                    'Pengulangan1' => $data['Pengulangan1_saturasi_oksigen'][$i],
                    'Pengulangan2' => $data['Pengulangan2_saturasi_oksigen'][$i],
                    'Pengulangan3' => $data['Pengulangan3_saturasi_oksigen'][$i],
                    'idUser' => auth()->user()->id
                ]
            );
        }
        // pengukuran kinerja oksigen
        for ($i = 0; $i < count($data['Titik_Ukur_Nama']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                ],
                [
                    'InstrumenId' => $data['idinstrumen'],
                    'TipeTitikUkur' => $data['Titik_Ukur_Nama'][$i],
                    'TipePengujian' => 'TEKANANDARAH',
                    'TitikUkur' => $data['Titik_Ukur_Hasil'][$i],
                    'Pengulangan1' => $data['Pengulangan1_Tekanan_Darah'][$i],
                    'Pengulangan2' => $data['Pengulangan2_Tekanan_Darah'][$i],
                    'Pengulangan3' => $data['Pengulangan3_Tekanan_Darah'][$i],
                    'idUser' => auth()->user()->id
                ]
            );
        }
        // telaah teknis
        $telaahteknis = SertifikatTelaahTeknis::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'FisikFungsi' => $data['HasilTeknis'][0],
                'KeselamatanListrik' => $data['HasilTeknis'][1],
                'Kinerja' => $data['HasilTeknis'][2],
                'Catatan' => $data['Catatan'],
                'idUser' => auth()->user()->id
            ]
        );
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getTeganganUtama',
            'getPmeriksaanFisikFungsi',
            'getPengukuranListrik',
            'getPengujianPatientMonitor',
            'getTelaahTeknis'
        ])->find($id);
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
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D29', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G29', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D32', $data->getTeganganUtama->Tegangan_NPE);
        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter1[1]);
        $sheet->setCellValue('E39', $data->getPmeriksaanFisikFungsi->Parameter2[1]);
        $sheet->setCellValue('E40', $data->getPmeriksaanFisikFungsi->Parameter3[1]);
        $sheet->setCellValue('E41', $data->getPmeriksaanFisikFungsi->Parameter4[1]);
        $sheet->setCellValue('E42', $data->getPmeriksaanFisikFungsi->Parameter5[1]);
        $sheet->setCellValue('E43', $data->getPmeriksaanFisikFungsi->Parameter6[1]);
        // PENGUKURAN KESELAMATAN LISTRIK
        // dd($data->getPengukuranListrik);
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C46';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E46';
        } else {
            $tipe = 'G46';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C47';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E47';
        } else {
            $kelas = 'G47';
        }
        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E50', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E51', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E52', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E53', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E54', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E55', $data->getPengukuranListrik->Parameter6);

        // PENGUJIAN KINERJA HEARTRATE
        $heartrate = $data->getPengujianPatientMonitor->where('TipePengujian', 'HEARTRATE');
        $rowheartrate = 61;
        foreach ($heartrate as $key => $a) {
            $sheet->setCellValue('C' . $rowheartrate, $a->TitikUkur);
            $sheet->setCellValue('D' . $rowheartrate, $a->Pengulangan1);
            $sheet->setCellValue('E' . $rowheartrate, $a->Pengulangan2);
            $sheet->setCellValue('F' . $rowheartrate, $a->Pengulangan3);
            $rowheartrate++;
        }
        // PENGUJIAN KINERJA RESPIRASI
        $respirasi = $data->getPengujianPatientMonitor->where('TipePengujian', 'RESPIRASI');
        $rowrespirasi = 69;
        foreach ($respirasi as $key => $b) {
            $sheet->setCellValue('C' . $rowrespirasi, $b->TitikUkur);
            $sheet->setCellValue('D' . $rowrespirasi, $b->Pengulangan1);
            $sheet->setCellValue('E' . $rowrespirasi, $b->Pengulangan2);
            $sheet->setCellValue('F' . $rowrespirasi, $b->Pengulangan3);
            $rowrespirasi++;
        }
        // PENGUJIAN KINERJA SATURASI
        $saturasi = $data->getPengujianPatientMonitor->where('TipePengujian', 'SATURASI');
        $rowsaturasi = 76;
        foreach ($saturasi as $key => $c) {
            $sheet->setCellValue('C' . $rowsaturasi, $c->TitikUkur);
            $sheet->setCellValue('D' . $rowsaturasi, $c->Pengulangan1);
            $sheet->setCellValue('E' . $rowsaturasi, $c->Pengulangan2);
            $sheet->setCellValue('F' . $rowsaturasi, $c->Pengulangan3);
            $rowsaturasi++;
        }
        // PENGUJIAN KINERJA TEKANAN DARAH
        $tekanandarah = $data->getPengujianPatientMonitor->where('TipePengujian', 'TEKANANDARAH');
        $rowtekanandarah = 83;
        foreach ($tekanandarah as $key => $d) {
            $sheet->setCellValue('D' . $rowtekanandarah, $d->TipeTitikUkur);
            $sheet->setCellValue('E' . $rowtekanandarah, $d->TitikUkur);
            $sheet->setCellValue('F' . $rowtekanandarah, $d->Pengulangan1);
            $sheet->setCellValue('G' . $rowtekanandarah, $d->Pengulangan2);
            $sheet->setCellValue('H' . $rowtekanandarah, $d->Pengulangan3);
            $rowtekanandarah++;
        }
        // TELAAH TEKNIS

        $sheet->setCellValue('C97', $data->getTelaahTeknis->FisikFungsi);
        $sheet->setCellValue('C98', $data->getTelaahTeknis->KeselamatanListrik);
        $sheet->setCellValue('C99', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C100:E100');
        $sheet->setCellValue('C100', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C100')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->nama_pemilik . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

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
