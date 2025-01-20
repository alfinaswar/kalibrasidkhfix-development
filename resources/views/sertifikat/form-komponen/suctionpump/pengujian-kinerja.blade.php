<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">Akurasi Tekanann Hisap</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat
                    <span style="text-transform: none">(mmHg)</span>
                </th>
                <th colspan="6" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standar
                    <span style="text-transform: none">(mmHg)</span>
                </th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Toleransi</th>
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
                $penunjukan = $sertifikat->getSuctionpumpPengujian->Penunjukan ?? ['200', '400', '600'];
                $standartNaik1 = $sertifikat->getSuctionpumpPengujian->StandartNaik1 ?? ['', '', ''];
                $standartTurun1 = $sertifikat->getSuctionpumpPengujian->StandartTurun1 ?? ['', '', ''];
                $standartNaik2 = $sertifikat->getSuctionpumpPengujian->StandartNaik2 ?? ['', '', ''];
                $standartTurun2 = $sertifikat->getSuctionpumpPengujian->StandartTurun2 ?? ['', '', ''];
                $standartNaik3 = $sertifikat->getSuctionpumpPengujian->StandartNaik3 ?? ['', '', ''];
                $standartTurun3 = $sertifikat->getSuctionpumpPengujian->StandartTurun3 ?? ['', '', ''];
            @endphp

            @foreach ($penunjukan as $index => $value)
                <tr>
                    <td><input type="text" class="form-control kinerja" name="Penunjukan[]"
                            value="{{ $value }}" readonly></td>
                    <td><input type="text" class="form-control kinerja" name="StandartNaik1[]" placeholder="Hasil"
                            value="{{ $standartNaik1[$index] }}"></td>
                    <td><input type="text" class="form-control kinerja" name="StandartTurun1[]" placeholder="Hasil"
                            value="{{ $standartTurun1[$index] }}"></td>
                    <td><input type="text" class="form-control kinerja" name="StandartNaik2[]" placeholder="Hasil"
                            value="{{ $standartNaik2[$index] }}"></td>
                    <td><input type="text" class="form-control kinerja" name="StandartTurun2[]" placeholder="Hasil"
                            value="{{ $standartTurun2[$index] }}"></td>
                    <td><input type="text" class="form-control kinerja" name="StandartNaik3[]" placeholder="Hasil"
                            value="{{ $standartNaik3[$index] }}"></td>
                    <td><input type="text" class="form-control kinerja" name="StandartTurun3[]" placeholder="Hasil"
                            value="{{ $standartTurun3[$index] }}"></td>
                    @if ($index == 0)
                        <td rowspan="3" style="text-align: center; font-weight: bold;">± 3 mmHg</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class="row mt-3">
    <center>
        <span class="text-primary fw-bold text-uppercase">Tekanan Hisap Maksimum</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat <span
                        style="text-transform: none">(mmHg)</span>
                </th>
                <th width="60%" style="vertical-align: middle; text-align: center;">Titik Ukur</span></th>
                <th width="15%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control kinerja" name="PenunjukanAlat" value="Maksimum" readonly>
                </td>
                <td><input type="text" class="form-control kinerja" name="TitikUkur" placeholder="Hasil"
                        value="{{ $sertifikat->getSuctionpumpTekanan->TitikUkur ?? null }}"></td>
                <td style="text-align: center; font-weight: bold;">Surgical, Tracheal, Uterine ≥ 300</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $('.kinerja').on('input', function() {
        this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
        var pengulanganNaik = [];
        var pengulanganTurun = [];
        pengulanganNaik = Array.from({
            length: 3
        }, (_, i) => parseFloat($(this).closest('tr').find(
            `input[name="StandartNaik${i+1}[]"]`).val()));
        pengulanganTurun = Array.from({
            length: 3
        }, (_, i) => parseFloat($(this).closest('tr').find(
            `input[name="StandartTurun${i+1}[]"]`).val()));
        var titikUkur = parseFloat($(this).closest('tr').find('input[name="Penunjukan[]"]')
            .val());

        var batasBawah = titikUkur - 3;
        var batasAtas = titikUkur + 3;

        pengulanganNaik.forEach((value, index) => {
            if (value < batasBawah || value > batasAtas) {
                $(this).closest('tr').find(
                    'input[name="StandartNaik' + (index + 1) + '[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find(
                    'input[name="StandartNaik' + (index + 1) + '[]"]').removeClass(
                    'is-invalid');
            }
        });

        pengulanganTurun.forEach((value, index) => {
            if (value < batasBawah || value > batasAtas) {
                $(this).closest('tr').find(
                    'input[name="StandartTurun' + (index + 1) + '[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find(
                    'input[name="StandartTurun' + (index + 1) + '[]"]').removeClass(
                    'is-invalid');
            }
        });
    });
</script>
