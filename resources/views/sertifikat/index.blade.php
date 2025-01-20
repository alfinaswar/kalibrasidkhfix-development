@extends('layouts.app')

@section('content')
    <style>
        #example .ket-success {
            background-color: #d4edda;
            color: #155724;
        }

        #example .ket-danger {
            background-color: #cfe2ff;
            color: #ec0808;
        }

        #example .ket-warning {
            background-color: #fff3cd;
            color: #664d03;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Sertifikat</h4>
                    <!-- Filter Inputs -->

                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label>
                                Cari Berdasarkan Nama Instrumen
                            </label>
                            <select class="multi-select" name="nama_alat" id="filter-nama-alat">

                                <option value="">Semua Data Instrumen</option>
                                @foreach ($instrumen as $inst)
                                    <option value="{{ $inst->Nama }}">
                                        {{ $inst->Nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>
                                Cari Berdasarkan Status Sertifikat
                            </label>
                            <select id="filter-status-sertifikat" class="form-control" name="status_sertifikat">
                                <option value="">Filter Status Sertifikat</option>
                                <option value="N">Draft</option>
                                <option value="Y">Telah Terbit</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>
                                Cari Data
                            </label>
                            <button id="filter-apply" class="btn btn-primary">Apply Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Sertifikat</th>
                                    <th>No Order</th>
                                    <th>Alat</th>
                                    <th>Customer</th>
                                    <th>Verif Teknis</th>
                                    <th>Valid Mutu</th>
                                    <th>Approval</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Approval --}}
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('job.approval') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <h3 class="text-center">Apakah Anda ingin menerima atau menolak pengajuan ini?</h3>
                            <select class="default-select form-control wide" id="Approve" name="Approve"
                                onchange="toggleCatatan()">
                                <option>Pilih</option>
                                <option value="Y">Setujui Sertifikat</option>
                                <option value="N">Tolak Sertifikat</option>
                            </select>
                        </div>
                        <div class="mb-3" id="catatanContainer" style="display: none;">
                            <input type="text" class="form-control" name="Catatan" placeholder="Catatan Ditolak">
                            <input type="hidden" class="form-control" name="id" id="idQuotation"
                                placeholder="Catatan Ditolak">
                        </div>
                        <div class="modal-footer align-center">

                            <button type="submit" class="btn btn-block btn-primary">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Verif --}}
    <div class="modal fade" id="ModalVerif">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Teknis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>
                <div class="modal-body">
                    <form action="{{ route('job.StoreVerif') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <h3 class="text-center">Nomor Sertifikat</h3>
                                <input type="text" name="NoSertifikat" id="NoSertifikat" class="form-control" disabled>
                                <input type="hidden" name="idSertifikat" id="idSertifikat" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="text-center">Kondisi Lingkungan</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Verifikasi1" class="form-check-input lg">
                                        Sesuai</label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Verifikasi1"
                                            class="form-check-input"> Tidak
                                        Sesuai</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="text-center">Keselamatan Listrik</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3"><input type="radio" value="SESUAI"
                                            name="Verifikasi2" class="form-check-input lg"> Sesuai</label>
                                    <label class="radio-inline me-3 radio-lg"><input type="radio" value="TIDAKSESUAI"
                                            name="Verifikasi2" class="form-check-input"> Tidak
                                        Sesuai</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="text-center">Kinerja Alat</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3"><input type="radio" value="SESUAI"
                                            name="Verifikasi3" class="form-check-input lg"> Sesuai</label>
                                    <label class="radio-inline me-3 radio-lg"><input type="radio" value="TIDAKSESUAI"
                                            name="Verifikasi3" class="form-check-input"> Tidak
                                        Sesuai</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="text-center">Hasil Kalibrasi</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3"><input type="radio" value="SESUAI"
                                            name="Verifikasi4" class="form-check-input lg"> Sesuai</label>
                                    <label class="radio-inline me-3 radio-lg"><input type="radio" value="TIDAKSESUAI"
                                            name="Verifikasi4" class="form-check-input"> Tidak
                                        Sesuai</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="text-center">Ketidakpastian Pengukuran</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3"><input type="radio" value="SESUAI"
                                            name="Verifikasi5" class="form-check-input lg"> Sesuai</label>
                                    <label class="radio-inline me-3 radio-lg"><input type="radio" value="TIDAKSESUAI"
                                            name="Verifikasi5" class="form-check-input"> Tidak
                                        Sesuai</label>
                                </div>
                            </div>


                            <div class="mb-3 mb-0 d-flex align-items-center">
                                <input type="checkbox" name="check" id="checkbox" class="form-check"
                                    style="transform: scale(1.5);">
                                <label class="text-center checkbox-label" style="margin-left: 10px;">Checklist Sesuai
                                    Semua</label>
                            </div>


                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-block btn-primary">Simpan</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Valid --}}
    <div class="modal fade" id="ModalMutu">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Validasi Mutu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('job.StoreMutu') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <h3 class="">Nomor Sertifikat</h3>
                                <input type="text" name="NoSertifikat" id="NoSertifikatMutu" class="form-control"
                                    disabled>
                                <input type="hidden" name="idSertifikat" id="idSertifikatMutu" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="">Identifikasi Alat</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi1"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi1"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Tanggal Kalibrasi</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi2"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi2"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Hasil Kalibrasi</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi3"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi3"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Ketidakpastian Pengukuran</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi4"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi4"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Tanda Tangan Teknis</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi5"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi5"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Kelengkapan Isi Sertifikat Kalibrasi</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi6"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi6"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="">Catatan Kalibrasi Yang Lengkap dan Akurasi</label>
                                <div class="mb-3 mb-0">
                                    <label class="radio-inline me-3">
                                        <input type="radio" value="SESUAI" name="Validasi7"
                                            class="form-check-input lg"> Sesuai
                                    </label>
                                    <label class="radio-inline me-3 radio-lg">
                                        <input type="radio" value="TIDAKSESUAI" name="Validasi7"
                                            class="form-check-input"> Tidak Sesuai
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 mb-0 d-flex align-items-center">
                                <input type="checkbox" name="check" id="checkboxmutu" class="form-check"
                                    style="transform: scale(1.5);">
                                <label class="text-center ms-2">Checklist Sesuai Semua</label>
                            </div>
                        </div>

                        <div class="modal-footer align-center">
                            <div class="container text-center">
                                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <script>
            setTimeout(function() {
                swal.fire({
                    title: "{{ __('Success!') }}",
                    text: "{!! \Session::get('success') !!}",
                    type: "success",
                    icon: "success"
                });
            }, 1200);
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            setTimeout(function() {
                swal.fire({
                    title: "{{ __('Error!') }}",
                    text: "{!! \Session::get('error') !!}",
                    type: "error",
                    icon: "error"
                });
            }, 1200);
        </script>
    @endif
    <script>
        function toggleCatatan() {
            var select = document.getElementById("Approve");
            console.log(select);

            var catatanContainer = document.getElementById("catatanContainer");

            if (select.value === "N") {
                catatanContainer.style.display = "block";
            } else {
                catatanContainer.style.display = "none";
            }
        }
        $(document).ready(function() {
            document.getElementById('checkbox').addEventListener('change', function() {
                const isChecked = this.checked;
                const radioButtons = document.querySelectorAll('input[type="radio"][value="SESUAI"]');

                radioButtons.forEach(radio => {
                    if (isChecked) {
                        radio.checked = true;
                    } else {
                        radio.checked = false;
                    }
                });
            });
            document.getElementById('checkboxmutu').addEventListener('change', function() {
                const isChecked = this.checked;
                const radioButtons = document.querySelectorAll('input[type="radio"][value="SESUAI"]');

                radioButtons.forEach(radio => {
                    if (isChecked) {
                        radio.checked = true;
                    } else {
                        radio.checked = false;
                    }
                });
            });
            $('body').on('click', '.showModal', function() {
                var id = $(this).data('id');


                $('#idQuotation').val(id);;
                $('#basicModal').modal('show');
            });
            $('body').on('click', '.ModalVerif', function() {
                var id = $(this).data('id');
                var NoSertifikat = $(this).data('nosert');
                $('#NoSertifikat').val(NoSertifikat);
                $('#idSertifikat').val(id);
                $.ajax({
                    type: "GET",
                    url: '{{ route('job.Verif', ':id') }}'.replace(':id', id),
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {

                    }
                });
                $('#ModalVerif').modal('show');
            });
            $('body').on('click', '.ModalMutu', function() {
                var id = $(this).data('id');
                var NoSertifikat = $(this).data('nosert');
                $('#NoSertifikatMutu').val(NoSertifikat);
                $('#idSertifikatMutu').val(id);
                $.ajax({
                    type: "GET",
                    url: '{{ route('job.Verif', ':id') }}'.replace(':id', id),
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {

                    }
                });
                $('#ModalMutu').modal('show');
            });
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
                            url: '{{ route('spk.destroy', ':id') }}'.replace(':id',
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
                    ajax: {
                        url: "{{ route('job.index') }}",
                        data: function(d) {
                            d.nama_alat = $('#filter-nama-alat').val();
                            d.status_sertifikat = $('#filter-status-sertifikat').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'SertifikatNumber',
                            name: 'SertifikatNumber'
                        },
                        {
                            data: 'OrderNumber',
                            name: 'OrderNumber'
                        },
                        {
                            data: 'get_nama_alat.Nama',
                            name: 'get_nama_alat.Nama'
                        },
                        {
                            data: 'get_customer.Name',
                            name: 'get_customer.Name'
                        },
                        {
                            data: 'Verfifteknis',
                            name: 'Verfifteknis'
                        },
                        {
                            data: 'Validmutu',
                            name: 'Validmutu'
                        },
                        {
                            data: 'Approve',
                            name: 'Approve'
                        },
                        {
                            data: 'statsertifikat',
                            name: 'statsertifikat'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    createdRow: function(row, data, dataIndex) {

                        if (data.TanggalPelaksanaan && data.TanggalPelaksanaan.trim() !== '') {
                            $(row).addClass('ket-success');
                        } else {
                            $(row).addClass('ket-danger');
                        }
                    }
                });
            };

            dataTable();

            $('#filter-apply').click(function() {
                $('#example').DataTable().ajax.reload();
            });
        });
    </script>
@endsection
