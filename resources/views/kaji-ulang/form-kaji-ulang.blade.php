@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Kaji Ulang</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('ku.store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="SerahTerimaId" value="{{ $data->id }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <select id="single-select" name="CustomerId"
                                    class="form-control-lg @error('CustomerId') is-invalid @enderror">
                                    <option>Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}"
                                            @if ($cust->id == $data->CustomerId) Selected @endif>{{ $cust->Name }}</option>
                                    @endforeach
                                </select>
                                @error('CustomerId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="Status">
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif" @selected($data->Status == 'Aktif')>Aktif</option>
                                    <option value="Tidak Aktif" @if ($data->Status == 'Tidak Aktif') selected @endif>Tidak
                                        Aktif</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <input type="text" class="form-control @error('TanggalDiterima') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" value="{{ $data->TanggalDiterima }}" disabled>
                                @error('TanggalDiterima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control @error('CatatanKajiUlang') is-invalid @enderror" placeholder="Masukkan catatan"
                                    name="CatatanKajiUlang">{{ $data->Catatan ?? old('CatatanKajiUlang') }}</textarea>
                                @error('CatatanKajiUlang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diserahkan</label>
                                <input type="text" class="form-control @error('TanggalDiajukan') is-invalid @enderror"
                                    placeholder="Tanggal Diserahkan" value="{{ $data->TanggalDiajukan }}" disabled>
                                @error('TanggalDiajukan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="text-center mt-4">
                            <u>
                                <h3>DETAIL INSTRUMEN
                            </u></h3>

                        </div>
                        <div class="text-end mt-4">

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle" width="150%">
                                <thead>
                                    <tr class="text-center">

                                        <th scope="col" width="30%">Instumen</th>
                                        <th width="30%">Metode 1</th>
                                        <th scope="col">Metode 2</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Kondisi</th>
                                        <th scope="col">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data->Stdetail as $detail)
                                        <tr>
                                            <td><select class="form-control multi-select" tabindex="null"
                                                    name="InstrumenId[]" required readonly>
                                                    <option>Pilih Instrumen</option>
                                                    @foreach ($instrumen as $key => $item)
                                                        <option value="{{ $item->id . '-' . ($detail->jumlahAlat ?? 1) }}"
                                                            @if ($detail->InstrumenId == $item->id) selected @endif>
                                                            {{ $item->Nama }} @if ($detail->InstrumenId == $item->id)
                                                                ({{ $detail->jumlahAlat ?? 1 }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('InstrumenId')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td><select name="Metode1[]"
                                                    class="multi-select form-control-lg @error('Metode1') is-invalid @enderror">
                                                    <option value="">Pilih Metode</option>
                                                    @foreach ($metode as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $detail->getNamaAlat->Metode) Selected @endif>
                                                            {{ $item->Nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('Metode1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td width="30%"><select name="Metode2[]"
                                                    class="multi-select form-control-lg @error('Metode2') is-invalid @enderror">
                                                    <option value="">Pilih Metode</option>
                                                    @foreach ($metode as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $detail->getNamaAlat->Metode)  @endif>
                                                            {{ $item->Nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('Metode1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td width="30%"><select class="multi-select" tabindex="null" name="Status[]"
                                                    required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="DITERIMA">Diterima</option>
                                                    <option value="DITOLAK">Ditolak</option>
                                                    <option value="DITERIMASEBAGIAN">Diterima Sebagian</option>
                                                    </option>

                                                </select></td>
                                            <td width="30%"><select class="multi-select" tabindex="null" name="Kondisi[]"
                                                    required>
                                                    <option value="">Pilih Kondisi Alat</option>
                                                    <option value="BERFUNGSI">Berfungsi</option>
                                                    <option value="TIDAKBERFUNGSI">Tidak Bergungsi</option>
                                                    </option>

                                                </select>
                                            </td>
                                            <td width="200px">
                                                <textarea name="Catatan[]" class="form-control" rows="4" cols="50"></textarea>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                </div>
                <br />
                <button type="submit" class="btn btn-md btn-primary btn-block mt-5">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-row').addEventListener('click', function() {
            var table = document.getElementById('instrument-table').getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cells = [
                '<select name="InstrumenId[]" class="default-select form-control" tabindex="true"><option>Pilih Instrumen</option>@foreach ($instrumen as $inst)<option value="{{ $inst->id }}">{{ $inst->Nama }}</option>@endforeach</select>',
                '<select name="Metode1[]" class="default-select form-control" tabindex="true"><option value="val1">val1</option></select></select>',
                '<select name="Metode2[]" class="default-select form-control" tabindex="true"><option value="val1">val1</option></select></select>',
                '<select name="Status[]" class="default-select form-control" tabindex="true"><option value="1">Diterima</option><option value="2">Ditolak</option></select></select>',
                '<select name="Kondisi[]" class="default-select form-control" tabindex="true"><option value="1">Berfungsi</option><option value="2">Tidak Berfungsi</option></select></select>',
                '<input type="text" name="Catatan[]" class="form-control" placeholder="Deskripsi">'
            ];

            cells.forEach(function(cellContent) {
                var cell = newRow.insertCell();
                cell.innerHTML = cellContent;
            });
        });
    </script>
@endsection
