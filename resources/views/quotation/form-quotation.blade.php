@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Quotation</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" class="form-control @error('Status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="DRAFT" selected>Draft</option>
                                    <option value="DISETUJUI">Disetujui</option>
                                    <option value="DITOLAK">Tidak Disetujui</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Perihal</label>
                                <input type="text" name="Perihal" class="form-control" placeholder="Isi Perihal">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Lampiran</label>
                                <input type="text" name="Lampiran" class="form-control" placeholder="Lampiran">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Header</label>
                                <textarea name="Header" id="texteditor3" class="form-control" placeholder="Header Quotation">
            <p>Dengan Hormat,</p>
                                    <p>Semoga Bpk/ Ibu selalu dalam keadaan sehat dan sukses menjalankan aktivitas sehari-hari.</p>
            <p>PT Digital Kalibrasi Hebat adalah institusi pengujian dan kalibrasi alat kesehatan yang telah memiliki ijin operasional dengan nomor 09092200348530001. Sehubungan dengan rencana pengujian dan kalibrasi alat kesehatan di {{ $data->getCustomer->Kategori }} {{ $data->getCustomer->Name }}, bersama ini kami sampaikan penawaran harga mengenai pengujian dan kalibrasi alat kesehatan sebagai berikut:</p></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="Deskripsi" id="texteditor4" class="form-control" placeholder="Deskripsi">  <div class="section">
            <p>Kondisi Penawaran Harga:</p>
            <ul>
                <li>PT. Digital Kalibrasi Hebat tidak bertanggung jawab pada kerusakan semua alat kesehatan yang diuji atau dikalibrasi.</li>
                <li>Tidak termasuk service dan penggantian Spare Part.</li>
                <li>Schedule Pelaksanaan Kalibrasi akan dikonfirmasi selanjutnya.</li>
                <li>Pembayaran DP awal 30%, Pelunasan Setelah Penyerahan Sertifikat dan Terbit Sertifikat ASPAK</li>
                <li>Harga dapat berubah sewaktu – waktu.</li>
            </ul>
        </div>

        <div class="section">
            <p>Cara Pembayaran:</p>
            <p>Pembayaran melalui transfer ke rekening Bank Mandiri a/n PT Digital Kalibrasi Hebat No. 1080024737729.</p>
            <p>Jika menggunakan SPK / PO dengan Term Of Payment (TOP):</p>
            <ul>
                <li>TOP (Term Of Payment) 30 hari setelah tagihan.</li>
                <li>Sertifikat Kalibrasi diberikan jika sudah dilakukan pelunasan.</li>
            </ul>
        </div>

        <div class="section contact">
            <p>Untuk memudahkan koordinasi terkait penawaran ini, kami siap dihubungi dengan PIC:</p>
            <p>Samuel Clinton +62 811-760-5052</p>
        </div>

        <p>Demikian penawaran ini kami sampaikan, besar harapan kerjasama ini dapat terwujud. Untuk perhatian dan kerjasama yang baik diucapkan terima kasih.</p></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('Tanggal') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" name="Tanggal" value="{{ now()->format('Y-m-d') }}"
                                    id="mdate">
                                @error('Tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control @error('DueDate') is-invalid @enderror"
                                    placeholder="Tanggal DueDate" name="DueDate" value="{{ now()->format('Y-m-d') }}" id="mdate">
                                @error('DueDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="text-center mt-4">
                            <u>
                                <h3>DETAIL INSTRUMEN</h3>
                            </u>
                        </div>
                        <div class="text-end mt-4" style="position: relative;">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle" id="instrument-table"
                                width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col" width="35%">Nama Alat</th>
                                        <th scope="col" width="5%">Jumlah</th>
                                        <th scope="col" width="25%">Harga</th>
                                        <th scope="col" width="25%">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Existing Rows -->
                                    @foreach ($GetKajiUlang as $item)
                                        <tr>
                                            <td>
                                                <select class="form-control-lg multi-select" name="InstrumenId[]"
                                                    onchange="getHarga(this)">
                                                    @foreach ($instrumen as $inst)
                                                        <option value="{{ $inst->id }}"
                                                            @if ($inst->id == $item->InstrumenId) selected @endif>
                                                            {{ $inst->Nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="Qty[]" class="form-control qty"
                                                    placeholder="Jumlah Alat" value="{{ $item->Qty }}"></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="Harga[]" class="form-control text-end harga"
                                                        placeholder="Harga" value="{{ $item->getInstrumen->Tarif }}">
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
                                                        class="form-control text-end subtotal" placeholder="Sub Total"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Qty</td>
                                        <td><input type="text" class="form-control text-end" name="totalQty" readonly
                                                id="totalQty"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Sub Total Instrumen</td>
                                        <td><input type="text" name="subtotal" class="form-control text-end"
                                                id="subtotal" readonly></td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                        <div class="text-end mt-4" style="position: relative;">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row-akomodasi">Tambah
                                Baris</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle" id="akomodasi-table"
                                width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col" width="35%">Nama Akomodasi</th>
                                        <th scope="col" width="5%">Jumlah</th>
                                        <th scope="col" width="25%">Harga</th>
                                        <th scope="col" width="25%">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                            <select class="form-control-lg multi-select" name="AkomodasiId[]"
                                                onchange="getHargaAkomodasi(this)">
                                                <option value="">Pilih Akomodasi</option>
                                                @foreach ($Akomodasi as $akom)
                                                    <option value="{{ $akom->id }}">
                                                        {{ $akom->Nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="QtyAkomodasi[]" class="form-control qtyAkomodasi"
                                                placeholder="Jumlah Akomodasi" value="1">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="text" name="HargaAkomodasi[]"
                                                    class="form-control text-end hargaAkomodasi" placeholder="Harga">
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
                                                <input type="text" name="SubTotalAkomodasi[]"
                                                    class="form-control text-end subtotalAkomodasi"
                                                    placeholder="Sub Total" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Qty</td>
                                        <td><input type="text" class="form-control text-end" name="totalQtyAkomodasi"
                                                readonly id="totalQtyAkomodasi"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Sub Total Akomodasi</td>
                                        <td><input type="text" name="subtotalAkomodasi" class="form-control text-end"
                                                id="subtotalAkomodasi" readonly></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Sub Total (Instrumen & Akomodasi)</td>
                                        <td><input type="text" name="subtotalGabungan" class="form-control text-end"
                                                id="subtotalGabungan" readonly></td>
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
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td><input type="text" class="form-control text-end" id="Total"
                                                name="Total" readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
                <input type="hidden" name="SerahTerimaId" value="{{ $data->id }}">
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

                    recalculateTotals();
                },
                error: function(error) {
                    console.error('Error fetching harga:', error);
                }
            });
        }

        function getHargaAkomodasi(selectElement) {
            const akomodasiId = selectElement.value;
            $.ajax({
                url: `{{ route('akomodasi.getTarif', ':akomodasiId') }}`.replace(':akomodasiId', akomodasiId),
                type: 'GET',
                success: function(data) {
                    const row = selectElement.closest('tr');
                    const hargaInput = row.querySelector('.hargaAkomodasi');
                    const qtyInput = row.querySelector('.qtyAkomodasi');
                    const subtotalInput = row.querySelector('.subtotalAkomodasi');
                    hargaInput.value = parseInt(data.Tarif).toLocaleString('id-ID');
                    const qty = parseFloat(qtyInput.value.replace(/\D/g, '') || 0);
                    const subTotal = qty * data.Tarif;
                    subtotalInput.value = subTotal.toLocaleString('id-ID');

                },
                error: function(error) {
                    console.error('Error fetching harga akomodasi:', error);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select[name="InstrumenId[]"], select[name="AkomodasiId[]"]').forEach(
                function(selectElement) {
                    selectElement.addEventListener('change', function() {
                        if (this.name === 'InstrumenId[]') {
                            getHarga(this);
                        } else if (this.name === 'AkomodasiId[]') {
                            getHargaAkomodasi(this);
                        }
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
                    formatNumber(this);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            function recalculateTotals() {
                let totalSubTotalInstrumen = 0;
                let totalSubTotalAkomodasi = 0;
                let totalQtyInstrumen = 0;
                let totalQtyAkomodasi = 0;

                document.querySelectorAll('#instrument-table tbody tr').forEach(function(row) {
                    const qty = parseFloat(row.querySelector('.qty').value.replace(/,/g, '') || 0);
                    const harga = parseFloat(row.querySelector('.harga').value.replace(/\./g, '').replace(
                        /,/g, '') || 0);
                    const subTotal = qty * harga;

                    row.querySelector('.subtotal').value = subTotal.toLocaleString('id-ID');

                    totalSubTotalInstrumen += subTotal;
                    totalQtyInstrumen += qty;
                });
                document.querySelectorAll('#akomodasi-table tbody tr').forEach(function(row) {
                    const qty = parseFloat(row.querySelector('.qtyAkomodasi').value.replace(/,/g, '') || 0);
                    const harga = parseFloat(row.querySelector('.hargaAkomodasi').value.replace(/\./g, '')
                        .replace(/,/g, '') || 0);
                    const subTotal = qty * harga;

                    row.querySelector('.subtotalAkomodasi').value = subTotal.toLocaleString('id-ID');

                    totalSubTotalAkomodasi += subTotal;
                    totalQtyAkomodasi += qty;
                });
                const totalGabungan = totalSubTotalInstrumen + totalSubTotalAkomodasi;
                document.getElementById('subtotal').value = totalSubTotalInstrumen.toLocaleString('id-ID');
                document.getElementById('totalQty').value = totalQtyInstrumen.toLocaleString('id-ID');

                document.getElementById('subtotalAkomodasi').value = totalSubTotalAkomodasi.toLocaleString('id-ID');
                document.getElementById('totalQtyAkomodasi').value = totalQtyAkomodasi.toLocaleString('id-ID');

                document.getElementById('subtotalGabungan').value = totalGabungan.toLocaleString('id-ID');

                const tipeDiskon = document.getElementById('TipeDiskon').value;
                const totalDiskon = parseFloat(document.getElementById('TotalDiskon').value.replace(/\./g, '')
                    .replace(/,/g, '') || 0);
                let finalTotal = totalGabungan;

                if (tipeDiskon === 'flat') {
                    finalTotal -= totalDiskon;
                } else if (tipeDiskon === 'persentase') {
                    finalTotal -= (totalGabungan * (totalDiskon / 100));
                }

                document.getElementById('Total').value = finalTotal.toLocaleString('id-ID');
            }

            // function recalculateTotalsAkomodasi() {
            //     let totalSubTotal = 0;
            //     let totalQty = 0;

            //     document.querySelectorAll('#akomodasi-table tbody tr').forEach(function(row) {
            //         const qty = parseFloat(row.querySelector('.qtyAkomodasi').value.replace(/,/g, '') || 0);
            //         const harga = parseFloat(row.querySelector('.hargaAkomodasi').value.replace(/\./g, '')
            //             .replace(
            //                 /,/g, '') || 0);
            //         const subTotal = qty * harga;

            //         row.querySelector('.subtotalAkomodasi').value = subTotal.toLocaleString('id-ID');

            //         totalSubTotal += subTotal;
            //         totalQty += qty;
            //     });

            //     document.getElementById('subtotalAkomodasi').value = totalSubTotal.toLocaleString('id-ID');
            //     document.getElementById('totalQtyAkomodasi').value = totalQty.toLocaleString('id-ID');
            // }

            document.querySelectorAll('.qty, .harga').forEach(function(element) {
                element.addEventListener('input', recalculateTotals);
            });
            document.querySelectorAll('.qtyAkomodasi, .hargaAkomodasi').forEach(function(element) {
                element.addEventListener('input', recalculateTotals);
            });

            document.getElementById('add-row').addEventListener('click', function() {
                const newRow = `
                <tr>
                    <td>
                        <select class="multi-select" name="InstrumenId[]" onchange="getHarga(this)">
                            <option>Pilih Instrumen</option>
                            @foreach ($instrumen as $inst)
                                <option value="{{ $inst->id }}"
                                    @if ($inst->id == $item->InstrumenId) selected @endif>
                                    {{ $inst->Nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="Qty[]" class="form-control qty" placeholder="Jumlah Alat" value=""></td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" name="Harga[]" class="form-control text-end harga" placeholder="Harga" value="">
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
                        <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                `;

                const tbody = document.querySelector('#instrument-table tbody');
                tbody.insertAdjacentHTML('beforeend', newRow);

                const newSelect = tbody.lastElementChild.querySelector('select[name="InstrumenId[]"]');
                $(newSelect).select2();
                newSelect.addEventListener('change', function() {
                    getHarga(this);
                });

                tbody.lastElementChild.querySelectorAll('.qty, .harga').forEach(function(element) {
                    element.addEventListener('input', recalculateTotals);
                });

                const deleteButton = tbody.lastElementChild.querySelector('.delete-row');
                deleteButton.addEventListener('click', function() {
                    tbody.removeChild(this.closest('tr'));
                    recalculateTotals();
                });

                recalculateTotals();
            });
            document.getElementById('add-row-akomodasi').addEventListener('click', function() {
                const newRow = `
                 <tr>
                                        <td>
                                            <select class="form-control-lg multi-select" id="select2Akomodasi" name="AkomodasiId[]"
                                                onchange="getHargaAkomodasi(this)">
                                                @foreach ($Akomodasi as $akom)
                                                    <option value="{{ $akom->id }}">
                                                        {{ $akom->Nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="QtyAkomodasi[]" class="form-control qtyAkomodasi"
                                                placeholder="Jumlah Akomodasi"  value="1">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input type="text" name="HargaAkomodasi[]"
                                                    class="form-control text-end hargaAkomodasi" placeholder="Harga">
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
                                                <input type="text" name="SubTotalAkomodasi[]"
                                                    class="form-control text-end subtotalAkomodasi"
                                                    placeholder="Sub Total" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </td>
                                         <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row-akomodasi"><i class="fa fa-trash"></i></button>
                    </td>
                                    </tr>
                `;

                const tbody = document.querySelector('#akomodasi-table tbody');
                tbody.insertAdjacentHTML('beforeend', newRow);

                const newSelect = tbody.lastElementChild.querySelector('select[name="AkomodasiId[]"]');
                $(newSelect).select2();
                newSelect.addEventListener('change', function() {
                    recalculateTotals();
                    getHargaAkomodasi(this);
                });

                tbody.lastElementChild.querySelectorAll('.qtyAkomodasi, .hargaAkomodasi, #select2Akomodasi')
                    .forEach(function(
                        element) {
                        element.addEventListener('input', recalculateTotals);
                    });

                const deleteButton = tbody.lastElementChild.querySelector('.delete-row-akomodasi');
                deleteButton.addEventListener('click', function() {
                    tbody.removeChild(this.closest('tr'));
                    recalculateTotals();
                });

                recalculateTotals();
            });
            recalculateTotals();
        });

        $(document).ready(function() {
            $("#AkomodasiId").change(function() {
                var AkomodasiID = $(this).val();

                $.ajax({
                    url: `{{ route('akomodasi.getTarif', ':AkomodasiID') }}`.replace(
                        ':AkomodasiID', AkomodasiID),
                    type: 'GET',
                    success: function(data) {
                        var TarifInput = parseInt(data.Tarif).toLocaleString('id-ID');
                        $("#TarifAkomodasi").val(TarifInput);
                        var SubTotal = parseFloat($("#subtotal").val().replace(/\D/g, '') || 0);
                        var TarifAkomodasi = parseInt(data.Tarif);

                        var totalSetelahAkomodasi = SubTotal - TarifAkomodasi;
                        $('#Total').val(totalSetelahAkomodasi.toLocaleString('id-ID'));
                    },
                    error: function(error) {
                        console.error('Error fetching tarif:', error);
                    }
                });
            });

            $(".multi-select").select2();

            $('#Diskon').on('keyup', function() {
                let diskon = $(this).val();
                $('#TotalDiskon').val(diskon);
            });

            $('#TotalDiskon').on('input', function() {
                var DiskonTipe = $("#TipeDiskon").val();
                var SubTotal = parseFloat($("#subtotalGabungan").val().replace(/\D/g, '') || 0);
                let diskon1 = $(this).val().replace(/\D/g, '');

                if (DiskonTipe !== "persentase") {
                    diskon1 = parseInt(diskon1).toLocaleString('id-ID');
                    $(this).val(diskon1);
                }

                $('#Diskon').val(diskon1);

                var diskonNominal = DiskonTipe == "persentase" ?
                    SubTotal * (parseFloat(diskon1.replace(/\D/g, '')) / 100) :
                    parseFloat(diskon1.replace(/\D/g, ''));

                var totalSetelahDiskon = SubTotal - diskonNominal;
                $('#Total').val(totalSetelahDiskon.toLocaleString('id-ID'));
            });

            $('#TipeDiskon').on('change', function() {
                $('#TotalDiskon').trigger('input');
            });
        });
    </script>
@endsection
