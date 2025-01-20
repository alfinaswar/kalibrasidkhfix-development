<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">Laju Aliran / Flow Rate</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat
                    <span style="text-transform: none">(ml/h)</span>
                </th>
                <th colspan="6" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standar
                    <span style="text-transform: none">(ml/h)</span>
                </th>
            </tr>
            <tr>

                @for ($i = 1; $i <= 6; $i++)
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                @endfor
            </tr>
        </thead>
        <tbody>
            @for ($j = 0; $j < 4; $j++)
                <tr>
                    @for ($i = 0; $i <= 6; $i++)
                        <td>
                            @if ($i == 0)
                                <input type="number" class="form-control" name="SettingAlat[]"
                                    value="{{ [10, 50, 100, 300][$j] }}" readonly>
                            @else
                                <input type="text" class="form-control flowinput"
                                    name="Pengulangan{{ $i }}[]" placeholder="Hasil"
                                    value="{{ $sertifikat->getInfusePumpPengujian[0]->{'Pengulangan' . $i}[$j] ?? null }}">
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary fw-bold text-uppercase">Uji Kemampatan / Occlusion</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat
                    <span style="text-transform: none">(ml/h)</span>
                </th>
                <th colspan="6" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan
                    Standar
                    <span style="text-transform: none">(psi)</span>
                </th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">4</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">5</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">6</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control Occlusioninput" name="SettingAlatOcc[]" value="100"
                        readonly></td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc1[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan1[0] ?? null }}">
                </td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc2[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan2[0] ?? null }}">
                </td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc3[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan3[0] ?? null }}">
                </td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc4[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan4[0] ?? null }}">
                </td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc5[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan5[0] ?? null }}">
                </td>
                <td><input type="text" class="form-control Occlusioninput" name="PengulanganOcc6[]"
                        placeholder="Hasil"
                        value="{{ $sertifikat->getInfusePumpPengujian[1]->Pengulangan6[0] ?? null }}">
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.flowinput').on('input', function() {
            this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
            var pengulangan = [];
            pengulangan = Array.from({
                length: 6
            }, (_, i) => parseFloat($(this).closest('tr').find(
                `input[name="Pengulangan${i+1}[]"]`).val()));
            var titikUkur = parseFloat($(this).closest('tr').find('input[name="SettingAlat[]"]').val());

            var batasBawah = titikUkur - (titikUkur * 0.1);
            var batasAtas = titikUkur + (titikUkur * 0.1);

            pengulangan.forEach((value, index) => {
                if (value < batasBawah || value > batasAtas) {
                    $(this).closest('tr').find(
                        'input[name="Pengulangan' + (index + 1) + '[]"]').addClass(
                        'is-invalid');
                } else {
                    $(this).closest('tr').find(
                        'input[name="Pengulangan' + (index + 1) + '[]"]').removeClass(
                        'is-invalid');
                }
            });
        });
        $('.Occlusioninput').on('input', function() {
            this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
            var pengulangan = [];
            pengulangan = Array.from({
                length: 6
            }, (_, i) => parseFloat($(this).closest('tr').find(
                `input[name="PengulanganOcc${i+1}[]"]`).val()));
            var titikUkur = parseFloat($(this).closest('tr').find('input[name="SettingAlatOcc[]"]')
                .val());

            var batasBawah = titikUkur - (titikUkur * 0.1);
            var batasAtas = titikUkur + (titikUkur * 0.1);

            pengulangan.forEach((value, index) => {

                if (value < batasBawah || value > batasAtas) {
                    $(this).closest('tr').find(
                        'input[name="PengulanganOcc' + (index + 1) + '[]"]').addClass(
                        'is-invalid');

                } else {
                    $(this).closest('tr').find(
                        'input[name="PengulanganOcc' + (index + 1) + '[]"]').removeClass(
                        'is-invalid');
                }
            });
        });

    });
</script>
