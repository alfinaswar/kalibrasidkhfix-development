                                               <div class="row">
                                                   <center>
                                                       <h3 class="card-title text-center text-black fw-bold"
                                                           style="text-decoration: underline;">
                                                           PENGUJIAN KINERJA</h3>
                                                       <span class="text-primary fw-bold text-uppercase">SATURASI
                                                           OKSIGEN</span>
                                                   </center>
                                                   @php
                                                       $saturasioksi = ['98', '99', '100'];
                                                   @endphp
                                                   <table class="table table-striped">
                                                       <thead class="thead-dark bg-primary text-white">
                                                           <tr>
                                                               <th colspan="2" rowspan="2" width="10%"
                                                                   style="vertical-align: middle;">Parameter</th>
                                                               <th rowspan="2" width="20%"
                                                                   style="vertical-align: middle; text-align: center;">
                                                                   Titik Ukur</th>
                                                               <th colspan="3">
                                                                   <CENTER>Pengulangan</CENTER>
                                                               </th>
                                                               <th rowspan="2"
                                                                   style="vertical-align: middle; text-align: center;">
                                                                   Toleransi</th>
                                                           </tr>
                                                           <tr>
                                                               <th>
                                                                   <center>1</center>
                                                               </th>
                                                               <th>
                                                                   <center>2</center>
                                                               </th>
                                                               <th>
                                                                   <center>3</center>
                                                               </th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tr>
                                                               <td colspan="2" rowspan="4"
                                                                   style="text-align: center; font-weight: bold;">BPM
                                                               </td>
                                                               <td><input type="text"
                                                                       class="form-control oksigeninput"
                                                                       name="Titik_Ukur_saturasi_oksigen[]"
                                                                       placeholder="Titik Ukur"
                                                                       value="{{ $saturasioksi[0] ?? '' }}">
                                                               </td>
                                                               <td><input type="text"
                                                                       class="form-control oksigeninput"
                                                                       name="Pengulangan1_saturasi_oksigen[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $saturasiData[7]->Pengulangan1 ?? '' }}">
                                                               </td>
                                                               <td><input type="text"
                                                                       class="form-control oksigeninput"
                                                                       name="Pengulangan2_saturasi_oksigen[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $saturasiData[7]->Pengulangan2 ?? '' }}">
                                                               </td>
                                                               <td><input type="text"
                                                                       class="form-control oksigeninput"
                                                                       name="Pengulangan3_saturasi_oksigen[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $saturasiData[7]->Pengulangan3 ?? '' }}">
                                                               </td>
                                                               <td rowspan="4"
                                                                   style="text-align: center; font-weight: bold;"
                                                                   width="10%">±5%</td>
                                                           </tr>
                                                           @for ($i = 0; $i < 2; $i++)
                                                               <tr>
                                                                   <td><input type="text"
                                                                           class="form-control oksigeninput"
                                                                           name="Titik_Ukur_saturasi_oksigen[]"
                                                                           placeholder="Titik Ukur"
                                                                           value="{{ $saturasioksi[$i + 1] ?? '' }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control oksigeninput"
                                                                           name="Pengulangan1_saturasi_oksigen[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $saturasiData[$i + 8]->Pengulangan1 ?? '' }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control oksigeninput"
                                                                           name="Pengulangan2_saturasi_oksigen[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $saturasiData[$i + 8]->Pengulangan2 ?? '' }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control oksigeninput"
                                                                           name="Pengulangan3_saturasi_oksigen[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $saturasiData[$i + 8]->Pengulangan3 ?? '' }}">
                                                                   </td>
                                                               </tr>
                                                           @endfor
                                                       </tbody>
                                                   </table>
                                               </div>
                                               @push('scripts')
                                                   <script>
                                                       $(document).ready(function() {
                                                           $('.oksigeninput').on('input', function() {
                                                               this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
                                                           });
                                                       });
                                                       $('.oksigeninput').on('input', function() {
                                                           var pengulangan1 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan1_saturasi_oksigen[]"]').val());
                                                           var pengulangan2 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan2_saturasi_oksigen[]"]').val());
                                                           var pengulangan3 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan3_saturasi_oksigen[]"]').val());
                                                           var titikUkur = parseFloat($(this).closest('tr').find('input[name="Titik_Ukur_saturasi_oksigen[]"]')
                                                               .val());

                                                           var batasBawah = titikUkur - 5;
                                                           var batasAtas = titikUkur + 5;
                                                           //    console.log(batasBawah);

                                                           if (pengulangan1 < batasBawah || pengulangan1 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan1_saturasi_oksigen[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan1_saturasi_oksigen[]"]').removeClass(
                                                                   'is-invalid');
                                                           }

                                                           if (pengulangan2 < batasBawah || pengulangan2 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan2_saturasi_oksigen[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan2_saturasi_oksigen[]"]').removeClass(
                                                                   'is-invalid');
                                                           }

                                                           if (pengulangan3 < batasBawah || pengulangan3 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan3_saturasi_oksigen[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan3_saturasi_oksigen[]"]')
                                                                   .removeClass(
                                                                       'is-invalid');
                                                           }
                                                       });
                                                   </script>
                                               @endpush
