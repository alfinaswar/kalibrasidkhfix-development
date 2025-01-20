<div class="row">
    <center class="mb-4">
        <h3 class="fw-bold" style="text-decoration: underline;">
            ADMINISTRASI</h3>
        <span class="text-primary fw-bold">{{ $sertifikat->SertifikatOrder }} /
            {{ $sertifikat->NoSertifikat }}</span>
    </center>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" class="form-control" id="merk" name="merk" placeholder="Masukkan Merk"
                value="{{ $sertifikat->Merk ?? null }}">
            <input type="hidden" class="form-control" id="merk" name="no_order"
                value="{{ $sertifikat->SertifikatOrder }}">
        </div>
        <div class="mb-3">
            <label for="type_model" class="form-label">Type/ Model</label>
            <input type="text" class="form-control" id="type_model" name="type_model"
                placeholder="Masukkan Type/ Model" value="{{ $sertifikat->Type ?? null }}">
        </div>
        <div class="mb-3">
            <label for="nomor_seri" class="form-label">Nomor Seri</label>
            <input type="text" class="form-control" id="nomor_seri" name="nomor_seri"
                placeholder="Masukkan Nomor Seri" value="{{ $sertifikat->SerialNumber ?? null }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_kalibrasi" class="form-label">Tanggal Kalibrasi</label>
            <input type="date" class="form-control" id="mdate" name="tanggal_kalibrasi"
                placeholder="Masukkan Tanggal Terima"value="{{ $sertifikat->TanggalPelaksanaan }}">
        </div>
        <div class="mb-3">
            <label for="instansi_ruangan" class="form-label">Instansi/ Ruangan</label>
            <input type="text" class="form-control" id="instansi_ruangan" name="instansi_ruangan"
                placeholder="Masukkan Instansi/ Ruangan" value="{{ $sertifikat->Ruangan ?? null }}">
        </div>
        <div class="mb-3">
            <div class="row">

                <div class="col-6">
                    <label for="resolusi" class="form-label">Resolusi</label>
                    <input type="text" class="form-control" id="resolusi" name="resolusi"
                        placeholder="Masukkan Resolusi" value="{{ $sertifikat->Resolusi ?? null }}">
                </div>
                <div class="col-6">
                    <label for="resolusi" class="form-label">Satuan</label>
                    <select name="Satuan" class="multi-select">
                        <option>Pilih Satuan</option>
                        @foreach ($satuan as $item)
                            <option value="{{ $item->id }}" @if ($sertifikat->Satuan == $item->id) selected @endif>
                                {{ $item->Satuan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="nama_kalibrator" class="form-label">Nama Kalibrator</label>
            <input type="text" class="form-control" id="nama_kalibrator" name="nama_kalibrator"
                placeholder="Masukkan Nama Kalibrator" value="{{ auth()->user()->name ?? 'Belum Login' }}" readonly>
        </div>
        <div class="mb-3">
            <label for="metoda_kerja" class="form-label">Metoda Kerja</label>
            <input type="hidden" name="MetodeId" id="metoda_kerja_id"
                value="{{ $sertifikat->getNamaAlat->getMetode->id }}">
            <textarea class="form-control" id="metoda_kerja" name="metoda_kerja" rows="3" placeholder="Masukkan Metoda Kerja"
                onclick="$('#ModalMetoda').modal('show');">{{ $sertifikat->getNamaAlat->getMetode->Nama }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                placeholder="Masukkan Nama Pemilik" value="{{ $sertifikat->getCustomer->Name }}">
        </div>
        <div class="mb-3">
            <label for="alamat_pemilik" class="form-label">Alamat Pemilik</label>
            <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik"
                placeholder="Masukkan Alamat Pemilik" value="{{ $sertifikat->getCustomer->Alamat }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
            <input type="date" class="form-control" id="mdate" name="tanggal_terima"
                placeholder="Masukkan Tanggal Terima" value="{{ $sertifikat->TanggalDiterima ?? null }}">
        </div>
        <div class="mb-3">
            <label for="tanggal_terima" class="form-label fs-4">Status</label>
            <select class="form-control" name="HasilAdm" id="HasilAdm">
                <option value="LAIK" @if ($sertifikat->Hasil == 'LAIK') selected @endif>Laik</option>
                <option value="TIDAKLAIK" @if ($sertifikat->Hasil == 'TIDAKLAIK') selected @endif>Tidak Laik</option>
            </select>
        </div>
    </div>
</div>
{{-- <input type="hidden" name="idinstrumen" value="{{ $sertifikat->InstrumenId }}">
<input type="hidden" name="sertifikatid" value="{{ $sertifikat->id }}"> --}}
