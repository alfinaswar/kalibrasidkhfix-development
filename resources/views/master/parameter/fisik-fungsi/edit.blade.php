@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Edit Master Parameter Fisik Fungsi</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Kembali</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('fisikfungsi.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Nama Parameter</label>
                                <input type="text" name="Parameter"
                                    class="form-control @error('Parameter') is-invalid @enderror"
                                    placeholder="Nama Parameter" value="{{ old('Parameter', $data->Parameter) }}">
                                @error('Parameter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Parameter Dalam Bahasa Inggris</label>
                                <input type="text" name="ParameterEng"
                                    class="form-control @error('ParameterEng') is-invalid @enderror"
                                    placeholder="Parameter Dalam Bahasa Inggris"
                                    value="{{ old('ParameterEng', $data->ParameterEng) }}">
                                @error('ParameterEng')
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
@endsection
