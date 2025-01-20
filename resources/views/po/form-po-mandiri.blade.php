@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Buat Purchase Order</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('po.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <select id="single-select" name="CustomerId"
                                    class="form-control-lg @error('CustomerId') is-invalid @enderror">
                                    <option>Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}">
                                            {{ $cust->Name }}</option>
                                    @endforeach
                                </select>
                                @error('CustomerId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal PO</label>
                                <input type="date" name="TanggalPo" value="{{ now()->format('Y-m-d') }}"
                                    class="form-control  @error('TanggalPo') is-invalid @enderror"
                                    placeholder="{{ now() }}" id="mdate">
                                @error('TanggalPo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" class="form-control @error('Status') is-invalid @enderror">
                                    <option value="AKTIF">AKTIF</option>
                                    <option value="TIDAK">TIDAK AKTIF</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4 fw-bold">
                            <u>
                                <h3>DETAIL INSTRUMEN</h3>
                            </u>
                        </div>
                        <div class="text-end mt-4" style="position: relative;">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle" id="instrument-table">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nama Alat</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="multi-select" name="InstrumenId[]" onchange="getHarga(this)">
                                                <option>Pilih Instrumen</option>
                                                @foreach ($instrumen as $inst)
                                                    <option value="{{ $inst->id }}">
                                                        {{ $inst->Nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="Qty[]" class="form-control qty"
                                                placeholder="Jumlah Alat" value="1"></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="text" name="Harga[]" class="form-control text-end harga"
                                                    placeholder="Harga">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="text" name="SubTotal[]"
                                                    class="form-control text-end subtotal" placeholder="Sub Total" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- New Rows will be added here -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Sub Total</td>
                                        <td><input type="text" name="subtotal" class="form-control text-end"
                                                id="subtotal" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Diskon</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="TipeDiskon" id="TipeDiskon" class="form-control">
                                                        <option value="">Pilih Tipe Diskon</option>
                                                        <option value="flat">Flat</option>
                                                        <option value="persentase">Persentase</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-end" id="TotalDiskon"
                                                        name="TotalDiskon" placeholder="Nominal Diskon">
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Qty</td>
                                        <td><input type="text" class="form-control text-end" name="totalQty" readonly
                                                id="totalQty"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td><input type="text" class="form-control text-end" id="Total"
                                                name="Total" readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
                <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        for (let i = 1; i <= 4; i++) {
            ClassicEditor
                .create(document.querySelector(`#texteditor${i}`))
                .catch(error => {
                    console.error(error);
                });
        }

        function getHarga(selectElement) {
            const instrumenId = selectElement.value;
            // alert(instrumenId)
            $.ajax({
                url: `{{ route('instrument.getHarga', ':instrumenId') }}`.replace(':instrumenId', instrumenId),
                type: 'GET',
                success: function(data) {
                    const row = selectElement.closest('tr');
                    const hargaInput = row.querySelector('.harga');
                    const qtyInput = row.querySelector('.qty');
                    const subtotalInput = row.querySelector('.subtotal');
                    hargaInput.value = parseInt(data.harga).toLocaleString('id-ID');
                    const qty = parseFloat(qtyInput.value.replace(/\D/g, '') || 0);
                    const subTotal = qty * data.harga;
                    subtotalInput.value = subTotal.toLocaleString('id-ID');

                    hitung();
                },
                error: function(error) {
                    console.error('Error fetching harga:', error);
                }
            });
        }

        // Attach event listener
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select[name="InstrumenId[]"]').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    getHarga(selectElement);
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            function formatNumber(input) {
                const value = input.value.replace(/\D/g, '');
                input.value = parseInt(value).toLocaleString('id-ID');
            }
            document.querySelectorAll('.harga').forEach(function(input) {
                formatNumber(input);
                input.addEventListener('input', function() {
                    formatNumber(input);
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            function hitung() {
                let totalSubTotal = 0;
                let totalQty = 0;
                $(".multi-select").select2();
                document.querySelectorAll('#instrument-table tbody tr').forEach(function(row) {
                    const qty = parseFloat(row.querySelector('.qty').value.replace(/,/g, '') || 0);
                    const harga = parseFloat(row.querySelector('.harga').value.replace(/\./g, '').replace(
                        /,/g, '') || 0);
                    const subTotal = qty * harga;

                    row.querySelector('.subtotal').value = subTotal.toLocaleString('id-ID', {
                        // minimumFractionDigits: 3
                    });

                    totalSubTotal += subTotal;
                    totalQty += qty;
                });

                document.getElementById('subtotal').value = totalSubTotal.toLocaleString('id-ID', {
                    // minimumFractionDigits: 3
                });
                document.getElementById('totalQty').value = totalQty.toLocaleString('id-ID');
                document.getElementById('Total').value = totalSubTotal.toLocaleString('id-ID');
            }
            document.querySelectorAll('.qty, .harga').forEach(function(element) {
                element.addEventListener('input', hitung);
            });
            document.getElementById('add-row').addEventListener('click', function() {
                const newRow = `
                <tr>
                    <td>
                      <select class="multi-select" name="InstrumenId[]" onchange="getHarga(this)">
                                                     <option>Pilih Instrumen</option>
                                                    @foreach ($instrumen as $inst)
                                                        <option value="{{ $inst->id }}">
                                                            {{ $inst->Nama }}</option>
                                                    @endforeach
                                                </select>
                    </td>
                    <td><input type="text" name="Qty[]" class="form-control qty" placeholder="Jumlah Alat" value="1"></td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" name="Harga[]" class="form-control text-end harga" placeholder="Harga">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" name="SubTotal[]" class="form-control text-end subtotal" placeholder="Sub Total" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </td>
                     <td>
            <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
        </td>
                </tr>
            `;

                const tbody = document.querySelector('#instrument-table tbody');
                const subtotalRow = document.querySelector('#instrument-table tfoot');
                tbody.insertAdjacentHTML('beforeend', newRow);

                tbody.lastElementChild.querySelectorAll('.qty, .harga').forEach(function(element) {
                    element.addEventListener('input', hitung);
                });

                tbody.lastElementChild.querySelector('.delete-row').addEventListener('click', function() {
                    this.closest('tr').remove();
                    hitung();
                });

                hitung();
            });

            // hitung();
        });
        $(document).ready(function() {
            $(".multi-select").select2();

            function getHarga(selectElement) {
                const instrumenId = selectElement.value;
                $.ajax({
                    url: `{{ route('instrument.getHarga', ':instrumenId') }}`.replace(':instrumenId',
                        instrumenId),
                    type: 'GET',
                    success: function(data) {
                        const row = selectElement.closest('tr');
                        const hargaInput = row.querySelector('.harga');
                        const qtyInput = row.querySelector('.qty');
                        const subtotalInput = row.querySelector('.subtotal');
                        hargaInput.value = parseInt(data.harga).toLocaleString('id-ID');
                        const qty = parseFloat(qtyInput.value.replace(/\D/g, '') || 0);
                        const subTotal = qty * data.harga;
                        subtotalInput.value = subTotal.toLocaleString('id-ID');

                        recalculateTotals();
                    },
                    error: function(error) {
                        console.error('Error fetching harga:', error);
                    }
                });
            }

            $('#TotalDiskon').on('input', function() {
                var DiskonTipe = document.getElementById("TipeDiskon").value;
                var SubTotal = parseFloat(document.getElementById("subtotal").value.replace(/\D/g, '') ||
                    0);
                let diskon1 = $(this).val().replace(/\D/g, '');

                if (DiskonTipe !== "persentase") {
                    diskon1 = parseInt(diskon1).toLocaleString('id-ID');
                    $(this).val(diskon1);
                }

                $('#Diskon').val(diskon1);

                if (DiskonTipe == "persentase") {
                    var diskonNominal = SubTotal * (parseFloat(diskon1.replace(/\D/g, '')) / 100);
                } else {
                    var diskonNominal = parseFloat(diskon1.replace(/\D/g, ''));
                }

                var totalSetelahDiskon = SubTotal - diskonNominal;
                $('#Total').val(totalSetelahDiskon.toLocaleString('id-ID'));
            });

            $('#TipeDiskon').on('change', function() {
                $('#TotalDiskon').trigger('input');
            });


        });
    </script>
@endsection
