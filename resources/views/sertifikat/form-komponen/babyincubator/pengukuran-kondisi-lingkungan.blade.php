  <div class="row">
      <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
          PENGUKURAN KONDISI LINGKUNGAN</h3>
      <table class="table table-striped">
          <thead class="thead-dark bg-primary text-white">
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">Parameter</th>
                  <th scope="col" colspan="2">
                      <center>Terukur</center>
                  </th>
              </tr>
          </thead>
          <tbody style="vertical-align: middle">
              <tr>
                  <th scope="row">1</th>
                  <td>
                      <input type="text" class="form-control" value="Temperatur Ruangan (C)" name="Parameter[]"
                          readonly>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="Suhu Awal"
                                  name="KondisiAwal[]"
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAwal ?? '' }}"
                                  required>
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-thermometer-half"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="Suhu Akhir"
                                  name="KondisiAkhir[]"
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAkhir ?? '' }}"
                                  required>
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-thermometer-half"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
              </tr>

              <tr>
                  <th scope="row">2</th>
                  <td>
                      <input type="text" class="form-control" value="Kelembapan Ruangan(%)" name="Parameter[]"
                          readonly>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="Kelembapan Awal"
                                  name="KondisiAwal[]"
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAwal ?? '' }}"
                                  required>
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-percentage"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="Kelembapan Akhir"
                                  name="KondisiAkhir[]"
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAkhir ?? '' }}"
                                  required>
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-percentage"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
              </tr>
              <tr>
                  <th scope="row">3</th>
                  <td>
                      <input type="text" class="form-control" value="Tegangan Utama (vAC)" name="TeganganUtama"
                          readonly>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="L-N" name="val[]"
                                  value="{{ $sertifikat->getTeganganUtama->Tegangan_LN ?? '' }}">
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-bolt"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
                  <td>

                  </td>
              </tr>
              <tr>
                  <th scope="row"></th>
                  <td></td>
                  <td>
                      <div class="input-group">
                          <input type="text" class="form-control forminput" placeholder="L-PE" name="val[]"
                              value="{{ $sertifikat->getTeganganUtama->Tegangan_LPE ?? '' }}">
                          <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">
                                  <i class="fas fa-bolt"></i>
                              </span>
                          </div>
                      </div>

                  </td>
                  <td></td>
              </tr>
              <tr>
                  <td></td>
                  <td></td>
                  <td>
                      <div class="input-group">
                          <input type="text" class="form-control forminput" placeholder="N-PE" name="val[]"
                              value="{{ $sertifikat->getTeganganUtama->Tegangan_NPE ?? '' }}">
                          <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">
                                  <i class="fas fa-bolt"></i>
                              </span>
                          </div>
                      </div>

                  </td>
                  <td></td>
              </tr>
              <tr>
                  <th scope="row">4</th>
                  <td style="text-align: center; font-weight: bold;">
                      Kebisingan dalam kompartemen dalam kondisi Off
                      <input type="hidden" class="form-control"
                          value="Kebisingan dalam kompartemen dalam kondisi Off" name="Parameter[]" readonly>
                  </td>
                  <td>
                      <div class="form-control-wrap">
                          <div class="input-group">
                              <input type="text" class="form-control forminput" placeholder="Kebisingan"
                                  name="Kebisingan" required
                                  value="{{ $sertifikat->getKebisingan->Penunjukan ?? '' }}">
                          </div>
                      </div>
                  </td>
                  <td style="text-align: center; font-weight: bold;">
                      dB
                  </td>
              </tr>
          </tbody>
      </table>
  </div>
