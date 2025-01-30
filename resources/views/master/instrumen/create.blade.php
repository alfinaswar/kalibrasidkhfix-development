  @extends('layouts.app')
  @section('content')
      <div class="col-xl-12 col-lg-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Form Instrumen Alat</h4>
              </div>
              <div class="card-body">
                  <div class="basic-form">
                      <form action="{{ route('instrumen.store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="row">
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Kategori</label>
                                  <select name="Kategori" id=""
                                      class="form-control @error('Kategori') is-invalid @enderror">
                                      <option value="">Pilih Kategori</option>
                                      <option value="ALKES" {{ old('Kategori') == 'ALKES' ? 'selected' : '' }}>Alkes
                                      </option>
                                      <option value="INDUSTRI" {{ old('Kategori') == 'INDUSTRI' ? 'selected' : '' }}>
                                          Industri
                                      </option>
                                  </select>
                                  @error('Kategori')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Nama</label>
                                  <div class="row">
                                      <div class="col-md-9">
                                          <input type="text" name="Nama"
                                              class="form-control @error('Nama') is-invalid @enderror"
                                              value="{{ old('Nama') }}" id="Nama" placeholder="Nama Instrumen"
                                              onkeyup="NamaInstrumen()">
                                          @error('Nama')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                          <div id="autocomplete" class="mt-2"></div>
                                      </div>
                                      <div class="col-md-3">
                                          <button type="button" id="CekInstrumen"
                                              class="btn btn-primary btn-md btn-CekInstrumen">
                                              Cek
                                          </button>
                                      </div>

                                  </div>

                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Tarif</label>
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">Rp.</span>
                                      </div>
                                      <input type="text" name="Tarif"
                                          class="form-control @error('Tarif') is-invalid @enderror" placeholder="Tarif"
                                          onkeyup="this.value=formatRupiah(this.value)" value="{{ old('Tarif') }}">
                                      <div class="input-group-append">
                                          <span class="input-group-text">.00</span>
                                      </div>
                                      @error('Tarif')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Akreditasi</label>
                                  <select name="Akreditasi" class="form-control @error('Akreditasi') is-invalid @enderror">
                                      <option value="">Status Akreditasi</option>
                                      <option value="YA" {{ old('Akreditasi') == 'YA' ? 'selected' : '' }}>YA</option>
                                      <option value="TIDAK" {{ old('Akreditasi') == 'TIDAK' ? 'selected' : '' }}>TIDAK
                                      </option>
                                  </select>
                                  @error('Akreditasi')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Alat Ukur</label>
                                  <select
                                      class="multi-select select2-hidden-accessible @error('AlatUkur') is-invalid @enderror"
                                      name="AlatUkur[]" multiple tabindex="-1" aria-hidden="true">
                                      @foreach ($data as $x)
                                          <option value="{{ $x->id }}"
                                              {{ collect(old('AlatUkur'))->contains($x->id) ? 'selected' : '' }}>
                                              {{ $x->Nama }} - {{ $x->Merk }} - {{ $x->Sn }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('AlatUkur')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">File Lembar Kerja</label>
                                  <input type="file" name="LK"
                                      class="form-control @error('LK') is-invalid @enderror" placeholder="Lembar Kerja">
                                  @error('LK')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Status</label>
                                  <select name="Status" id=""
                                      class="form-control @error('Status') is-invalid @enderror">
                                      <option value="">Pilih Status</option>
                                      <option value="AKTIF" {{ old('Status') == 'AKTIF' ? 'selected' : '' }}>Aktif
                                      </option>
                                      <option value="TIDAKAKTIF" {{ old('Status') == 'TIDAKAKTIF' ? 'selected' : '' }}>
                                          Tidak
                                          Aktif</option>
                                  </select>
                                  @error('Status')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Metoda Kerja</label>
                                  <select name="Metode" class="multi-select @error('Metode') is-invalid @enderror">
                                      <option>Pilih Metoda Kerja</option>
                                      @foreach ($metode as $x)
                                          <option value="{{ $x->id }}">{{ $x->Nama }}</option>
                                      @endforeach
                                  </select>
                                  @error('Metode')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="mb-3 col-md-6">
                                  <label class="form-label">Nama Lembar Kerja Sistem</label>
                                  <input type="text" name="NamaFile" id="NamaFile"
                                      class="form-control @error('NamaFile') is-invalid @enderror" readonly>
                                  <input type="hidden" name="NamaFunction" id="NamaFunction" class="form-control"
                                      readonly>
                                  @error('NamaFile')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
 <div class="row">
                              <div class="card">
                                  <div class="card-header">
                                      <h4 class="card-title">Pengaturan LK</h4>
                                  </div>
                                  <div class="card-body">
                                      <ul class="nav nav-pills mb-4 light">
                                          <li class="nav-item">
                                              <a href="#navpills-1" class="nav-link active" data-bs-toggle="tab" aria-expanded="false">
                                                  <i class="fas fa-thermometer-half"></i> Pengukuran Suhu Lingkungan
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="#navpills-2" class="nav-link" data-bs-toggle="tab" aria-expanded="false">
                                                  <i class="fas fa-bolt"></i> Pengukuran Tegangan Utama
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="#navpills-3" class="nav-link" data-bs-toggle="tab" aria-expanded="true">
                                                  <i class="fas fa-cogs"></i> Parameter Fisik dan Fungsi
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a href="#navpills-4" class="nav-link" data-bs-toggle="tab" aria-expanded="true">
                                                  <i class="fas fa-plug"></i> Parameter Kelistrikan
                                              </a>
                                          </li>
                                      </ul>
                                      <div class="tab-content">
                                          <div id="navpills-1" class="tab-pane active">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="mb-3">
                                                          <label class="form-label">Pengukuran Suhu Lingkungan</label>
                                                          <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="PengukuranSuhu" id="Y" value="Y" {{ old('PengukuranSuhu') == 'Y' ? 'checked' : '' }}>
                                                              <label class="form-check-label" for="Y">YA</label>
                                                          </div>
                                                          <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="PengukuranSuhu" id="N" value="N" {{ old('PengukuranSuhu') == 'N' ? 'checked' : '' }}>
                                                              <label class="form-check-label" for="N">TIDAK</label>
                                                          </div>
                                                          @error('PengukuranSuhu')
                                                              <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                              </span>
                                                          @enderror
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div id="navpills-2" class="tab-pane">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="mb-3">
                                                          <label class="form-label">Pengukuran Tegangan Utama</label>
                                                          <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="TeganganUtama" id="Y" value="Y" {{ old('TeganganUtama') == 'Y' ? 'checked' : '' }}>
                                                              <label class="form-check-label" for="Y">YA</label>
                                                          </div>
                                                          <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="TeganganUtama" id="N" value="N" {{ old('TeganganUtama') == 'N' ? 'checked' : '' }}>
                                                              <label class="form-check-label" for="N">TIDAK</label>
                                                          </div>
                                                          @error('TeganganUtama')
                                                              <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $message }}</strong>
                                                              </span>
                                                          @enderror
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div id="navpills-3" class="tab-pane">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <label class="form-label">Parameter Fisik dan Fungsi</label>
                                                      <div class="text-end">
                                                          <button type="button" class="btn btn-primary btn-sm text-end" id="add-row">Add Row</button>
                                                      </div>
                                                      <table class="table" id="parameter-table">
                                                          <thead>
                                                              <tr>
                                                                  <th>Nama Parameter</th>
                                                                  <th>Mapping Excel</th>
                                                                  <th>Action</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              <tr>
                                                                  <td>
                                                                      <select class="multi-select select2-hidden-accessible" name="ParameterIndo[]" tabindex="-1" aria-hidden="true">
                                                                          <option value="">Pilih Parameter</option>
                                                                          @foreach ($ParameterFisik as $x)
                                                                              <option value="{{ $x->id }}">{{ $x->Parameter }}</option>
                                                                          @endforeach
                                                                      </select>
                                                                  </td>
                                                                  <td>
                                                                      <input type="text" name="MappingExcel[]" class="form-control" placeholder="Mapping Excel">
                                                                  </td>
                                                                  <td>
                                                                      <button type="button" class="btn btn-danger btn-sm remove-row">Delete</button>
                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                          <div id="navpills-4" class="tab-pane">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <label class="form-label">Parameter Kelistrikan</label>
                                                      <div class="text-end">
                                                          <button type="button" class="btn btn-primary btn-sm" id="add-row-kelistrikan">Add Row</button>
                                                      </div>
                                                      <table class="table" id="parameter-kelistrikan-table">
                                                          <thead>
                                                              <tr>
                                                                  <th>Nama Parameter</th>
                                                                  <th>Mapping Excel</th>
                                                                  <th>Action</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              <tr>
                                                                  <td>
                                                                      <select class="multi-select select2-hidden-accessible" name="ParameterListrikIndo[]" tabindex="-1" aria-hidden="true">
                                                                          <option value="">Pilih Parameter</option>
                                                                          @foreach ($ParameterListrik as $x)
                                                                              <option value="{{ $x->id }}">{{ $x->Parameter }}</option>
                                                                          @endforeach
                                                                      </select>
                                                                  </td>
                                                                  <td>
                                                                      <input type="text" name="MappingExcelKelistrikan[]" class="form-control" placeholder="Mapping Excel">
                                                                  </td>
                                                                  <td>
                                                                      <button type="button" class="btn btn-danger btn-sm remove-row">Delete</button>
                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>



                          <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  @endsection
  @push('scripts')
      <script>
          function NamaInstrumen() {
              var nama = $("#Nama").val().replace(/\s+/g, '-');
              console.log(nama);

              $("#NamaFile").val(nama);
              var NamaFunction = $("#Nama").val().replace(/\s+/g, '');
              $("#NamaFunction").val(NamaFunction);
          }

          function formatRupiah(angka, prefix) {
              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                  split = number_string.split(','),
                  sisa = split[0].length % 3,
                  rupiah = split[0].substr(0, sisa) + (sisa ? '.' : '') + split[0].substr(sisa).replace(/\D/g, '')
                  .replace(
                      /\B(?=(\d{3})+(?!\d))/g, ".");
              return prefix == undefined ? rupiah : (rupiah ? rupiah + prefix : '');
          }
      </script>
      <script>
          $(document).ready(function() {
              $('body').on('click', '#CekInstrumen', function() {
                  var Nama = $("#Nama").val();
                  $.ajax({
                      url: "{{ route('instrumen.CekInstrumen') }}",
                      method: "GET",
                      data: {
                          Nama: Nama
                      },
                      success: function(data) {
                          if (data.success) {
                              $("#autocomplete").html(data.success);
                          } else {
                              console.log('error');
                          }
                      },
                      error: function(xhr, status, error) {
                          console.log(xhr.responseText);
                      }
                  });
              });


          });
      </script>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const table = document.getElementById('parameter-table').querySelector('tbody');
              const addRowButton = document.getElementById('add-row');
              addRowButton.addEventListener('click', function() {
                  const newRow = document.createElement('tr');
                  newRow.innerHTML = `
 <td>
                    <select class="multi-select select2-hidden-accessible"
                            name="ParameterIndo[]">
                            <option value="">Pilih Parameter</option>
                            @foreach ($ParameterFisik as $x)
                                <option value="{{ $x->id }}">
                                    {{ $x->Parameter }}
                                </option>
                            @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="MappingExcel[]" class="form-control" placeholder="Mapping Excel">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Delete</button>
                </td>
            `;
                  table.appendChild(newRow);
                  $(newRow).find('.multi-select').select2();
              });

              table.addEventListener('click', function(e) {
                  if (e.target.classList.contains('remove-row')) {
                      const row = e.target.closest('tr');
                      row.remove();
                  }
              });
          });
      </script>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const kelistrikanTable = document.getElementById('parameter-kelistrikan-table').querySelector('tbody');
              const addRowButton = document.getElementById('add-row-kelistrikan');

              // Function to add a new row
              addRowButton.addEventListener('click', function() {
                  const newRow = document.createElement('tr');
                  newRow.innerHTML = `
                <td>
                    <select class=multi-select select2-hidden-accessible"
                            name="ParameterListrikIndo[]">
                            <option value="">Pilih Parameter</option>
                            @foreach ($ParameterListrik as $x)
                                <option value="{{ $x->id }}">
                                    {{ $x->Parameter }}
                                </option>
                            @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="MappingExcelKelistrikan[]" class="form-control" placeholder="Mapping Excel">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Delete</button>
                </td>
            `;
                  kelistrikanTable.appendChild(newRow);
                  $(newRow).find('.multi-select').select2();
              });
              kelistrikanTable.addEventListener('click', function(e) {
                  if (e.target.classList.contains('remove-row')) {
                      const row = e.target.closest('tr');
                      row.remove();
                  }
              });
          });
      </script>
  @endpush
