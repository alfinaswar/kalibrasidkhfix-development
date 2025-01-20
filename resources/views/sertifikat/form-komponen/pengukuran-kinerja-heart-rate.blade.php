                                               <div class="row">
                                                   <center>
                                                       <h3 class="card-title text-center text-black fw-bold"
                                                           style="text-decoration: underline;">
                                                           PENGUJIAN KINERJA</h3>
                                                       <span class="text-primary fw-bold text-uppercase">HEART
                                                           RATE</span>
                                                   </center>
                                                   @php
                                                       $titikukur = ['30', '60', '120', '180'];
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
                                                               <td><input type="text" class="form-control heartrate"
                                                                       name="Titik_Ukur_Heartrate[]"
                                                                       placeholder="Titik Ukur"
                                                                       value="{{ $titikukur[0] }}">
                                                               </td>
                                                               <td><input type="text" class="form-control heartrate"
                                                                       name="Pengulangan1_Heartrate[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $heartrateData[0]->Pengulangan1 ?? '' }}">
                                                               </td>
                                                               <td><input type="text" class="form-control heartrate"
                                                                       name="Pengulangan2_Heartrate[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $heartrateData[0]->Pengulangan2 ?? '' }}">
                                                               </td>
                                                               <td><input type="text" class="form-control heartrate"
                                                                       name="Pengulangan3_Heartrate[]"
                                                                       placeholder="Hasil"
                                                                       value="{{ $heartrateData[0]->Pengulangan3 ?? '' }}">
                                                               </td>
                                                               <td rowspan="4"
                                                                   style="text-align: center; font-weight: bold;"
                                                                   width="10%">±5%</td>
                                                           </tr>
                                                           @for ($i = 0; $i < 3; $i++)
                                                               <tr>
                                                                   <td><input type="text"
                                                                           class="form-control heartrate"
                                                                           name="Titik_Ukur_Heartrate[]"
                                                                           placeholder="Titik Ukur"
                                                                           value="{{ $titikukur[$i + 1] }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control heartrate"
                                                                           name="Pengulangan1_Heartrate[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $heartrateData[$i + 1]->Pengulangan1 ?? '' }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control heartrate"
                                                                           name="Pengulangan2_Heartrate[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $heartrateData[$i + 1]->Pengulangan2 ?? '' }}">
                                                                   </td>
                                                                   <td><input type="text"
                                                                           class="form-control heartrate"
                                                                           name="Pengulangan3_Heartrate[]"
                                                                           placeholder="Hasil"
                                                                           value="{{ $heartrateData[$i + 1]->Pengulangan3 ?? '' }}">
                                                                   </td>
                                                               </tr>
                                                           @endfor
                                                       </tbody>
                                                   </table>
                                               </div>
                                               @push('scripts')
                                                   <script>
                                                       $(document).ready(function() {
                                                           $('.heartrate').on('input', function() {
                                                               this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..{2})/g, '$1');
                                                           });
                                                       });
                                                       $('.heartrate').on('input', function() {
                                                           var pengulangan1 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan1_Heartrate[]"]').val());
                                                           var pengulangan2 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan2_Heartrate[]"]').val());
                                                           var pengulangan3 = parseFloat($(this).closest('tr').find(
                                                               'input[name="Pengulangan3_Heartrate[]"]').val());
                                                           var titikUkur = parseFloat($(this).closest('tr').find('input[name="Titik_Ukur_Heartrate[]"]').val());

                                                           var batasBawah = titikUkur - (5 / 100 * titikUkur);
                                                           var batasAtas = titikUkur + (5 / 100 * titikUkur);

                                                           if (pengulangan1 < batasBawah || pengulangan1 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan1_Heartrate[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan1_Heartrate[]"]').removeClass(
                                                                   'is-invalid');
                                                           }

                                                           if (pengulangan2 < batasBawah || pengulangan2 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan2_Heartrate[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan2_Heartrate[]"]').removeClass(
                                                                   'is-invalid');
                                                           }

                                                           if (pengulangan3 < batasBawah || pengulangan3 > batasAtas) {
                                                               $(this).closest('tr').find('input[name="Pengulangan3_Heartrate[]"]').addClass(
                                                                   'is-invalid');
                                                           } else {
                                                               $(this).closest('tr').find('input[name="Pengulangan3_Heartrate[]"]').removeClass(
                                                                   'is-invalid');
                                                           }
                                                       });
                                                   </script>
                                               @endpush
