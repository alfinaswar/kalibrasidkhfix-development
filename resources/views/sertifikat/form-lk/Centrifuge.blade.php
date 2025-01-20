@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fw-bold">LK PENGUJIAN DAN KALIBRASI <span
                            class="text-primary text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span></h4>
                    <span></span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('job.store') }}">
                        @csrf
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
                                    <input type="text" class="form-control" id="merk" name="merk"
                                        placeholder="Masukkan Merk" value="{{ $sertifikat->Merk ?? null }}">
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
                                                placeholder="Masukkan Resolusi"
                                                value="{{ $sertifikat->Resolusi ?? null }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="resolusi" class="form-label">Satuan</label>
                                            <select name="Satuan" class="multi-select">
                                                <option>Pilih Satuan</option>
                                                @foreach ($satuan as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if ($sertifikat->Satuan == $item->id) selected @endif>
                                                        {{ $item->Satuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_kalibrator" class="form-label">Nama Kalibrator</label>
                                    <input type="text" class="form-control" id="nama_kalibrator" name="nama_kalibrator"
                                        placeholder="Masukkan Nama Kalibrator"
                                        value="{{ $sertifikat->Ruangan ?? auth()->user()->name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="metoda_kerja" class="form-label">Metoda Kerja</label>
                                    <input type="hidden" name="MetodeId" id="metoda_kerja_id"
                                        value="{{ $sertifikat->getNamaAlat->getMetode->id }}">
                                    <textarea class="form-control" id="metoda_kerja" name="metoda_kerja" rows="3"
                                        placeholder="Masukkan Metoda Kerja" onclick="$('#ModalMetoda').modal('show');">{{ $sertifikat->getNamaAlat->getMetode->Nama }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                        placeholder="Masukkan Nama Pemilik"
                                        value="{{ $sertifikat->getCustomer->Kategori }} {{ $sertifikat->getCustomer->Name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_pemilik" class="form-label">Alamat Pemilik</label>
                                    <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik"
                                        placeholder="Masukkan Alamat Pemilik"
                                        value="{{ $sertifikat->getCustomer->Alamat }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                                    <input type="date" class="form-control" id="mdate" name="tanggal_terima"
                                        placeholder="Masukkan Tanggal Terima"
                                        value="{{ $sertifikat->TanggalDiterima ?? null }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_terima" class="form-label fs-4">Status</label>
                                    <select class="form-control" name="HasilAdm" id="HasilAdm">
                                        <option value="LAIK" @if ($sertifikat->Hasil == 'LAIK') selected @endif>Laik
                                        </option>
                                        <option value="TIDAKLAIK" @if ($sertifikat->Hasil == 'TIDAKLAIK') selected @endif>Tidak
                                            Laik</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <center>
                                <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                    DAFTAR ALAT UKUR</h3>
                                <span
                                    class="text-primary fw-bold text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span>
                            </center>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Alat</th>
                                        <th scope="col">Merk</th>
                                        <th scope="col">Model/Type</th>
                                        <th scope="col">Nomor Seri</th>
                                        <th scope="col">Tertelusur</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    @foreach ($getAlatUkur as $key => $NamaAlatUkur)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                <input type="text" name="nama_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Nama }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="merk_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Merk }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="model_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Tipe }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="nomor_seri_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Sn }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="tertelusur_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Tertelusur }}" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUKURAN KONDISI LINGKUNGAN</h3>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parameter</th>
                                        <th scope="col" colspan="2">
                                            <center>Terukur</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <input type="text" class="form-control" value="Temperatur Ruangan (C)"
                                                name="Parameter[]" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" class="form-control forminput"
                                                        placeholder="Suhu Awal" name="KondisiAwal[]"
                                                        value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAwal ?? null }}"
                                                        required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-thermometer-half"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" class="form-control forminput"
                                                        placeholder="Suhu Akhir" name="KondisiAkhir[]"
                                                        value="{{ $sertifikat->getPengukuranKondisiLingkungan->TempraturAkhir ?? null }}"
                                                        required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-thermometer-half"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <input type="text" class="form-control" value="Kelembapan Ruangan(%)"
                                                name="Parameter[]" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" class="form-control forminput"
                                                        placeholder="Kelembapan Awal" name="KondisiAwal[]"
                                                        value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAwal ?? null }}"
                                                        required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-percentage"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" class="form-control forminput"
                                                        placeholder="Kelembapan Akhir" name="KondisiAkhir[]"
                                                        value="{{ $sertifikat->getPengukuranKondisiLingkungan->KelembapanAkhir ?? null }}"
                                                        required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-percentage"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <input type="text" class="form-control" value="Tegangan Utama (vAC)"
                                                name="TeganganUtama" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" class="form-control forminput"
                                                        placeholder="L-N" name="val[]"
                                                        value="{{ $sertifikat->getTeganganUtama->Tegangan_LN ?? null }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">
                                                            <i class="fas fa-bolt"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control forminput" placeholder="L-PE"
                                                    name="val[]"
                                                    value="{{ $sertifikat->getTeganganUtama->Tegangan_LPE ?? null }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i class="fas fa-bolt"></i>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control forminput" placeholder="N-PE"
                                                    name="val[]"
                                                    value="{{ $sertifikat->getTeganganUtama->Tegangan_NPE ?? null }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i class="fas fa-bolt"></i>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUKURAN FISIK DAN FUNGSI</h3>

                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parameter</th>
                                        <th scope="col" colspan="2">
                                            <center>Hasil</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter1[]"
                                                value="Badan dan Permukaan" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter1[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter1[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter1[]"
                                            value="Body and Surface" readonly>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter2[]"
                                                value="Kotak Kontak Alat" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter2[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter2[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter2[]"
                                            value="Box Contact Instrument" readonly>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter3[]"
                                                value="Kabel catu utama
" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter3[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter3[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter3[]"
                                            value="Main Power Cable" readonly>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter4[]"
                                                value="Skring Pengaman" readonly>
                                        </td>

                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter4[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter4[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter4[]"
                                            value="Shut-Off Valve" readonly>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter5[]"
                                                value="Tombol, skalar, dan kontrol" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter5[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter5[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter5[]"
                                            value="Switch, Gauge, and Control" readonly>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>
                                            <input type="text" class="form-control" name="Parameter6[]"
                                                value="Tampilan dan Indikator" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Parameter6[]" class="form-control">
                                                        <option value=""> --Pilih Status-- </option>
                                                        <option value="1"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 1 ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="0"
                                                            {{ isset($sertifikat->getPmeriksaanFisikFungsi->Parameter6[1]) && $sertifikat->getPmeriksaanFisikFungsi->Parameter1[1] == 0 ? 'selected' : '' }}>
                                                            Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <input type="hidden" class="form-control" name="Parameter6[]"
                                            value="Display and Indicator" readonly>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
                                PENGUKURAN KESELAMATAN LISTRIK</h3>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">#</th>
                                        <th scope="col">#</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <strong>Tipe</strong>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="TipeListrik" class="form-control">
                                                        <option value=""> --Pilih Tipe-- </option>
                                                        <option value="B"
                                                            {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'B' ? 'selected' : '' }}>
                                                            B</option>
                                                        <option value="BF"
                                                            {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'BF' ? 'selected' : '' }}>
                                                            BF</option>
                                                        <option value="CF"
                                                            {{ isset($sertifikat->getPengukuranListrik->tipe) && $sertifikat->getPengukuranListrik->tipe == 'CF' ? 'selected' : '' }}>
                                                            CF</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <strong>Kelas</strong>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Kelas" class="form-control">
                                                        <option value=""> --Pilih Kelas-- </option>
                                                        <option value="I"
                                                            {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'I' ? 'selected' : '' }}>
                                                            I</option>
                                                        <option value="II"
                                                            {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'II' ? 'selected' : '' }}>
                                                            II</option>
                                                        <option value="IP"
                                                            {{ isset($sertifikat->getPengukuranListrik->kelas) && $sertifikat->getPengukuranListrik->kelas == 'IP' ? 'selected' : '' }}>
                                                            IP</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parameter</th>
                                        <th scope="col">Terukur</th>
                                        <th scope="col">Ambang Batas</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Tegangan (main voltage) (V)" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required
                                                        placeholder="Tegangan (main voltage)
                                                                                        (V)"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter1 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>220 V ± 10 %</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Resistansi PE (protective earth) Ω" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required placeholder="Resistansi PE (protective earth) Ω"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter2 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 0,2 Ω</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <input type="text" class="form-control" value="Arus bocor peralatan  µA"
                                                readonly>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required placeholder="Arus bocor peralatan µA"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter3 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 500 µA</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Arus bocor bagian yang diaplikasikan µA" readonly>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required
                                                        placeholder="Arus bocor bagian yang diaplikasikan
                                                                                        µA"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter4 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 50 µA</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>
                                            <input type="text" class="form-control" value="Resistansi Isolasi"
                                                readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required placeholder="Resistansi Isolasi"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter5 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>> 2 MΩ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>
                                            <input type="text" class="form-control" value="Ampere" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        required placeholder="Ampere"
                                                        value="{{ $sertifikat->getPengukuranListrik->Parameter6 ?? null }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Ampere</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUJIAN KINERJA</h3>
                            {{-- <div class="text-end mb-3">
                                <a class="btn btn-secondary" onclick="addRow()"><i class="fas fa-plus"></i></a>
                                <a class="btn btn-danger" onclick="deleteRow()"><i class="fas fa-minus"></i></a>
                            </div>
                            <br> --}}
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col" style="vertical-align: middle;">Titik Ukur</th>
                                        <th>Running Pertama</th>
                                        <th>Running Kedua</th>
                                        <th>Running Ketiga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM" value="2000" readonly>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" id="PembacaanAlat1"
                                                placeholder="Uji 1" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[0]->Pengulangan1 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" id="PembacaanAlat2"
                                                placeholder="Uji 2" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[0]->Pengulangan2 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" id="PembacaanAlat3"
                                                placeholder="Uji 3" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[0]->Pengulangan3 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM" value="3000" readonly>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" id="PembacaanAlat1"
                                                placeholder="Uji 1" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[1]->Pengulangan1 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" id="PembacaanAlat2"
                                                placeholder="Uji 2" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[1]->Pengulangan2 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" id="PembacaanAlat3"
                                                placeholder="Uji 3" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[1]->Pengulangan3 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM" value="6000" readonly>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" id="PembacaanAlat1"
                                                placeholder="Uji 1" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[2]->Pengulangan1 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" id="PembacaanAlat2"
                                                placeholder="Uji 2" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[2]->Pengulangan2 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" id="PembacaanAlat3"
                                                placeholder="Uji 3" class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[2]->Pengulangan3 ?? null }}"
                                                onchange="checkValue(this)">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr class="text-center">
                                        <th scope="col" rowspan="2" style="vertical-align: middle;">Standar Waktu
                                        </th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM" value="300" readonly>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" placeholder="Uji 1"
                                                class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[3]->Pengulangan1 ?? null }}">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" placeholder="Uji 2"
                                                class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[3]->Pengulangan2 ?? null }}">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" placeholder="Uji 3"
                                                class="form-control"
                                                value="{{ $sertifikat->getPengujianKinerjaCentrifuge[3]->Pengulangan3 ?? null }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
                                TELAAH TEKNIS</h3>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <polygon
                                        points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                <strong>Warning!</strong> Kosongkan Jika Tidak Ada.
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"> --}}
                                </button>
                            </div>
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Indikator</th>
                                        <th class="text-center">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Fisik dan Fungsi</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="BAIK"
                                                            @if (isset($sertifikat) && isset($sertifikat->getTelaahTeknis) && $sertifikat->getTelaahTeknis->FisikFungsi == 'BAIK') selected @endif>Baik</option>
                                                        <option value="TIDAKBAIK"
                                                            @if (isset($sertifikat) &&
                                                                    isset($sertifikat->getTelaahTeknis) &&
                                                                    $sertifikat->getTelaahTeknis->FisikFungsi == 'TIDAKBAIK') selected @endif>Tidak Baik
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Keselamatan Listrik</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="AMAN"
                                                            @if (isset($sertifikat) &&
                                                                    isset($sertifikat->getTelaahTeknis) &&
                                                                    $sertifikat->getTelaahTeknis->KeselamatanListrik == 'AMAN') selected @endif>Aman</option>
                                                        <option value="TIDAKAMAN"
                                                            @if (isset($sertifikat) &&
                                                                    isset($sertifikat->getTelaahTeknis) &&
                                                                    $sertifikat->getTelaahTeknis->KeselamatanListrik == 'TIDAKAMAN') selected @endif>Tidak Aman
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Kinerja</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="PERLUPERBAIKAN"
                                                            @if (isset($sertifikat) &&
                                                                    isset($sertifikat->getTelaahTeknis) &&
                                                                    $sertifikat->getTelaahTeknis->Kinerja == 'PERLUPERBAIKAN') selected @endif>Perlu
                                                            Perbaikan</option>
                                                        <option value="DALAMBATASTOLENRANSI"
                                                            @if (isset($sertifikat) &&
                                                                    isset($sertifikat->getTelaahTeknis) &&
                                                                    $sertifikat->getTelaahTeknis->Kinerja == 'DALAMBATASTOLENRANSI') selected @endif>
                                                            Dalam Batas Toleransi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <span name="Catatan">Catatan</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <textarea name="Catatan" class="form-control" placeholder="Catatan">{{ $sertifikat->getTelaahTeknis->Catatan ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                </div>
            </div>
        </div>
        <input type="hidden" name="idinstrumen" value="{{ $sertifikat->InstrumenId }}">
        <input type="hidden" name="sertifikatid" value="{{ $sertifikat->id }}">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ModalMetoda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Metoda Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="example" class="display table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if (session()->has('success'))
        <script>
            swal.fire({
                title: "{{ __('Success!') }}",
                text: "{!! \Session::get('success') !!}",
                type: "success"
            });
        </script>
    @endif
    <script>
        function addRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            var cells = [];
            for (var i = 0; i < 5; i++) {
                cells[i] = newRow.insertCell(i);
                if (i === 0) {
                    cells[i].innerHTML = `
                <div class="input-group">
                    <input type="number" class="form-control" name="TestingStandart[]" placeholder="Standart Testing RPM" value="">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                    </div>
                </div>`;
                } else if (i < 4) {
                    cells[i].innerHTML = `
                <input type="text" name="PembacaanAlat${i}[]" placeholder="Uji ${i}" class="form-control" onclick="checkValue(this)">
            `;
                } else {
                    cells[i].innerHTML = `
                <input type="text" name="RataRata${i}[]" placeholder="Rata-rata" class="form-control">
            `;
                }
            }
            updateTestingStandart();
        }

        function deleteRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            if (table.rows.length > 1) {
                table.deleteRow(table.rows.length - 1);
                updateTestingStandart();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tidak dapat menghapus baris, tabel harus memiliki setidaknya satu baris.'
                });
            }
        }

        function updateTestingStandart() {
            var rows = document.querySelectorAll('#myTable tbody tr');
            var lastRowIndex = rows.length - 1;
            var lastRowTestingStandartInput = rows[lastRowIndex].querySelector('input[name="TestingStandart[]"]');
            if (lastRowIndex > 0) {
                var prevRowTestingStandartInput = rows[lastRowIndex - 1].querySelector('input[name="TestingStandart[]"]');
                lastRowTestingStandartInput.value = prevRowTestingStandartInput.value;
            }
        }

        function saveMetodaKerja() {
            var modalValue = document.getElementById('modal_metoda_kerja').value;
            document.getElementById('metoda_kerja').value = modalValue;
            $('#ModalMetoda').modal('hide');
        }
        $(document).ready(function() {
            var dataTable = function() {
                var table = $('#example').DataTable({
                    responsive: true,
                    serverSide: true,
                    destroy: true,
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        }
                    },
                    columnDefs: [{
                        width: '10%',
                        targets: 0
                    }],
                    ajax: "{{ route('metode.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'Nama',
                            name: 'Nama'
                        },
                    ]
                });

                $('#example tbody').on('click', 'tr', function() {
                    var data = table.row(this).data();
                    $("#metoda_kerja").val(data.Nama);
                    $('#ModalMetoda').modal('hide');
                });
            };
            dataTable();
        });

        function checkValue(input) {
            var row = input.parentNode.parentNode;
            var testingStandartInput = row.querySelector('input[name="TestingStandart[]"]');
            var testingStandartValue = parseFloat(testingStandartInput.value);
            var pembacaanAlatValue = parseFloat(input.value);
            var allowedRange = testingStandartValue * 0.1;
            if (pembacaanAlatValue < (testingStandartValue - allowedRange) || pembacaanAlatValue > (testingStandartValue +
                    allowedRange)) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }


        }
    </script>
@endsection
