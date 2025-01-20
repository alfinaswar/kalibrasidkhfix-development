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
                    <input type="text" class="form-control" name="Parameter1[]" value="Badan dan Permukaan Alat"
                        readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter1[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter1[]" value="Body and Surface of the Device"
                    readonly>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <input type="text" class="form-control" name="Parameter2[]" value="Kotak Kontak Alat" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter2[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter2[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter2[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter2[]" value="Instrument Contact Box" readonly>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <input type="text" class="form-control" name="Parameter3[]" value="Kabel Catu Utama" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter3[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter3[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter3[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter3[]" value="Main Power Cable" readonly>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>
                    <input type="text" class="form-control" name="Parameter4[]" value="Sekering Pengaman" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter4[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter4[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter4[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter4[]" value="Safety Fuse" readonly>
            </tr>
            <tr>
                <th scope="row">5</th>
                <td>
                    <input type="text" class="form-control" name="Parameter5[]" value="Tombol dan Selektor (Knob)"
                        readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter5[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter5[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter5[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter5[]" value="Buttons and Selector (Knob)"
                    readonly>
            </tr>
            <tr>
                <th scope="row">6</th>
                <td>
                    <input type="text" class="form-control" name="Parameter6[]" value="Tampilan dan Indikator"
                        readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter6[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter6[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter6[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter6[]" value="Display and Indicator"
                    readonly>
            </tr>
            <tr>
                <th scope="row">7</th>
                <td>
                    <input type="text" class="form-control" name="Parameter7[]" value="Sensor/Gawai" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter7[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter7[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter7[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter7[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter7[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter7[]" value="Sensor/Device" readonly>
            </tr>
            <tr>
                <th scope="row">8</th>
                <td>
                    <input type="text" class="form-control" name="Parameter8[]" value="Saringan Udara" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter8[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter8[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter8[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter8[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter8[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter8[]" value="Air Filter" readonly>
            </tr>
            <tr>
                <th scope="row">9</th>
                <td>
                    <input type="text" class="form-control" name="Parameter9[]" value="Batas Cairan" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter9[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter9[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter9[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter9[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter9[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter9[]" value="Fluid Limit" readonly>
            </tr>
            <tr>
                <th scope="row">10</th>
                <td>
                    <input type="text" class="form-control" name="Parameter10[]" value="Kasur" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Parameter10[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="1"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter10[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter10[1] == 1 ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="0"
                                    {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter10[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter10[1] == 0 ? 'selected' : '' }}>
                                    Tidak Baik</option>
                            </select>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="form-control" name="Parameter10[]" value="Mattress" readonly>
            </tr>
        </tbody>
    </table>
</div>
