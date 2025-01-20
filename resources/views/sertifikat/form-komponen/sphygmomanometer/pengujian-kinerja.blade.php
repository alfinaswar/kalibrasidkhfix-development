{{-- UJI KEBOCORAN --}}
<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">UJI KEBOCORAN</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="30%" style="vertical-align: middle; text-align: center;">Penunjukan Alat (mmHg)</th>
                <th width="40%" style="vertical-align: middle; text-align: center;">Penunjukan Standar (mmHg)</th>
                <th width="30%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold;">250</td>
                <td><input type="text" class="form-control ujikebocoran" name="penunjukan_standar"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getSpyghmomanometerPengujian[0]->Penunjukan_standart ?? '' }}"></td>
                <td style="text-align: center; font-weight: bold;">&lt; 15 mmHg / Menit</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- UJI LAJU BUANG CEPAT --}}
<div class="row">
    <center>
        <span class="text-primary fw-bold text-uppercase">UJI LAJU BUANG CEPAT</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat (mmHg)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Tekanan Akhir (mmHg)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Waktu Terukur (Detik)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold;">260</td>
                <td><input type="text" class="form-control" name="tekananAkhir" value="15" readonly></td>
                <td><input type="text" class="form-control waktuinput" name="waktuTerukur" placeholder="Hasil"
                        value="{{ $sertifikat->getSpyghmomanometerPengujian[1]->WaktuTerukur ?? '' }}"></td>
                <td style="text-align: center; font-weight: bold;">&lt;= 10 Detik</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- AKURASI TEKANAN --}}
<div class="row">
    <center>
        <span class="text-primary fw-bold text-uppercase">AKURASI TEKANAN</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat
                    (mmHg)</th>
                <th colspan="6" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standar
                    (mmHg)</th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Penyimpangan yang
                    diijinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
            </tr>
        </thead>
        <tbody>
            @php
                $penunjukan = $sertifikat->getSpyghmomanometerakurasi->Penunjukan ?? [
                    '0',
                    '50',
                    '100',
                    '150',
                    '200',
                    '250',
                ];
                $standartNaik1 = $sertifikat->getSpyghmomanometerakurasi->StandartNaik1 ?? ['', '', '', '', '', ''];
                $standartTurun1 = $sertifikat->getSpyghmomanometerakurasi->StandartTurun1 ?? ['', '', '', '', '', ''];
                $standartNaik2 = $sertifikat->getSpyghmomanometerakurasi->StandartNaik2 ?? ['', '', '', '', '', ''];
                $standartTurun2 = $sertifikat->getSpyghmomanometerakurasi->StandartTurun2 ?? ['', '', '', '', '', ''];
                $standartNaik3 = $sertifikat->getSpyghmomanometerakurasi->StandartNaik3 ?? ['', '', '', '', '', ''];
                $standartTurun3 = $sertifikat->getSpyghmomanometerakurasi->StandartTurun3 ?? ['', '', '', '', '', ''];
            @endphp

            @foreach ($penunjukan as $i => $value)
                <tr>
                    <td style="text-align: center; font-weight: bold;">
                        <input type="text" class="form-control" name="penunjukan[]" value="{{ $value }}"
                            readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartNaik1[]"
                            value="{{ $standartNaik1[$i] }}" placeholder="Hasil">
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartTurun1[]"
                            value="{{ $standartTurun1[$i] }}" placeholder="Hasil">
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartNaik2[]"
                            value="{{ $standartNaik2[$i] }}" placeholder="Hasil">
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartTurun2[]"
                            value="{{ $standartTurun2[$i] }}" placeholder="Hasil">
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartNaik3[]"
                            value="{{ $standartNaik3[$i] }}" placeholder="Hasil">
                    </td>
                    <td>
                        <input type="text" class="form-control akurasitekanan" name="standartTurun3[]"
                            value="{{ $standartTurun3[$i] }}" placeholder="Hasil">
                    </td>
                    @if ($i == 0)
                        <td rowspan="6" style="text-align: center; font-weight: bold;">± 3 mmHg</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $('.akurasitekanan').on('input', function() {
        this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
        var pengulanganNaik = [];
        var pengulanganTurun = [];
        pengulanganNaik = Array.from({
            length: 3
        }, (_, i) => parseFloat($(this).closest('tr').find(
            `input[name="standartNaik${i+1}[]"]`).val()));
        pengulanganTurun = Array.from({
            length: 3
        }, (_, i) => parseFloat($(this).closest('tr').find(
            `input[name="standartTurun${i+1}[]"]`).val()));
        var titikUkur = parseFloat($(this).closest('tr').find('input[name="penunjukan[]"]')
            .val());

        var batasBawah = titikUkur - 3;
        var batasAtas = titikUkur + 3;

        pengulanganNaik.forEach((value, index) => {
            if (value < batasBawah || value > batasAtas) {
                $(this).closest('tr').find(
                    'input[name="standartNaik' + (index + 1) + '[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find(
                    'input[name="standartNaik' + (index + 1) + '[]"]').removeClass(
                    'is-invalid');
            }
        });

        pengulanganTurun.forEach((value, index) => {
            if (value < batasBawah || value > batasAtas) {
                $(this).closest('tr').find(
                    'input[name="standartTurun' + (index + 1) + '[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find(
                    'input[name="standartTurun' + (index + 1) + '[]"]').removeClass(
                    'is-invalid');
            }
        });
        console.log(pengulanganTurun);

    });
</script>
