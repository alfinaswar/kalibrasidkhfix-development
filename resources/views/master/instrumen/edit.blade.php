@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Edit Instrumen Alat</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('instrumen.update', $instrumen->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="Kategori" class="form-control @error('Kategori') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="ALKES" @selected(old('Kategori', $instrumen->Kategori) == 'ALKES')>Alkes</option>
                                    <option value="INDUSTRI" @selected(old('Kategori', $instrumen->Kategori) == 'INDUSTRI')>Industri</option>
                                </select>

                                @error('Kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="Nama"
                                    class="form-control @error('Nama') is-invalid @enderror"
                                    value="{{ old('Nama', $instrumen->Nama) }}">
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
                                    <input type="text" name="Tarif" id="Tarif"
                                        class="form-control @error('Tarif') is-invalid @enderror" placeholder="Tarif"
                                        value="{{ old('Tarif', $instrumen->Tarif) }}"
                                        onkeyup="this.value=formatRupiah(this.value)">
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
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Akreditasi</label>
                                <select name="Akreditasi" class="form-control @error('Akreditasi') is-invalid @enderror">
                                    <option value="">Status Akreditasi</option>
                                    <option value="YA"
                                        {{ old('Akreditasi', $instrumen->Akreditasi) == 'YA' ? 'selected' : '' }}>YA
                                    </option>
                                    <option value="TIDAK"
                                        {{ old('Akreditasi', $instrumen->Akreditasi) == 'TIDAK' ? 'selected' : '' }}>TIDAK
                                    </option>
                                </select>
                                @error('Akreditasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alat Ukur</label>
                                <select
                                    class="multi-select select2-hidden-accessible  @error('AlatUkur') is-invalid @enderror"
                                    name="AlatUkur[]" multiple="" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                    {{-- @foreach ($data as $x)
                                        <option value="{{ $x->id }}" data-select2-id="{{ $x->id }}">
                                            {{ $x->NamaAlat }}</option>
                                    @endforeach --}}
                                    @foreach ($data as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ is_array($instrumen->AlatUkur) && in_array($value->id, $instrumen->AlatUkur) ? 'selected' : '' }}>
                                            {{ $value->Nama }} - {{ $value->Merk }} - {{ $value->Sn }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('AlatUkur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Lembar Kerja</label>
                                <input type="file" name="LK" class="form-control @error('LK') is-invalid @enderror"
                                    placeholder="Lembar Kerja" value="{{ old('LK', $instrumen->LK) }}">
                                @error('LK')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" id=""
                                    class="form-control @error('Status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="AKTIF"
                                        {{ old('Status', $instrumen->Status) == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                    <option value="TIDAKAKTIF"
                                        {{ old('Status', $instrumen->Status) == 'TIDAKAKTIF' ? 'selected' : '' }}>Tidak
                                        Aktif</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Metoda Kerja</label>
                                <select name="Metode" class="multi-select @error('Metode') is-invalid @enderror">
                                    <option>Pilih Metoda Kerja</option>
                                    @foreach ($metode as $x)
                                        <option value="{{ $x->id }}"
                                            {{ $instrumen->Metode == $x->id ? 'selected' : '' }}>{{ $x->Nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Metode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa) + (sisa ? '.' : '') + split[0].substr(sisa).replace(/\D/g, '').replace(
                    /\B(?=(\d{3})+(?!\d))/g, ".");
            return prefix == undefined ? rupiah : (rupiah ? rupiah + prefix : '');
        }
    </script>
@endsection
