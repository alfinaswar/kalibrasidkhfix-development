@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Master Parameter Keselamatan Listrik</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Kembali</button>
            </div>
            <div class="card-body">
                <div class="basic-form mb-4">
                    <form action="{{ route('keselamatanlistrik.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Parameter</label>
                                <input type="text" name="Parameter"
                                    class="form-control @error('Parameter') is-invalid @enderror" placeholder="Parameter"
                                    value="{{ old('Parameter') }}">
                                @error('Parameter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Parameter Dalam Bahasa Inggris</label>
                                <input type="text" name="ParameterEng"
                                    class="form-control @error('ParameterEng') is-invalid @enderror"
                                    placeholder="Parameter Dalam Bahasa Inggris" value="{{ old('ParameterEng') }}">
                                @error('ParameterEng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Satuan</label>
                                <input type="text" name="Satuan"
                                    class="form-control @error('Satuan') is-invalid @enderror" placeholder="Satuan"
                                    value="{{ old('Satuan') }}">
                                @error('Satuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Ambang Batas</label>
                                <input type="text" name="AmbangBatas"
                                    class="form-control @error('AmbangBatas') is-invalid @enderror"
                                    placeholder="Ambang Batas" value="{{ old('AmbangBatas') }}">
                                @error('AmbangBatas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-md btn-primary btn-block">Tambah</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Parameter</th>
                                <th>Parameter Eng</th>
                                <th>Satuan</th>
                                <th>Ambang Batas</th>
                                <th>Dibuat Oleh</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
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
                    ajax: "{{ route('keselamatanlistrik.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'Parameter',
                            name: 'Parameter'
                        },
                        {
                            data: 'ParameterEng',
                            name: 'ParameterEng'
                        },
                        {
                            data: 'Satuan',
                            name: 'Satuan'
                        },
                        {
                            data: 'AmbangBatas',
                            name: 'AmbangBatas'
                        },
                        {
                            data: 'get_user.name',
                            name: 'get_user.name'
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
                            url: '{{ route('keselamatanlistrik.destroy', ':id') }}'
                                .replace(':id',
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
                                    'Data Sedang Digunakan',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                title: "{{ __('Success!') }}",
                text: "{!! \Session::get('success') !!}",
                icon: "success"
            });
        </script>
    @endif
@endsection
