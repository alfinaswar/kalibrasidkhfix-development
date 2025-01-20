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

class TimbanganBayiDigitalController extends Controller
{
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

        // pengukuran kinerja
        $pengukurankinerjaKinerja = SertifikatTimbanganPengujian::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'TipePengujian' => 'KINERJA'],
            [
                'InstrumenId' => $data['idinstrumen'],
                'MassaHalf' => array_slice($data['MassaHalf'], 0, 9) ?? null,
                'PengujianZ' => array_slice($data['PengujianZ'], 0, 9) ?? null,
                'PengujianM' => array_slice($data['PengujianM'], 0, 9) ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        $pengukurankinerjaSkala = SertifikatTimbanganPengujian::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'TipePengujian' => 'SKALA'],
            [
                'InstrumenId' => $data['idinstrumen'],
                'MassaHalf' => array_slice($data['MassaHalf'], 10, 20) ?? null,
                'PengujianZ' => array_slice($data['PengujianZ'], 10, 20) ?? null,
                'PengujianM' => array_slice($data['PengujianM'], 10, 20) ?? null,
                'idUser' => auth()->user()->id
            ]
        );

        // telaah teknis
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
        $sheet->setCellValue('D31', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G31', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D32', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G32', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter1[1]);
        $sheet->setCellValue('E39', $data->getPmeriksaanFisikFungsi->Parameter2[1]);
        $sheet->setCellValue('E40', $data->getPmeriksaanFisikFungsi->Parameter3[1]);
        // PENGUJIAN KINERJA TEKANAN DARAH

        $kinerja = $data->getPengujianTimbangan->where('TipePengujian', 'KINERJA')->first();
        $rowSkala = 44;
        $pengujianMCount = count($kinerja->PengujianM);
        for ($key = 0; $key < $pengujianMCount; $key++) {
            // $d = $kinerja->PengujianM[$key];
            $sheet->setCellValue('D' . $rowSkala, $kinerja->PengujianZ[$key]);
            $sheet->setCellValue('E' . $rowSkala, $kinerja->PengujianM[$key]);
            $rowSkala++;
        }
        // PENGUJIAN KINERJA TEKANAN DARAH

        $kinerja = $data->getPengujianTimbangan->where('TipePengujian', 'SKALA')->first();
        $rowSkala = 57;
        $pengujianMCount = count($kinerja->PengujianM);
        for ($key = 0; $key < $pengujianMCount; $key++) {
            // $d = $kinerja->PengujianM[$key];
            $sheet->setCellValue('B' . $rowSkala, $kinerja->PengujianZ[$key]);
            $sheet->setCellValue('C' . $rowSkala, $kinerja->PengujianM[$key]);
            $rowSkala++;
        }
        // TELAAH TEKNIS
        $sheet->setCellValue('C71', $data->getTelaahTeknis->FisikFungsi) ?? 0;
        $sheet->setCellValue('C72', $data->getTelaahTeknis->Kinerja) ?? 0;
        $sheet->mergeCells('C73:E73');
        $sheet->setCellValue('C73', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C73')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
