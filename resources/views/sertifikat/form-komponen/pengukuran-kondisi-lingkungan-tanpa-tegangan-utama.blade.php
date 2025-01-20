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
                                  name="KondisiAwal[]" required
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAwal ?? null }}">
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
                                  name="KondisiAkhir[]" required
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAkhir ?? null }}">
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
                                  name="KondisiAwal[]" required
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAwal ?? null }}">
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
                                  name="KondisiAkhir[]" required
                                  value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAkhir ?? null }}">
                              <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon2">
                                      <i class="fas fa-percentage"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </td>
              </tr>

          </tbody>
      </table>
  </div>
  <script>
      $('.forminput').on('input', function() {
          this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
      });
  </script>
