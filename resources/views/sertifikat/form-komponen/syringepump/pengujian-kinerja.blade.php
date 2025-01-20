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
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Toleransi</th>
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
                <td><input type="text" class="form-control flowinput" name="SettingAlat[]" value="10" readonly>
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan1[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan1[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan2[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan2[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan3[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan3[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan4[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan4[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan5[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan5[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan6[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan6[0] ?? null }}"
                        placeholder="Hasil"></td>
                <td rowspan="3" style="text-align: center; font-weight: bold;">± 10 %</td>
            </tr>
            <tr>
                <td><input type="text" class="form-control flowinput" name="SettingAlat[]" value="50" readonly>
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan1[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan1[1] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan2[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan2[1] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan3[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan3[1] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan4[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan4[1] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan5[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan5[1] ?? null }}"
                        placeholder="Hasil"></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan6[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan6[1] ?? null }}"
                        placeholder="Hasil"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" name="SettingAlat[]" value="100" readonly></td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan1[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan1[2] ?? null }}"
                        placeholder="Hasil">
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan2[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan2[2] ?? null }}"
                        placeholder="Hasil">
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan3[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan3[2] ?? null }}"
                        placeholder="Hasil">
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan4[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan4[2] ?? null }}"
                        placeholder="Hasil">
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan5[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan5[2] ?? null }}"
                        placeholder="Hasil">
                </td>
                <td><input type="text" class="form-control flowinput" name="Pengulangan6[]"
                        value="{{ $sertifikat->getSyringepumpPengujian[0]->Pengulangan6[2] ?? null }}"
                        placeholder="Hasil">
                </td>
            </tr>
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
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Toleransi</th>
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
                <td><input type="text" class="form-control occinput" name="SettingAlatOcc[]" value="100"
                        readonly></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan1[0] ?? '' }}"
                        name="PengulanganOcc1[]" placeholder="Hasil"></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan2[0] ?? '' }}"
                        name="PengulanganOcc2[]" placeholder="Hasil"></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan3[0] ?? '' }}"
                        name="PengulanganOcc3[]" placeholder="Hasil"></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan4[0] ?? '' }}"
                        name="PengulanganOcc4[]" placeholder="Hasil"></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan5[0] ?? '' }}"
                        name="PengulanganOcc5[]" placeholder="Hasil"></td>
                <td><input type="text" class="form-control occinput"
                        value="{{ $sertifikat->getSyringepumpPengujian[1]->Pengulangan6[0] ?? '' }}"
                        name="PengulanganOcc6[]" placeholder="Hasil"></td>
                <td rowspan="6" style="text-align: center; font-weight: bold;">≤ 20 psi</td>
            </tr>
        </tbody>
    </table>
</div>
