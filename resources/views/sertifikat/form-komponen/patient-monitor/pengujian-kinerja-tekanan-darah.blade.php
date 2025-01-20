<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">TEKANAN DARAH</span>
    </center>
    <center>
        <table class="table table-striped">
            <thead class="thead-dark bg-primary text-white">
                <tr>
                    <th colspan="3" rowspan="2" style="vertical-align: middle;">Parameter</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Titik&nbsp;&nbsp;&nbsp;Ukur
                    </th>
                    <th colspan="3" style="vertical-align: middle; text-align: center;">Pengulangan</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Toleransi</th>
                </tr>
                <tr>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">(mmHg)</th>
                    <th style="vertical-align: middle; text-align: center;">1</th>
                    <th style="vertical-align: middle; text-align: center;">2</th>
                    <th style="vertical-align: middle; text-align: center;">3</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $titikUkur = ['SYSTOL', 'MAP', 'DIASTOLE'];
                    $ukurantitik = [60, 40, 30, 120, 93, 80, 150, 116, 100, 200, 166, 150];
                    $counter = 0;
                @endphp
                {{-- {{ dd($tekanandarahData) }} --}}
                @for ($section = 0; $section < 4; $section++)
                    @for ($row = 0; $row < 3; $row++)
                        <tr>
                            @if ($row == 0)
                                <td colspan="3" rowspan="3"
                                    style="vertical-align: middle; font-weight: bold; text-align: center;"
                                    width="10%">Tekanan (mmHg)</td>
                                <td rowspan="3">{{ $section + 1 }}</td>
                                <td>
                                    <input type="text" class="form-control" name="Titik_Ukur_Nama[]"
                                        value="{{ $titikUkur[$counter % 3] }}" readonly>
                                </td>
                                <td><input type="text" class="form-control" name="Titik_Ukur_Hasil[]"
                                        placeholder="Hasil" value="{{ $ukurantitik[$counter] }}" readonly>
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan1_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan2_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan2 ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan3_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan3 ?? '' }}">
                                </td>
                                <td rowspan="3">±
                                    5&nbsp;&nbsp;&nbsp;mmHg</td>
                            @else
                                <td>
                                    <input type="text" class="form-control" name="Titik_Ukur_Nama[]"
                                        value="{{ $titikUkur[$counter % 3] }}" readonly>
                                </td>
                                <td><input type="text" class="form-control" name="Titik_Ukur_Hasil[]"
                                        placeholder="Hasil" value="{{ $ukurantitik[$counter] }}" readonly>
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan1_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan1 ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan2_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan2 ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="Pengulangan3_Tekanan_Darah[]"
                                        placeholder="Hasil"
                                        value="{{ $tekanandarahData[$counter]->Pengulangan3 ?? '' }}">
                                </td>
                            @endif
                        </tr>
                        @php $counter++; @endphp
                    @endfor
                @endfor
            </tbody>
        </table>

    </center>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.tekananinput').on('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
            });
        });
        $('.tekananinput').on('input', function() {
            var pengulangan1 = parseFloat($(this).closest('tr').find(
                'input[name="Pengulangan1_Tekanan_Darah[]"]').val());
            var pengulangan2 = parseFloat($(this).closest('tr').find(
                'input[name="Pengulangan2_Tekanan_Darah[]"]').val());
            var pengulangan3 = parseFloat($(this).closest('tr').find(
                'input[name="Pengulangan3_Tekanan_Darah[]"]').val());
            var titikUkur = parseFloat($(this).closest('tr').find('input[name="Titik_Ukur_Hasil[]" ]')
                .val());

            var batasBawah = titikUkur - 5;
            var batasAtas = titikUkur + 5;
            //    console.log(batasBawah);

            if (pengulangan1 < batasBawah || pengulangan1 > batasAtas) {
                $(this).closest('tr').find('input[name="Pengulangan1_Tekanan_Darah[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find('input[name="Pengulangan1_Tekanan_Darah[]"]').removeClass(
                    'is-invalid');
            }

            if (pengulangan2 < batasBawah || pengulangan2 > batasAtas) {
                $(this).closest('tr').find('input[name="Pengulangan2_Tekanan_Darah[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find('input[name="Pengulangan2_Tekanan_Darah[]"]').removeClass(
                    'is-invalid');
            }

            if (pengulangan3 < batasBawah || pengulangan3 > batasAtas) {
                $(this).closest('tr').find('input[name="Pengulangan3_Tekanan_Darah[]"]').addClass(
                    'is-invalid');
            } else {
                $(this).closest('tr').find('input[name="Pengulangan3_Tekanan_Darah[]"]')
                    .removeClass(
                        'is-invalid');
            }
        });
    </script>
@endpush
