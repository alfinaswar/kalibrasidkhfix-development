<div class="row">
    <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
        PEMERIKSAAN FISIK DAN FUNGSI
    </h3>

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
                                <option value=""> --Pilih Status-- </option>
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
                <!-- Hidden English Translation -->
                <td><input type="hidden" name="Parameter1[]" value="Body and Surface of the Tool"></td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <input type="text" class="form-control" name="Parameter2[]" value="Layar Monitor" readonly>
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
                        </div>
                    </div>
                </td>
                <!-- Hidden English Translation -->
                <td><input type="hidden" name="Parameter2[]" value="Monitor Screen"></td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <input type="text" class="form-control" name="Parameter3[]" value="Jarum Penunjukan/Angka"
                        readonly>
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
                        </div>
                    </div>
                </td>
                <!-- Hidden English Translation -->
                <td><input type="hidden" name="Parameter3[]" value="Needle/Pointer"></td>
            </tr>
        </tbody>
    </table>
</div>
