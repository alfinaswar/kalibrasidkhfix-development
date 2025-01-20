@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Sertifikat Halaman Ketiga</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('job.storeHasil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="mb-3 col-md-12">
                                <label class="form-label">Nomor Sertifikat</label>
                                <input type="text" class="form-control" name=""
                                    value="{{ $Sertifikat->SertifikatOrder }}" readonly>

                            </div>

                            <div class="mb-3 col-md-12">

                                <label class="form-label">Sertifikat Halaman Ketiga</label>
                                <textarea name="HasilKalibrasi" id="texteditor1" class="form-control"
                                    placeholder="Paste Hasil Kalibrasi Halaman Ketiga">
{!! $data->HasilKalibrasi ?? 'Belum Ada Data' !!}
                                </textarea>
                                @error('HasilKalibrasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                        </div>


                </div>
                <input type="hidden" value="{{ $Sertifikat->id }}" name="SertifikatId">
                <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector(`#texteditor1`), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'blockQuote',
                        'insertTable', // Menambahkan opsi insert table
                        'undo',
                        'redo',
                        '|',
                        'alignment:left', // Menambahkan opsi rata kiri
                        'alignment:center', // Menambahkan opsi rata tengah
                        'alignment:right' // Menambahkan opsi rata kanan
                    ]
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        }
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
