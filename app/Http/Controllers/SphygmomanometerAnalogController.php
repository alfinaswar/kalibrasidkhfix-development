<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\MasterMetode;
use App\Models\MasterSatuan;
use App\Models\Sertifikat;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatSpyghmomanometerakurasi;
use App\Models\SertifikatSpyghmomanometerPengujian;
use App\Models\SertifikatTelaahTeknis;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SphygmomanometerAnalogController extends Controller
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
            'getSpyghmomanometerPengujian',
            'getSpyghmomanometerakurasi',
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
            ['SertifikatId' => $data['sertifikatid'], 'InstrumenId' => $data['idinstrumen']],  // Conditions to check for existing record
            [
                'TempraturAwal' => $data['KondisiAwal'][0],
                'TempraturAkhir' => $data['KondisiAkhir'][0],
                'KelembapanAwal' => $data['KondisiAwal'][1],
                'KelembapanAkhir' => $data['KondisiAkhir'][1],
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

        // Kebocoran
        $kebocoran = SertifikatSpyghmomanometerPengujian::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'InstrumenId' => $data['idinstrumen'], 'TypePengujian' => 'KEBOCORAN'],
            [
                'Penunjukan_standart' => $data['penunjukan_standar'],
                'idUser' => auth()->user()->id,
            ]
        );

        // Lajubuang
        $lajubuang = SertifikatSpyghmomanometerPengujian::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'InstrumenId' => $data['idinstrumen'], 'TypePengujian' => 'LAJUBUANG'],
            [
                'TekananAkhir' => $data['tekananAkhir'],
                'WaktuTerukur' => $data['waktuTerukur'],
                'idUser' => auth()->user()->id,
            ]
        );

        // Akurasi
        $akurasi = SertifikatSpyghmomanometerakurasi::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'InstrumenId' => $data['idinstrumen']],
            [
                'InstrumenId' => $data['idinstrumen'] ?? null,
                'Penunjukan' => $data['penunjukan'],
                'StandartNaik1' => $data['standartNaik1'],
                'StandartTurun1' => $data['standartTurun1'],
                'StandartNaik2' => $data['standartNaik2'],
                'StandartTurun2' => $data['standartTurun2'],
                'StandartNaik3' => $data['standartNaik3'],
                'StandartTurun3' => $data['standartTurun3'],
                'idUser' => auth()->user()->id,
            ]
        );

        // Telaah Teknis
        $telaahteknis = SertifikatTelaahTeknis::updateOrCreate(
            ['SertifikatId' => $data['sertifikatid'], 'InstrumenId' => $data['idinstrumen']],
            [
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
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getSpyghmomanometerakurasi',
            'getSpyghmomanometerPengujian',
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

        $sheet->setCellValue('D27', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G27', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        // // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $colum = 34;
        for ($i = 1; $i <= 12; $i++) {
            $par = 'Parameter' . $i;
            $sheet->setCellValue('E' . $colum, $data->getPmeriksaanFisikFungsi->$par[1]);
            $colum += 1;
        }
        $sheet->setCellValue('C50', $data->getSpyghmomanometerPengujian[0]->Penunjukan_standart);
        $sheet->setCellValue('D55', $data->getSpyghmomanometerPengujian[1]->WaktuTerukur);

        $sheet->setCellValue('D55', $data->getSpyghmomanometerPengujian[1]->WaktuTerukur);

        $baris = 60;
        for ($i = 0; $i < count($data->getSpyghmomanometerakurasi->Penunjukan); $i++) {
            $sheet->setCellValue('C' . $baris, $data->getSpyghmomanometerakurasi->StandartNaik1[$i]);
            $sheet->setCellValue('D' . $baris, $data->getSpyghmomanometerakurasi->StandartTurun1[$i]);
            $sheet->setCellValue('E' . $baris, $data->getSpyghmomanometerakurasi->StandartNaik2[$i]);
            $sheet->setCellValue('F' . $baris, $data->getSpyghmomanometerakurasi->StandartTurun2[$i]);
            $sheet->setCellValue('G' . $baris, $data->getSpyghmomanometerakurasi->StandartNaik3[$i]);
            $sheet->setCellValue('H' . $baris, $data->getSpyghmomanometerakurasi->StandartTurun3[$i]);
            $baris++;
        }

        // TELAAH TEKNIS
        // $sheet->setCellValue('C68', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C69', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C70:E70');
        $sheet->setCellValue('C70', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C70')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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
