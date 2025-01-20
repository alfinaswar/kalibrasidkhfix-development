<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kalibrasi</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Arial ', sans-serif;
            font-size: 12px;
            margin-top: 3.7cm;
            margin-bottom: 4.0cm;
            margin-left: 1cm;
            margin-right: 1cm;
            font-size: 14px;
            counter-reset: pageCounter;
        }

        .page-break {
            page-break-after: always;
        }

        .page {
            counter-increment: pageCounter;
        }

        .page-number-container::before {
            content: 'Sertifikat ini terdiri dari: ' counter(pageCounter) ' dari ' attr(data-total-pages) ' Hal';
        }

        .header {
            text-align: center;
        }

        .watermark {
            position: fixed;
            bottom: 0px;
            left: 0px;
            top: 0px;
            right: 0px;
            width: 21cm;
            height: 29.7cm;
            z-index: -10;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }

        .content {
            margin-bottom: 10px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }



        small {
            font-size: 8px;
            font-style: italic;
        }

        #tabelhal2 {
            border-collapse: collapse;
            width: 100%;
            padding: 1px;
            vertical-align: middle;
        }

        #tabelhal2 th {
            border: 1px solid #000000;
            text-align: center;
            vertical-align: middle;
        }

        #tabelhal2 td {
            border: 1px solid #000000;
            padding: 5px;
            text-align: left;
            vertical-align: middle;
        }

        #hal2 {
            width: 100%;
            line-height: 0.5cm;
            zoom: 1;
            font-size: 9px;
        }

        /* #hal1 {
            width: 100%;
            line-height: 0.5cm;
            zoom: 1;
            font-size: 9px;
        } */
        #tabelttd th {
            border: 0px solid #000000;
            text-align: center;
            vertical-align: middle;
        }

        #tabelttd td {
            border: 0px solid #000000;
            padding: 1px;
            text-align: left;
            vertical-align: middle;
            line-height: 0.4cm;
        }
    </style>

</head>

