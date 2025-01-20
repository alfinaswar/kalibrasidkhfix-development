@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <a href="#" class="btn btn-primary me-3 btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAkomodasiModal">
            <i class="fas fa-plus me-2"></i>Tambah Akomodasi
        </a>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Akomodasi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" width="100%">
                            <thead class="">
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="50%">Nama</th>
                                    <th width="10%">Tarif</th>
                                    <th width="10%">N/A</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Akomodasi -->
    <div class="modal fade" id="tambahAkomodasiModal" tabindex="-1" aria-labelledby="tambahAkomodasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAkomodasiModalLabel">Tambah Data Akomodasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahAkomodasi" method="POST" action="{{ route('akomodasi.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="Nama" class="form-label">Nama Akomodasi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('Nama') is-invalid @enderror"
                                    id="Nama" name="Nama" placeholder="Masukkan nama akomodasi" required>
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tarif</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" name="Tarif"
                                        class="form-control @error('Tarif') is-invalid @enderror" placeholder="Tarif"
                                        onkeyup="this.value=formatRupiah(this.value)" value="{{ old('Tarif') }}" required>
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
                            <div class="col-md-6 mb-3">
                                <label for="NA" class="form-label">N/A</label>
                                <select class="form-select @error('NA') is-invalid @enderror" id="NA" name="NA"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                                @error('NA')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit Akomodasi -->
    <div class="modal fade" id="editAkomodasiModal" tabindex="-1" aria-labelledby="editAkomodasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAkomodasiModalLabel">Edit Data Akomodasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditAkomodasi" method="POST" action="{{ route('akomodasi.update', ['id' => ':id']) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_Nama" class="form-label">Nama Akomodasi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('Nama') is-invalid @enderror"
                                    id="edit_Nama" name="Nama" placeholder="Masukkan nama akomodasi" required>
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tarif</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" name="Tarif" id="edit_Tarif"
                                        class="form-control @error('Tarif') is-invalid @enderror" placeholder="Tarif"
                                        onkeyup="this.value=formatRupiah(this.value)" required>
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

                            <div class="col-md-6 mb-3">
                                <label for="edit_NA" class="form-label">N/A</label>
                                <select class="form-select @error('NA') is-invalid @enderror" id="edit_NA"
                                    name="NA" required>
                                    <option value="">Pilih</option>
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                                @error('NA')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <script>
            setTimeout(function() {
                swal.fire({
                    title: "{{ __('Success!') }}",
                    text: "{!! \Session::get('success') !!}",
                    icon: "success",
                    type: "success"
                });
            }, 1000);
        </script>
    @endif
    <script>
        function openAkomodasiModal() {
            var modal = new bootstrap.Modal(document.getElementById('tambahAkomodasiModal'));
            modal.show();
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa) + (sisa ? '.' : '') + split[0].substr(sisa).replace(/\D/g, '').replace(
                    /\B(?=(\d{3})+(?!\d))/g, ".");
            return prefix == undefined ? rupiah : (rupiah ? rupiah + prefix : '');
        }
        $(document).ready(function() {
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Data',
                    text: "Anda Ingin Menghapus Data?",
                    icon: 'Peringatan',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('akomodasi.destroy', ':id') }}'.replace(':id',
                                id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Dihapus',
                                    'Data Berhasil Dihapus',
                                    'success'
                                );

                                $('#example').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Failed!',
                                    'Error',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('akomodasi.edit', ':id') }}'.replace(':id',
                        id),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.id);
                        $('#edit_Nama').val(response.Nama);
                        $('#edit_Tarif').val(response.Tarif);
                        $('#edit_NA').val(response.NA);
                        $('#editAkomodasiModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Failed!',
                            'Error fetching data',
                            'error'
                        );
                        console.log(xhr.responseText);
                    }
                });
            });
            $('#formEditAkomodasi').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '{{ route('akomodasi.update', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire(
                            'Updated',
                            'Data Berhasil Diupdate',
                            'success'
                        );

                        $('#editAkomodasiModal').modal('hide');
                        $('#example').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Failed!',
                            'Error updating data',
                            'error'
                        );
                        console.log(xhr.responseText);
                    }
                });
            });
            var dataTable = function() {
                var table = $('#example');
                table.DataTable({
                    responsive: true,
                    serverSide: true,
                    bDestroy: true,
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        }
                    },
                    serverSide: true,
                    ajax: "{{ route('akomodasi.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'Nama',
                            name: 'Nama'
                        },
                        {
                            data: 'Tarif',
                            name: 'Tarif'
                        },
                        {
                            data: 'NA',
                            name: 'NA'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            };
            dataTable();
        });
    </script>
@endsection
