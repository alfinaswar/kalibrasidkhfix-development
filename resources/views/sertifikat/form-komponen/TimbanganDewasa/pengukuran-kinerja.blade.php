<div class="row">
    <div class="col-6">
        <center>
            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                PENGUJIAN KINERJA</h3>
        </center>
        <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
            <thead class="thead-dark bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Kapasitas 1/2 max</th>
                    <th>Z</th>
                    <th style="text-align: center;">M</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><input type="text" class="form-control" name="MassaHalf[]" value="40 Kg" readonly></td>
                        <td><input type="text" class="form-control" name="PengujianZhalf[]"
                                value="{{ $sertifikat->getPengujianTimbangan[0]->PengujianZ[$i] ?? '' }}"
                                placeholder="Hasil"></td>
                        <td><input type="text" class="form-control" name="PengujianMhalf[]"
                                value="{{ $sertifikat->getPengujianTimbangan[0]->PengujianM[$i] ?? '' }}"
                                placeholder="Hasil"></td>
                    </tr>
                @endfor
                <input type="hidden" name="TipePengujian[]" value="KINERJA">
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <center>
            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                PENGUJIAN KINERJA MAX</h3>
        </center>
        <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
            <thead class="thead-dark bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Kapasitas Max</th>
                    <th>Z</th>
                    <th style="text-align: center;">M</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><input type="text" class="form-control" name="MassaMax[]" value="100 Kg" readonly></td>
                        <td><input type="text" class="form-control" name="PengujianZmax[]"
                                value="{{ $sertifikat->getPengujianTimbangan[1]->PengujianZ[$i] ?? '' }}"
                                placeholder="Hasil"></td>
                        <td><input type="text" class="form-control" name="PengujianMmax[]"
                                value="{{ $sertifikat->getPengujianTimbangan[1]->PengujianM[$i] ?? '' }}"
                                placeholder="Hasil"></td>
                    </tr>
                @endfor
                <input type="hidden" name="TipePengujian[]" value="KINERJA">
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN SKALA NOMINAL</h3>
    </center>
    <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th>No</th>
                <th>Massa</th>
                <th>Z</th>
                <th>M</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i < 11; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td><input type="text" class="form-control" value="{{ $i * 2 }} Kg" readonly>
                    </td>
                    <td><input type="text" class="form-control" name="PengujianZnom[]"
                            value="{{ $sertifikat->getPengujianTimbangan[2]->PengujianZ[$i - 1] ?? '' }}"
                            placeholder="Hasil"></td>
                    <td><input type="text" class="form-control" name="PengujianMnom[]"
                            value="{{ $sertifikat->getPengujianTimbangan[2]->PengujianM[$i - 1] ?? '' }}"
                            placeholder="Hasil"></td>
                </tr>
            @endfor
            <input type="hidden" name="TipePengujian[]" value="SKALA">
        </tbody>
    </table>
</div>
