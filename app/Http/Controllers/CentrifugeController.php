<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\PengukuranListrik;
use App\Models\Sertifikat;
use App\Models\SertifikatCentrifugePengujian;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatTelaahTeknis;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CentrifugeController extends Controller
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
            'getPengujianKinerjaCentrifuge',
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
    public function store($data)
    {

        // dd(count($data['TestingStandart']));
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

        // pengukuran kinerja
        for ($i = 0; $i < count($data['TestingStandart']); $i++) {
            $pengukurankinerja = SertifikatCentrifugePengujian::updateOrCreate(
                [
                    'SertifikatId' => $data['sertifikatid'],
                    'InstrumenId' => $data['idinstrumen'],
                    'TitikUkur' => $data['TestingStandart'][$i],
                ],
                [
                    // 'InstrumenId' => $data['idinstrumen'],
                    // 'TitikUkur' => $data['TestingStandart'][$i],
                    'TipePenujian' => NULL,
                    'Pengulangan1' => $data['PembacaanAlat1'][$i],
                    'Pengulangan2' => $data['PembacaanAlat2'][$i],
                    'Pengulangan3' => $data['PembacaanAlat3'][$i],
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
        return redirect()->route('job.index')->with('success', 'Data Berhasil Disimpan');
    }
    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        // dd($id);
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getTeganganUtama',
            'getPmeriksaanFisikFungsi',
            'getPengukuranListrik',
            'getPengujianKinerjaCentrifuge',
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
        // PENGUJIAN KINERJA
        $row = 61;
        $pengujianKinerjaCentrifuge = $data->getPengujianKinerjaCentrifuge;
        $maxRow = count($pengujianKinerjaCentrifuge) - 1;
        for ($i = 0; $i < $maxRow; $i++) {
            $value = $pengujianKinerjaCentrifuge[$i];
            $sheet->setCellValue('C' . $row, $value->TitikUkur);
            $sheet->setCellValue('D' . $row, $value->Pengulangan1);
            $sheet->setCellValue('E' . $row, $value->Pengulangan2);
            $sheet->setCellValue('F' . $row, $value->Pengulangan3);
            $row++;
        }
        // dd($data->getPengujianKinerjaCentrifuge->last()->TipePenujian);
        // PENGUJIAN KINERJA WAKTU
        $sheet->setCellValue('C68', $data->getPengujianKinerjaCentrifuge->last()->TitikUkur);
        $sheet->setCellValue('D68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan1);
        $sheet->setCellValue('E68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan2);
        $sheet->setCellValue('F68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan3);
        // TELAAH TEKNIS

        $sheet->setCellValue('C71', $data->getTelaahTeknis->FisikFungsi);
        $sheet->setCellValue('C72', $data->getTelaahTeknis->KeselamatanListrik);
        $sheet->setCellValue('C73', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C71:E71');
        $sheet->setCellValue('C71', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C71')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
