<div class="row">
    <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
        PEMERIKSAAN FISIK DAN FUNGSI</h3>

    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Parameter</th>
                <th scope="col" colspan="2">
                    <center>Hasil</center>
                </th>
            </tr>
        </thead>
        <tbody style="vertical-align: middle">
            <tr>
                <th scope="row">1</th>
                <td>
                    <input type="text" class="form-control" name="Parameter1[]" value="Badan dan Permukaan" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter1[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter1[]" value="Body and Surface">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <input type="text" class="form-control" name="Parameter2[]" value="Balon Tensi / Bulb" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter2[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter2[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter2[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter2[]" value="Pressure Balloon / Bulb">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <input type="text" class="form-control" name="Parameter3[]" value="Valve Penutup" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter3[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter3[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter3[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter3[]" value="Cover Valve">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>
                    <input type="text" class="form-control" name="Parameter4[]" value="Indikator" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter4[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter4[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter4[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter4[]" value="Indicator">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">5</th>
                <td>
                    <input type="text" class="form-control" name="Parameter5[]" value="Pengaturan Titik Nol"
                        readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter5[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter5[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter5[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter5[]" value="Zero Point Adjustment">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">6</th>
                <td>
                    <input type="text" class="form-control" name="Parameter6[]" value="Konektor" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter6[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter6[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter6[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter6[]" value="Connector">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">7</th>
                <td>
                    <input type="text" class="form-control" name="Parameter7[]" value="Label" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter7[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter7[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter7[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter7[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter7[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter7[]" value="Label">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">8</th>
                <td>
                    <input type="text" class="form-control" name="Parameter8[]" value="Pengencang" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter8[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter8[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter8[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter8[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter8[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter8[]" value="Tightener">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">9</th>
                <td>
                    <input type="text" class="form-control" name="Parameter9[]" value="Filter" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter9[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter9[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter9[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter9[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter9[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter9[]" value="Filter">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">10</th>
                <td>
                    <input type="text" class="form-control" name="Parameter10[]" value="Gauge / Tabung" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter10[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter10[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter10[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter10[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter10[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter10[]" value="Gauge / Tube">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">11</th>
                <td>
                    <input type="text" class="form-control" name="Parameter11[]" value="Bantalan Rem" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter11[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter11[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter11[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter11[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter11[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter11[]" value="Brake Lining">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">12</th>
                <td>
                    <input type="text" class="form-control" name="Parameter12[]" value="Manset" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter12[]" class="form-control">
                                <option value=""> --Pilih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter12[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter12[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter12[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter12[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                            <input type="hidden" name="Parameter12[]" value="Manset">
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
