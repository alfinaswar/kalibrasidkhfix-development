@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Serah Terima Barang</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('st.update', $st->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <select id="single-select" name="CustomerId"
                                    class="form-control-lg @error('CustomerId') is-invalid @enderror">
                                    <option>Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}"
                                            @if ($cust->id == $st->CustomerId) Selected @endif>{{ $cust->Name }}</option>
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
                                <select name="Status" class="form-control @error('Status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="AKTIF" @if ($st->Status == 'AKTIF') selected @endif>Aktif</option>
                                    <option value="TIDAK" @if ($st->Status == 'TIDAK') selected @endif>Tidak Aktif
                                    </option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <input type="text" id="date-format"
                                    class="form-control @error('TanggalDiterima') is-invalid @enderror"
                                    placeholder="Tanggal Diserahkan" name="TanggalDiterima"
                                    value="{{ $st->TanggalDiterima }}">
                                @error('TanggalDiterima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Lokasi</label>
                                <select name="Lokasi" class="form-control @error('Lokasi') is-invalid @enderror">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="INSITU" {{ old('Lokasi') }}
                                        @if ($st->Lokasi == 'INSITU') selected @endif>INSITU</option>
                                    <option value="EKSITU" {{ old('Lokasi') }}
                                        @if ($st->Lokasi == 'EKSITU') selected @endif>EKSITU</option>
                                </select>
                                @error('Lokasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <u>
                                <h3>DETAIL INSTRUMEN</h3>
                            </u>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle" id="instrument-table">
                                    <thead>
                                        <tr class="text-center">

                                            <th scope="col">Alat</th>
                                            <th scope="col">Merk</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">SerialNumber</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($st->Stdetail as $item)
                                            <tr>
                                                <td><select class="multi-select" tabindex="null" name="InstrumenId[]">
                                                        @foreach ($instrumen as $inst)
                                                            <option value="{{ $inst->id }}"
                                                                @selected($item->InstrumenId == $inst->id)>{{ $inst->Nama }}</option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="text" name="Merk[]" class="form-control"
                                                        placeholder="Merk" value="{{ $item->Merk }}">
                                                </td>
                                                <td><input type="text" name="Type[]" value="{{ $item->Type }}"
                                                        class="form-control" placeholder="Type">
                                                </td>
                                                <td><input type="text" name="SerialNumber[]"
                                                        value="{{ $item->SerialNumber }}" class="form-control"
                                                        placeholder="Serial Number"></td>
                                                <td><input type="number" name="Qty[]" value="{{ $item->jumlahAlat }}"
                                                        class="form-control" placeholder="Qty">
                                                </td>
                                                <td><input type="text" name="Deskripsi[]" value="{{ $item->Deskripsi }}"
                                                        class="form-control" placeholder="Deskripsi">
                                                    <input type="hidden" name="Tambahan[]" value="TIDAK">
                                                </td>
                                                <td><button type="button" class="btn btn-danger btn-sm delete-row"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#Lokasi').change(function(e) {
                e.preventDefault();
                var lokasi = $('#Lokasi').val();
                if (lokasi == "INSITU") {
                    $('.QtyVal').attr('readonly', true);
                } else {
                    $('.QtyVal').attr('readonly', false);
                }
            });
        });
        document.getElementById('add-row').addEventListener('click', function() {
            var table = document.getElementById('instrument-table').getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cells = [
                '<select name="InstrumenId[]" class="multi-select">@foreach ($instrumen as $inst)<option value="{{ $inst->id }}">{{ $inst->Nama }}</option>@endforeach',
                '<input type="text" name="Merk[]" class="form-control" placeholder="Merk">',
                '<input type="text" name="Type[]" class="form-control" placeholder="Type">',
                '<input type="text" name="SerialNumber[]" class="form-control" placeholder="Serial Number">',
                '<input type="text" name="Qty[]" value="1" class="form-control" placeholder="Qty">',
                '<input type="text" name="Deskripsi[]" class="form-control" placeholder="Deskripsi"><input type="hidden" name="Tambahan[]" value="YA">',

                '<button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>'
            ];

            cells.forEach(function(cellContent) {
                var cell = newRow.insertCell();
                cell.innerHTML = cellContent;
            });
            $(".multi-select").select2();
            addDeleteRowEventListener(newRow.querySelector('.delete-row'));
        });

        function addDeleteRowEventListener(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                var table = document.getElementById('instrument-table').getElementsByTagName('tbody')[0];
                if (table.rows.length > 1) {
                    row.parentNode.removeChild(row);
                }
            });
        }
        var existingDeleteButtons = document.querySelectorAll('.delete-row');
        existingDeleteButtons.forEach(addDeleteRowEventListener);
    </script>
@endsection
