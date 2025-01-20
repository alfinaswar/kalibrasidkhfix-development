@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <button type="button" class="btn btn-primary me-3 btn-sm" data-bs-toggle="modal" data-bs-target="#kajiUlangModal">
            <i class="fas fa-plus me-2"></i>Buat PO
        </button>
        <a href="{{ route('po.po-tanpa-qo') }}" class="btn btn-secondary me-3 btn-sm">
            <i class="fas fa-plus me-2"></i>Tanpa Quotation
        </a>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Purchase Order</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nomor PO</th>
                                    <th>Customer</th>
                                    <th>Tanggal PO</th>
                                    <th>Approval</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
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


    </div>
    </div>
    <div class="modal fade" id="kajiUlangModal" tabindex="-1" aria-labelledby="kajiUlangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajiUlangModalLabel">Data Quotation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="example4" class="display" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nomor Quotation</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataQuotation as $key => $qt)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $qt->KodeQuotation }}</td>
                                    <td>{{ $qt->getCustomer->Name }}</td>
                                    <td>{{ $qt->Tanggal }}</td>
                                    <td class="text-center">
                                        @if ($qt->Approve == 'Y')
                                            <span class="badge light badge-success text-dark"><i
                                                    class="fa fa-circle text-success me-1"></i>DISETUJUI</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="{{ route('po.form-po', $qt->id) }}"
                                            class="btn btn-primary">Buat Po <i class="fas fa-arrow-right"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
                    <form action="{{ route('po.approval') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <h3 class="text-center">Apakah Anda ingin menerima atau menolak pengajuan ini?</h3>
                            <select class="default-select form-control wide" id="Approve" name="Approve"
                                onchange="toggleCatatan()">
                                <option>Pilih</option>
                                <option value="Y">Terima Purchase Order</option>
                                <option value="N">Tolak Purchase Order</option>
                            </select>
                        </div>
                        <div class="mb-3" id="catatanContainer" style="display: none;">
                            <input type="text" class="form-control" name="Catatan" placeholder="Catatan Ditolak">
                            <input type="hidden" class="form-control" name="id" id="idQuotation"
                                placeholder="Catatan Ditolak">
                        </div>
                        <div class="modal-footer align-center">
                            <div class="container text-center">
                                <button type="submit" class="btn btn-block btn-primary">Update</button>
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
                    icon: "success"
                });
            }, 1000);
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
            $('body').on('click', '.showModal', function() {
                var id = $(this).data('id');
                $('#idQuotation').val(id);;
                $('#basicModal').modal('show');
            });
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus PO',
                    text: "Anda Ingin Menghapus Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('po.destroy', ':id') }}'.replace(':id',
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
                    serverSide: true,
                    ajax: "{{ route('po.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'KodePo',
                            name: 'KodePo'
                        },
                        {
                            data: 'get_customer.Name',
                            name: 'get_customer.Name'
                        },
                        {
                            data: 'TanggalPo',
                            name: 'TanggalPo'
                        },
                        {
                            data: 'Approve',
                            name: 'Approve'
                        },

                        {
                            data: 'Stat',
                            name: 'Stat'
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
