<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Models\PengukuranListrik;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatSyringepumpPengujian;

class SyringePumpController extends Controller
{
    public function create($id)
    {
        $sertifikat = Sertifikat::with(
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getTeganganUtama',
            'getPengukuranListrik',
            'getSyringepumpPengujian',
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
                'idUser' => auth()->user()->id,
            ]
        );

        // Kondisi Kelistrikan
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

        // Pengukuran Listrik
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

        // Flow Rate Testing
        $flow = SertifikatSyringepumpPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'FLOWRATE'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Penunjukan' => $data['SettingAlat'],
                'Pengulangan1' => $data['Pengulangan1'],
                'Pengulangan2' => $data['Pengulangan2'],
                'Pengulangan3' => $data['Pengulangan3'],
                'Pengulangan4' => $data['Pengulangan4'],
                'Pengulangan5' => $data['Pengulangan5'],
                'Pengulangan6' => $data['Pengulangan6'],
            ]
        );

        // Occlusion Testing
        $occ = SertifikatSyringepumpPengujian::updateOrCreate(
            [
                'SertifikatId' => $data['sertifikatid'],
                'TipePengujian' => 'HISAPMAKSIMUM'
            ],
            [
                'InstrumenId' => $data['idinstrumen'],
                'Penunjukan' => $data['SettingAlatOcc'],
                'Pengulangan1' => $data['PengulanganOcc1'],
                'Pengulangan2' => $data['PengulanganOcc2'],
                'Pengulangan3' => $data['PengulanganOcc3'],
                'Pengulangan4' => $data['PengulanganOcc4'],
                'Pengulangan5' => $data['PengulanganOcc5'],
                'Pengulangan6' => $data['PengulanganOcc6'],
            ]
        );

        // Telaah Teknis
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
        $data = Sertifikat::with(['getCustomer', 'getNamaAlat', 'getPengukuranKondisiLingkungan', 'getTeganganUtama', 'getPmeriksaanFisikFungsi', 'getPengukuranListrik', 'getSyringepumpPengujian', 'getTelaahTeknis'])->find($id);
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

        // pengukuran kondisi
        $sheet->setCellValue('D27', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G27', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);
        $sheet->setCellValue('D29', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_NPE);

        // pemeriksaan fisik dan fungsi alat
        $colum = 37;
        for ($i = 1; $i <= 6; $i++) {
            $par = 'Parameter' . $i;
            $sheet->setCellValue('E' . $colum, $data->getPmeriksaanFisikFungsi->$par[1]);
            $colum += 1;
        }

        // pengukuran keselamatan listrik
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C45';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E45';
        } else {
            $tipe = 'G45';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C46';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E46';
        } else {
            $kelas = 'G46';
        }

        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E49', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E50', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E51', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E52', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E53', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E54', $data->getPengukuranListrik->Parameter6);

        // pengujian
        $pengulangan1 = $data->getSyringepumpPengujian[0]->Pengulangan1;
        $pengulangan2 = $data->getSyringepumpPengujian[0]->Pengulangan2;
        $pengulangan3 = $data->getSyringepumpPengujian[0]->Pengulangan3;
        $pengulangan4 = $data->getSyringepumpPengujian[0]->Pengulangan4;
        $pengulangan5 = $data->getSyringepumpPengujian[0]->Pengulangan5;
        $pengulangan6 = $data->getSyringepumpPengujian[0]->Pengulangan6;
        // dd($test[0]);
        $colum = 60;
        for ($i = 0; $i < count($data->getSyringepumpPengujian[0]->Penunjukan); $i++) {
            $sheet->setCellValue('C' . $colum, $pengulangan1[$i]);
            $sheet->setCellValue('D' . $colum, $pengulangan2[$i]);
            $sheet->setCellValue('E' . $colum, $pengulangan3[$i]);
            $sheet->setCellValue('F' . $colum, $pengulangan4[$i]);
            $sheet->setCellValue('G' . $colum, $pengulangan5[$i]);
            $sheet->setCellValue('H' . $colum, $pengulangan6[$i]);
            $colum++;
        }

        $occ1 = $data->getSyringepumpPengujian[1]->Pengulangan1;
        $occ2 = $data->getSyringepumpPengujian[1]->Pengulangan2;
        $occ3 = $data->getSyringepumpPengujian[1]->Pengulangan3;
        $occ4 = $data->getSyringepumpPengujian[1]->Pengulangan4;
        $occ5 = $data->getSyringepumpPengujian[1]->Pengulangan5;
        $occ6 = $data->getSyringepumpPengujian[1]->Pengulangan6;
        $sheet->setCellValue('C67', $occ1[0]);
        $sheet->setCellValue('D67', $occ2[0]);
        $sheet->setCellValue('E67', $occ3[0]);
        $sheet->setCellValue('F67', $occ4[0]);
        $sheet->setCellValue('G67', $occ5[0]);
        $sheet->setCellValue('H67', $occ6[0]);

        // $sheet->setCellValue('C71', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C72', $data->getTelaahTeknis->KeselamatanListrik);
        // $sheet->setCellValue('C73', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C74:E74');
        $sheet->setCellValue('C74', $data->getTelaahTeknis->Catatan);
        $sheet
            ->getStyle('C74')
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
