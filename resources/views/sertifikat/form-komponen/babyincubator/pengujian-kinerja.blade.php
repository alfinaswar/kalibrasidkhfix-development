<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">1. Kalibrasi Suhu Udara</span><br>
        <span class="text-primary text-uppercase">a. Keseragaman dan Akurasi Suhu</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="5%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th colspan="5" width="75%" style="vertical-align: middle; text-align: center;">Pengulangan</th>
                <th rowspan="2" width="100%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang
                    Diizinkan</th>
            </tr>
            <tr>
                <td width="13%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="13%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="13%" style="vertical-align: middle; text-align: center;">3</td>
                <td width="13%" style="vertical-align: middle; text-align: center;">4</td>
                <td width="13%" style="vertical-align: middle; text-align: center;">5</td>
            </tr>
        </thead>
        <tbody>
            @php
                $sett = 32;
            @endphp
            @for ($i = 1; $i <= 2; $i++)
                @for ($j = 1; $j <= 5; $j++)
                    <tr>
                        @if ($j == 1)
                            <td width="10%" rowspan="5" style="vertical-align: middle; text-align: center;">
                                {{ $i }}</td>
                            <td rowspan="5"><input type="text" class="form-control" id="param1"
                                    name="SettingAlat[]" value="{{ $sett }}" readonly></td>
                        @endif
                        <td><input type="text" class="form-control" readonly name="SensorA[]"
                                value="T{{ $j }}"></td>
                        <td><input type="text" class="form-control forminput" name="Pengulangan1A[]"
                                value="{{ $DataA[0]->Pengulangan1[$j - 1] ?? '' }}"></td>
                        <td><input type="text" class="form-control forminput" name="Pengulangan2A[]"
                                value="{{ $DataA[0]->Pengulangan2[$j - 1] ?? '' }}"></td>
                        <td><input type="text" class="form-control forminput" name="Pengulangan3A[]"
                                value="{{ $DataA[0]->Pengulangan3[$j - 1] ?? '' }}"></td>
                        <td><input type="text" class="form-control forminput" name="Pengulangan4A[]"
                                value="{{ $DataA[0]->Pengulangan4[$j - 1] ?? '' }}"></td>
                        <td><input type="text" class="form-control forminput" name="Pengulangan5A[]"
                                value="{{ $DataA[0]->Pengulangan5[$j - 1] ?? '' }}"></td>
                        @if ($j == 1)
                            <td width="10%" rowspan="4" style="vertical-align: middle; text-align: center;">± 0,8
                                °C terhadap T5</td>
                        @elseif ($j == 5)
                            <td width="10%" style="vertical-align: middle; text-align: center;">± 1,5 °C terhadap
                                setting</td>
                        @endif
                    </tr>
                @endfor
                @php
                    $sett += 4;
                @endphp
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">B. Akurasi Kelembaban Relatif</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th colspan="3" width="50%" style="vertical-align: middle; text-align: center;">Penunjukan
                    Standart (%RH)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang
                    Diizinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
            </tr>
        </thead>
        <tbody>
            @php
                $sett2 = 32;
            @endphp
            @for ($i = 1; $i <= 2; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="text" class="form-control forminput" name="SettingAlatB[]"
                            value="{{ $sett2 }}" readonly></td>
                    @if ($i == 1)
                        <td rowspan="2"><input type="text" class="form-control" readonly name="SensorB[]"
                                value="Humidity Sensor"></td>
                    @endif
                    <td><input type="text" class="form-control forminput" placeholder="Hasil"
                            name="Pengulangan1B[]" value="{{ $DataB[1]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td><input type="text" class="form-control forminput" placeholder="Hasil"
                            name="Pengulangan2B[]" value="{{ $DataB[1]->Pengulangan2[$i - 1] ?? '' }}"></td>
                    <td><input type="text" class="form-control forminput" placeholder="Hasil"
                            name="Pengulangan3B[]" value="{{ $DataB[1]->Pengulangan3[$i - 1] ?? '' }}"></td>
                    @if ($i == 1)
                        <td width="10%" rowspan="2" style="vertical-align: middle; text-align: center;">± 10%
                            RH</td>
                    @endif
                </tr>
                @php
                    $sett2 += 4;
                @endphp
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">C. Lonjakan Suhu (Overshut)</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Setting Alat(&deg;C)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standart (&deg;C)
                </th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang Diizinkan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="text" class="form-control forminput" name="SettingAlatC[]" value="36"
                            readonly>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" readonly name="SensorC[]"
                            value="T5"></td>
                    <td><input type="text" class="form-control forminput" placeholder="Hasil"
                            name="Pengulangan1C[]" value="{{ $DataC[2]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt; 2°C</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">D. Waktu Pemulihan Setelah Lonjakan Suhu</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Setting Alat(&deg;C)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standart (detik)
                </th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang Diizinkan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatD[]" value="36" readonly>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" readonly name="SensorD[]"
                            value="T5"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1D[]"
                            value="{{ $DataD[3]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 900 detik</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">E. Suhu Matras (&deg;C)</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Setting Alat(&deg;C)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standart (&deg;C)
                </th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang Diizinkan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatE[]" value="36" readonly>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" readonly name="SensorE[]"
                            value="Sensor Temperatur Matras"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1E[]"
                            value="{{ $DataE[4]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 40 &deg;C</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">F. Kecepatan Aliran Udara</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Setting Alat(&deg;C)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standart (m/s)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan Yang Diizinkan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatF[]" value="36" readonly>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" readonly name="SensorF[]"
                            value="Air FLow Sensor"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1F[]"
                            value="{{ $DataF[5]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 0.35 m/s</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">G. Kebisingan</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Sensor</th>
                <th colspan="4" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan
                    Standart <span style="text-transform: none">(dB)</span></th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan
                    Yang Diizinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">4</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatG[]" value="36" readonly>
                    </td>
                    <td rowspan="2"><input type="text" class="form-control" readonly name="SensorG[]"
                            value="Sound Level Sensor"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1G[]"
                            value="{{ $DataG[6]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan2G[]"
                            value="{{ $DataG[6]->Pengulangan2[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan3G[]"
                            value="{{ $DataG[6]->Pengulangan3[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan4G[]"
                            value="{{ $DataG[6]->Pengulangan4[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 60 dB</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary fw-bold text-uppercase">2. Kalibrasi Sensor temperatur Kulit</span><br>
        <span class="text-primary text-uppercase">A. Akurasi Temperatur Kulit dengan Temperatur Kontrol</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th colspan="3" width="60%" style="vertical-align: middle; text-align: center;">Display
                    pembacaan skin probe(&deg;C)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan
                    Yang Diizinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatH[]" value="36" readonly>
                    </td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1H[]"
                            value="{{ $DataH[7]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan2H[]"
                            value="{{ $DataH[7]->Pengulangan2[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan3H[]"
                            value="{{ $DataH[7]->Pengulangan3[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 0.7 &deg;C</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row mt-3">
    <center>
        <span class="text-primary text-uppercase">B. Akurasi Sensor Temperatur Kulit</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">No</span></th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Setting
                    Alat(&deg;C)</th>
                <th colspan="3" width="60%" style="vertical-align: middle; text-align: center;">Display
                    pembacaan skin probe(&deg;C)</th>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penyimpanan
                    Yang Diizinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">1</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">2</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">3</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 1; $i++)
                <tr>
                    <td width="10%" style="vertical-align: middle; text-align: center;">{{ $i }}</td>
                    <td><input type="number" class="form-control" name="SettingAlatI[]" value="36" readonly>
                    </td>
                    <td><input type="text" class="form-control" name="SensorI[]" value="baby mode" readonly></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan1I[]"
                            value="{{ $DataI[8]->Pengulangan1[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan2I[]"
                            value="{{ $DataI[8]->Pengulangan2[$i - 1] ?? '' }}"></td>
                    <td><input type="number" class="form-control" placeholder="Hasil" name="Pengulangan3I[]"
                            value="{{ $DataI[8]->Pengulangan3[$i - 1] ?? '' }}"></td>
                    <td width="10%" style="vertical-align: middle; text-align: center;">&lt;= 0.3 &deg;C</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
