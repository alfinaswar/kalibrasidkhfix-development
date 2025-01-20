<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">Laju Aliran / Flow</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjukan Alat
                    (Lpm)</th>
                <th colspan="5" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standar
                    (L/min)</th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">4</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">5</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="6" style="text-align: center; font-weight: bold;">max</td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan1"
                        value="{{ $sertifikat->getNebulizerPengujian->Pengulangan1 ?? '' }}" placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan2"
                        value="{{ $sertifikat->getNebulizerPengujian->Pengulangan2 ?? '' }}" placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan3"
                        value="{{ $sertifikat->getNebulizerPengujian->Pengulangan3 ?? '' }}" placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan4"
                        value="{{ $sertifikat->getNebulizerPengujian->Pengulangan4 ?? '' }}" placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan5"
                        value="{{ $sertifikat->getNebulizerPengujian->Pengulangan5 ?? '' }}" placeholder="Hasil"></td>
                <td rowspan="6" style="text-align: center; font-weight: bold;">&gt; 4 Lpm</td>
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
                length: 5
            }, (_, i) => parseFloat($(this).closest('tr').find(
                `input[name="Pengulangan${i+1}"]`).val()));

            var batasBawah = 4;
            var batasAtas = 4;

            pengulangan.forEach((value, index) => {

                if (value < batasBawah) {
                    $(this).closest('tr').find(
                        'input[name="Pengulangan' + (index + 1) + '"]').addClass(
                        'is-invalid');

                } else {
                    $(this).closest('tr').find(
                        'input[name="Pengulangan' + (index + 1) + '"]').removeClass(
                        'is-invalid');
                }
            });
        });

    });
</script>