<body>

    <body>
        @php
            if ($data->getNamaAlat->Akreditasi == 'AKTIF') {
                $bg = 'templateKAN.jpeg';
            } else {
                $bg = 'templatev2.png';
            }
        @endphp
        <div class="watermark">
            <img src="{{ asset('assets/images/bgsurat/' . $bg) }}" alt="" width="100%" height="100%">
        </div>
        <section id="hal1">
            <div class="content">
                <center>
                    <span style="font-size: 14pt;">SERTIFIKAT KALIBRASI</span><br>
                    <span>CALIBRATION CERTIFICATE</span>
                    <br>
                    <br>
                </center>
                <table width="100%"
                    style="background-color: #ffffff; filter: alpha(opacity=40); border:1px rgb(255, 166, 0) solid;">
                    <tr>
                        <td width="40%">No. Order<br><small>Order Number</small></td>
                        <td>:</td>
                        <td width="59%">{{ $data->SertifikatOrder ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. Sertifikat<br><small>Certificate Number</small></td>
                        <td>:</td>
                        <td>{{ $data->NoSertifikat ?? '-' }}</td>
                    </tr>
                </table>

                <table width="100%">
                    <colgroup>
                        <col style="width: 32px">
                        <col style="width: 192px">
                        <col style="width: 25px">
                        <col style="width: 27px">
                    </colgroup>

                    <tr>
                        <td colspan="2" width="40%">Identitas Pemilik<br><small>Owner's Identity</small></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="5%"></td>
                        <td width="35%">Nama<br><small>Name</small></td>
                        <td>:</td>
                        <td width="59%">{{ $data->getCustomer->Name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Alamat<br><small>Address</small></td>
                        <td>:</td>
                        <td>{{ $data->getCustomer->Alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">Identitas Alat<br><small>Device Identity</small></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nama Alat<br><small>Device Name</small></td>
                        <td>:</td>
                        <td>{{ $data->getNamaAlat->Nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Merk<br><small>Brand</small></td>
                        <td>:</td>
                        <td>{{ $data->Merk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Type/Model<br><small>Type/Model</small></td>
                        <td>:</td>
                        <td>{{ $data->Typ ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>No Seri<br><small>Serial Number</small></td>
                        <td>:</td>
                        <td>{{ $data->SerialNumber ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Ruangan<br><small>Room</small></td>
                        <td>:</td>
                        <td>{{ $data->Ruangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Penanggung Jawab Kalibrasi<br><small>Calibration Person in Charge</small></td>
                        <td>:</td>
                        <td>{{ $data->getUser->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Resolusi<br><small>Resolution</small></td>
                        <td>:</td>
                        <td>{{ $data->Resolusi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tanggal Penerimaan<br><small>Receipt Date</small></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($data->TanggalDiterima ?? null)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tanggal Kalibrasi<br><small>Calibration Date</small></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($data->TanggalPelaksanaan ?? null)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Hasil Kalibrasi<br><small>Calibration Result</small></td>
                        <td>:</td>
                        <td>{{ $data->Hasil == 'LAIK' ? 'LAIK' : 'TIDAK LAIK' }}</td>
                    </tr>

                </table>
                <table width="100%" id="tabelttd34">
                    <tr>
                        <td width="40%">&nbsp;</td>
                        <td width="59%" style="padding-top:0px; padding-left: 150px">
                            <div id="page-number-container">
                                <br>

                            </div>
                            Diterbitkan Tanggal :
                            {{ \Carbon\Carbon::parse($data->TanggalDiterima ?? null)->format('d F Y') }}<br>
                            <small>Published Date</small><br>
                            <center>Manajer Umum<br><small>General Manager</small></center>
                            <center>
                                <img src="{{ asset('storage/DigitalSign/' . $ttd ?? '-') }}" alt="Tanda Tangan"
                                    style="width: 150px; height: auto;" />
                            </center>
                            <center>dr Gina Adriana,MARS,MHKES, FISQua</center>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <br>
        <div class="page-break"></div>
        <section id="hal1">
            <div class="content">
                <table width="100%"
                    style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px rgb(255, 166, 0) solid;">
                    <tr>
                        <td width="50%">No. Order : {{ $data->SertifikatOrder ?? '-' }}<br><small>Order
                                Number</small></td>
                        <td width="50%">No. Sertifikat : {{ $data->NoSertifikat ?? '-' }}<br><small>Certificate
                                Number</small></td>
                    </tr>
                </table>
                <br>
                <center>
                    <span style="font-size: 11pt;">HASIL KALIBRASI</span><br>
                    CALIBRATION RESULST</p>
                </center>
                <h4>I. Kondisi Kalibrasi <br><small>Calibration Conditions</small></h4>
                <table id="tablehal2" width="100%" border="1px"
                    style="border-collapse: collapse; border: 1px solid #000000;">
                    <tr>
                        <td>A. Suhu <br><small>Temperature</small></td>
                        <td>{{ $data->getPengukuranKondisiLingkungan->SuhuRataRata ?? '-' }} ± 0.5 °C</td>
                    </tr>
                    <tr>
                        <td>B. Kelembaban <br><small>Humidity</small></td>
                        <td>{{ $data->getPengukuranKondisiLingkungan->KelembapanRataRata ?? '-' }} ± 2.3 % RH</td>
                    </tr>
                </table>


                <h4>II. Alat Standar Kalibrasi <br><small>Calibration Standard Equipment</small></h4>
                <p>Tertelusur Ke Sistem Satuan Internasional (SI) <br><small>Traceable to the International System of
                        Units (SI)</small></p>
                <table id="tablehal2" width="100%" border="1px"
                    style="border-collapse: collapse; border: 1px solid #000000;">
                    <colgroup>
                        <col style="width: 43px">
                        <col style="width: 121px">
                        <col style="width: 129px">
                        <col style="width: 71px">
                        <col style="width: 57px">
                        <col style="width: 169px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Alat <br><small>Equipment Name</small></th>
                            <th scope="col">Merk <br><small>Brand</small></th>
                            <th scope="col">Model/Type <br><small>Model/Type</small></th>
                            <th scope="col">Nomor Seri <br><small>Serial Number</small></th>
                            <th scope="col">Tertelusur <br><small>Traceable</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getAlatUkur as $key => $NamaAlatUkur)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $NamaAlatUkur->Nama }}
                                </td>
                                <td>
                                    {{ $NamaAlatUkur->Merk }}
                                </td>
                                <td>
                                    {{ $NamaAlatUkur->Tipe }}
                                </td>
                                <td>
                                    {{ $NamaAlatUkur->Sn }}
                                </td>
                                <td>
                                    {{ $NamaAlatUkur->Tertelusur }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>



                <h4>III. Pemeriksaan Kondisi Fisik Dan Fungsi</h4>
                <p>A. Fisik<br><small>physique</small></p>
                <table id="tablehal2" width="100%" border="1px"
                    style="border-collapse: collapse;  border: 1px solid #000000;">
                    @for ($i = 1; $i <= 12; $i++)
                        @if (is_null($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}))
                        @break
                    @endif
                    <tr>
                        <td>{{ $data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[0] ?? 'Tidak Ada Data' }} /
                            <i>{{ $data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[2] ?? 'Tidak Ada Data' }}</i>
                        </td>
                        <td>:</td>
                        <td>
                            @if ($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[1] == 1)
                                <span style="text-decoration: none;">Baik / <i>Optimal</i></span>
                            @else
                                <span style="text-decoration: line-through;">Baik / <i>Optimal</i></span>
                            @endif
                        </td>
                        <td>
                            @if ($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[1] == 0)
                                <span style="text-decoration: none;">Tidak Baik / <i>Suboptimal</i></span>
                            @else
                                <span style="text-decoration: line-through;">Tidak Baik / <i>Suboptimal</i></span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </table>
            <br>
            <p>B. Fungsi<br><small>Function</small></p>
            <table id="tablehal2" width="100%" border="1px"
                style="border-collapse: collapse;  border: 1px solid #000000;">
                @for ($i = 1; $i <= 12; $i++)
                    @if (is_null($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}))
                    @break
                @endif
                <tr>
                    <td>{{ $data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[0] ?? 'Tidak Ada Data' }} /
                        <i>{{ $data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[2] ?? 'Tidak Ada Data' }}</i>
                    </td>
                    <td>:</td>
                    <td>
                        @if ($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[1] == 1)
                            <span style="text-decoration: none;">Baik / <i>Optimal</i></span>
                        @else
                            <span style="text-decoration: line-through;">Baik / <i>Optimal</i></span>
                        @endif
                    </td>
                    <td>
                        @if ($data->getPmeriksaanFisikFungsi->{'Parameter' . $i}[1] == 0)
                            <span style="text-decoration: none;">Tidak Baik / <i>Suboptimal</i></span>
                        @else
                            <span style="text-decoration: line-through;">Tidak Baik / <i>Suboptimal</i></span>
                        @endif
                    </td>
                </tr>
            @endfor
        </table>

        <h4>IV. Acuan Kalibrasi<br><small>Calibration Reference</small></h4>
        <p>
            Alat ini dikalibrasi menggunakan Instruksi kerja Nomor IK/DKH/302.43/Teknis/2024 yang mengacu pada
            buku
            Metode Kerja Pengujian dan Kalibrasi Alat Kesehatan-{{ $data->getMetode->Nama ?? '-' }}.
        </p>
        <p style="font-style: italic;">
            This Calibration procedures of instrument strictly obey the work instruction
            IK/DKH/302.43/Teknis/2024, which
            refers to the Test and Calibration Method Handbook for Medical Devices - Ministry Of Health Republic
            Indonesia {{ $data->getMetode->Nama ?? '-' }}
        </p>

        <h4>V. Pengamatan Kinerja <br><small>Performance Observation</small></h4>
        <table width="100%" border="1px" style="border-collapse: collapse; border: 1px solid #000000;">
            <tbody>
                <tr>
                    <td width="40%">A. Pengujian Berulang <br><small>Repeated Testing</small></td>
                    <td>Terlampir <small>Attached</small></td>

                </tr>
                <tr>
                    <td>B. Pengujian Penyimpangan Skala Nominal <br><small>Testing of Nominal Scale
                            Deviations</small></td>
                    <td>Terlampir <small>Attached</small></td>

                </tr>
            </tbody>
        </table>

        <h4>VI. Kesimpulan<br><small>Conculusion</small></h4>
        <p>
            Berdasarkan hasil pemeriksaan dan pengukuran di atas, maka alat ini dinyatakan <b>LAIK PAKAI</b>.
        </p>
        <p>
            Sesuai Peraturan Menteri Kesehatan Republik Indonesia, Nomor 54 Tahun 2015 Tentang Pengujian Dan
            Kalibrasi Alat Kesehatan dan Ketidakpastian yang diberikan dalam sertifikat ini menggunakan basis
            distribusi normal dengan tingkat kepercayaan 95%, dengan faktor cakupan k = 2.
        </p>
        <p>
            Based on the results of the inspections and measurements above, this equipment is declared <b>FIT
                FOR USE</b>.
        </p>
        <p>
            In accordance with the Regulation of the Minister of Health of the Republic of Indonesia, Number 54
            of 2015 concerning the Testing and Calibration of Medical Devices, the uncertainty provided in this
            certificate is based on a normal distribution with a confidence level of 95%, using a coverage
            factor of k = 2.
        </p>
    </div>
</section>
<br>
<div class="page-break"></div>
<section id="hal3">
    <div class="content">
        <div class="kop-surat">
        </div>
        <center>
            <br>
            <span style="font-size: 11pt;">HASIL KALIBRASI</span><br>
            CALIBRATION RESULST</p>
        </center>

        {!! $data->getHasilKalibrasi->HasilKalibrasi ?? 'Belum Dikalibrasi' !!}
    </div>
</section>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalPages = document.getElementsByClassName('page').length;
        var pageNumberContainers = document.getElementsByClassName('page-number-container');

        for (var i = 0; i < pageNumberContainers.length; i++) {
            pageNumberContainers[i].setAttribute('data-total-pages', totalPages);
        }
    });
</script>
