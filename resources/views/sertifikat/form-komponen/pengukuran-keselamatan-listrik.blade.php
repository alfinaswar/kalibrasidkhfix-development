<div class="row">
    <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
        PENGUKURAN KESELAMATAN LISTRIK</h3>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th scope="col">#</th>
                <th scope="col">#</th>
                <th scope="col">#</th>
            </tr>
        </thead>
        <tbody style="vertical-align: middle">
            <tr>
                <th scope="row">1</th>
                <td>
                    <strong>Tipe</strong>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="TipeListrik" class="form-control">
                                <option value=""> --Pilih Tipe-- </option>
                                <option value="B"
                                    {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'B' ? 'selected' : '' }}>
                                    B</option>
                                <option value="BF"
                                    {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'BF' ? 'selected' : '' }}>
                                    BF</option>
                                <option value="CF"
                                    {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'CF' ? 'selected' : '' }}>
                                    CF</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <strong>Kelas</strong>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="Kelas" class="form-control">
                                <option value=""> --Pilih Kelas-- </option>
                                <option value="I"
                                    {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'I' ? 'selected' : '' }}>
                                    I</option>
                                <option value="II"
                                    {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'II' ? 'selected' : '' }}>
                                    II</option>
                                <option value="IP"
                                    {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'IP' ? 'selected' : '' }}>
                                    IP</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Parameter</th>
                <th scope="col">Terukur</th>
                <th scope="col">Ambang Batas</th>
            </tr>
        </thead>
        <tbody style="vertical-align: middle">
            <tr>
                <th scope="row">1</th>
                <td>
                    <input type="text" class="form-control" value="Tegangan (main voltage) (V)" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Tegangan (main voltage)
                                                                                        (V)"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter1 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>220 V ± 10 %</span>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <input type="text" class="form-control" value="Resistansi PE (protective earth) Ω" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Resistansi PE (protective earth) Ω"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter2 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>≤ 0,2 Ω</span>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <input type="text" class="form-control" value="Arus bocor peralatan  µA" readonly>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Arus bocor peralatan µA"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter3 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>≤ 500 µA</span>
                </td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>
                    <input type="text" class="form-control" value="Arus bocor bagian yang diaplikasikan µA" readonly>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Arus bocor bagian yang diaplikasikan
                                                                                        µA"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter4 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>≤ 50 µA</span>
                </td>
            </tr>
            <tr>
                <th scope="row">5</th>
                <td>
                    <input type="text" class="form-control" value="Resistansi Isolasi" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Resistansi Isolasi"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter5 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>> 2 MΩ</span>
                </td>
            </tr>
            <tr>
                <th scope="row">6</th>
                <td>
                    <input type="text" class="form-control" value="Ampere" readonly>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" name="TerukurListrik2[]" class="form-control" required
                                placeholder="Ampere"
                                value="{{ $sertifikat->getPengukuranListrik->Parameter6 ?? null }}">
                        </div>
                    </div>
                </td>
                <td>
                    <span>Ampere</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
