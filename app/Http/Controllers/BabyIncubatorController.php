<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\KondisiKebisingan;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\PengukuranListrik;
use App\Models\Sertifikat;
use App\Models\SertifikatBabyIncubatorPengujian;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatTelaahTeknis;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BabyIncubatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($id)
    {
        $sertifikat = Sertifikat::with(
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getTeganganUtama',
            'getPengukuranListrik',
            'getBabyIncubatorPengujian',
            'getKebisingan',
            'getTelaahTeknis'
        )->where('id', $id)->first();

        $DataA = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'A';
        });
        $DataB = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'B';
        });
        $DataC = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'C';
        });
        $DataD = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'D';
        });
        $DataE = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'E';
        });
        $DataF = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'F';
        });
        $DataG = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'G';
        });
        $DataH = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'H';
        });
        // dd($DataH);
        $DataI = $sertifikat->getBabyIncubatorPengujian->filter(function ($item) {
            return $item->TipePengujian == 'I';
        });

        $InstrumenId = $sertifikat->InstrumenId;
        $cek = Instrumen::where('id', $InstrumenId)->first()->NamaFile;
        $FormLK = 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $cek;

        $metode = MasterMetode::get();
        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();
        $satuan = MasterSatuan::get();
        return view($FormLK, compact(
            'sertifikat',
            'metode',
            'getAlatUkur',
            'satuan',
            'DataA',
            'DataB',
            'DataC',
            'DataD',
            'DataE',
            'DataF',
            'DataG',
            'DataH',
            'DataI'
        ));
    }

    public function store($data)
    {
        $KondisiLingkungan = SertifikatKondisiLingkungan::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'TempraturAwal' => $data['KondisiAwal'][0],
                'TempraturAkhir' => $data['KondisiAkhir'][0],
                'KelembapanAwal' => $data['KondisiAwal'][1],
                'KelembapanAkhir' => $data['KondisiAkhir'][1],
                'idUser' => auth()->user()->id,
            ]
        );
        $kondisiListrik = SertifikatKondisiKelistrikan::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Tegangan_LN' => $data['val'][0],
                'Tegangan_LPE' => $data['val'][1],
                'Tegangan_NPE' => $data['val'][2],
                'idUser' => auth()->user()->id,
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
                'idUser' => auth()->user()->id,
            ]
        );

        $kebisingan = KondisiKebisingan::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Penunjukan' => $data['Kebisingan'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiA = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'A'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlat'],
                'Sensor' => $data['SensorA'],
                'Pengulangan1' => $data['Pengulangan1A'],
                'Pengulangan2' => $data['Pengulangan2A'],
                'Pengulangan3' => $data['Pengulangan3A'],
                'Pengulangan4' => $data['Pengulangan4A'],
                'Pengulangan5' => $data['Pengulangan5A'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiB = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'B'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatB'],
                'Sensor' => $data['SensorB'],
                'Pengulangan1' => $data['Pengulangan1B'],
                'Pengulangan2' => $data['Pengulangan2B'],
                'Pengulangan3' => $data['Pengulangan3B'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiC = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'C'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatC'],
                'Sensor' => $data['SensorC'],
                'Pengulangan1' => $data['Pengulangan1C'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiD = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'D'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatD'],
                'Sensor' => $data['SensorD'],
                'Pengulangan1' => $data['Pengulangan1D'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiE = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'E'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatE'],
                'Sensor' => $data['SensorE'],
                'Pengulangan1' => $data['Pengulangan1E'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiF = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'F'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatF'],
                'Sensor' => $data['SensorF'],
                'Pengulangan1' => $data['Pengulangan1F'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiG = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'G'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatG'],
                'Sensor' => $data['SensorG'],
                'Pengulangan1' => $data['Pengulangan1G'],
                'Pengulangan2' => $data['Pengulangan2G'],
                'Pengulangan3' => $data['Pengulangan3G'],
                'Pengulangan4' => $data['Pengulangan4G'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiH = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'H'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatH'],
                'Pengulangan1' => $data['Pengulangan1H'],
                'Pengulangan2' => $data['Pengulangan2H'],
                'Pengulangan3' => $data['Pengulangan3H'],
                'idUser' => auth()->user()->id,
            ]
        );

        $ujiI = SertifikatBabyIncubatorPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'I'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'SettingAlat' => $data['SettingAlatI'],
                'Sensor' => $data['SensorI'],
                'Pengulangan1' => $data['Pengulangan1I'],
                'Pengulangan2' => $data['Pengulangan2I'],
                'Pengulangan3' => $data['Pengulangan3I'],
                'idUser' => auth()->user()->id,
            ]
        );

        $telaahteknis = SertifikatTelaahTeknis::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid']],
            [
                'InstrumenId' => $data['idinstrumen'],
                'FisikFungsi' => $data['HasilTeknis'][0],
                'KeselamatanListrik' => $data['HasilTeknis'][1],
                'Kinerja' => $data['HasilTeknis'][2],
                'Catatan' => $data['Catatan'],
                'idUser' => auth()->user()->id,
            ]
        );

        return redirect()->route('job.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with(['getCustomer', 'getNamaAlat', 'getPengukuranKondisiLingkungan', 'getTeganganUtama', 'getPmeriksaanFisikFungsi', 'getPengukuranListrik', 'getBabyIncubatorPengujian', 'getKebisingan', 'getTelaahTeknis'])->find($id);
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

        // pengukuran kondisi
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D29', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G29', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);
        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D32', $data->getTeganganUtama->Tegangan_NPE);
        $sheet->mergeCells('C33:D33');
        $sheet->setCellValue('C33', $data->getKebisingan->Penunjukan);
        $sheet
            ->getStyle('C33')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // pemeriksaan fisik dan fungsi alat
        $colum = 39;
        for ($i = 1; $i <= 10; $i++) {
            $par = 'Parameter' . $i;
            $sheet->setCellValue('E' . $colum, $data->getPmeriksaanFisikFungsi->$par[1]);
            $colum += 1;
        }

        // pengukuran keselamatan listrik
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C51';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E51';
        } else {
            $tipe = 'G51';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C52';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E52';
        } else {
            $kelas = 'G52';
        }

        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E55', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E56', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E57', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E58', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E59', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E60', $data->getPengukuranListrik->Parameter6);

        // pengujian
        // uji A
        $colum = 67;
        for ($i = 0; $i < count($data->getBabyIncubatorPengujian[0]->Pengulangan1); $i++) {
            $sheet->setCellValue('D' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan1[$i]);
            $sheet->setCellValue('E' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan2[$i]);
            $sheet->setCellValue('F' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan3[$i]);
            $sheet->setCellValue('G' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan4[$i]);
            $sheet->setCellValue('H' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan5[$i]);
            $colum++;
        }

        // Uji B
        $colum2 = 81;
        for ($i = 0; $i < count($data->getBabyIncubatorPengujian[1]->Pengulangan1); $i++) {
            $sheet->setCellValue('D' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan1[$i]);
            $sheet->setCellValue('E' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan2[$i]);
            $sheet->setCellValue('F' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan3[$i]);
            $colum2++;
        }

        // Uji C
        $sheet->setCellValue('D86', $data->getBabyIncubatorPengujian[2]->Pengulangan1[0]);

        // Uji D
        $sheet->setCellValue('D90', $data->getBabyIncubatorPengujian[3]->Pengulangan1[0]);

        // Uji E
        $sheet->setCellValue('D94', $data->getBabyIncubatorPengujian[4]->Pengulangan1[0]);

        // Uji F
        $sheet->setCellValue('D98', $data->getBabyIncubatorPengujian[5]->Pengulangan1[0]);

        // Uji G
        $sheet->setCellValue('D103', $data->getBabyIncubatorPengujian[6]->Pengulangan1[0]);
        $sheet->setCellValue('E103', $data->getBabyIncubatorPengujian[6]->Pengulangan2[0]);
        $sheet->setCellValue('F103', $data->getBabyIncubatorPengujian[6]->Pengulangan3[0]);
        $sheet->setCellValue('G103', $data->getBabyIncubatorPengujian[6]->Pengulangan4[0]);

        // Uji H
        $sheet->setCellValue('C109', $data->getBabyIncubatorPengujian[7]->Pengulangan1[0]);
        $sheet->setCellValue('D109', $data->getBabyIncubatorPengujian[7]->Pengulangan2[0]);
        $sheet->setCellValue('E109', $data->getBabyIncubatorPengujian[7]->Pengulangan3[0]);

        // Uji I
        $sheet->setCellValue('D114', $data->getBabyIncubatorPengujian[8]->Pengulangan1[0]);
        $sheet->setCellValue('E114', $data->getBabyIncubatorPengujian[8]->Pengulangan2[0]);
        $sheet->setCellValue('F114', $data->getBabyIncubatorPengujian[8]->Pengulangan3[0]);

        // $sheet->setCellValue('C117', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C118', $data->getTelaahTeknis->KeselamatanListrik);
        // $sheet->setCellValue('C119', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C120:E120');
        $sheet->setCellValue('C120', $data->getTelaahTeknis->Catatan);
        $sheet
            ->getStyle('C120')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
