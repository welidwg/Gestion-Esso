  @extends('dashboard/base')
  @section('title')
      Stats Cigarettes
  @endsection
  @php
      use App\Models\Releve;
      use App\Models\AchatCigarette;
      $date = request('date');
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-2 d-flex  justify-content-between align-items-center ">
              <span class="text-primary m-0 fw-bold d-flex  ">Statistiques Cigarettes

              </span>


          </div>


          <div class="card-body">
              <div class="col-md-6 mx-auto">
                  <div class="">
                      <label class="form-label" for=""><strong>Choisissez le mois
                          </strong></label>
                  </div>
                  <input class="form-control  text-dark" type="month" required id="date_stats" placeholder=""
                      name="date_stats" value="{{ request('date') }}" />
                  <script>
                      $("#date_stats").change(function(e) {
                          e.preventDefault();
                          window.location.href = `/cigarette/stats?date=${e.target.value}`

                      });
                  </script>
              </div>
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                  <table class="table my-0">
                      <thead>
                          <tr>
                              <th>Type</th>
                              <th>Vente</th>
                              <th>Achat</th>
                              {{-- <th>Action</th> --}}
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($cigarettes as $cigarette)
                              @php
                                  $total_vente_euro = 0;
                                  $total_vente_qte = 0;
                                  $total_achat_euro = 0;
                                  $total_achat_qte = 0;
                                  $test = [];
                                  $title = $cigarette->type;
                                  
                                  $relevesStat2 = Releve::whereMonth('date_systeme', date('m', strtotime($date)))
                                      ->whereYear('date_systeme', date('Y', strtotime($date)))
                                      ->get();
                                  
                                  $achatStat = AchatCigarette::whereMonth('date_achat', date('m', strtotime($date)))
                                      ->whereYear('date_achat', date('Y', strtotime($date)))
                                      ->get();
                                  foreach ($relevesStat2 as $r) {
                                      $ventes = json_decode($r->vente_cigarette);
                                      if ($ventes != null) {
                                          foreach ($ventes as $vente) {
                                              foreach ($vente as $k => $v) {
                                                  if ($k == $title) {
                                                      $total_vente_euro += $v->montant;
                                                      $total_vente_qte += $v->qte;
                                                  }
                                              }
                                          }
                                      }
                                  }
                                  
                                  foreach ($achatStat as $achat) {
                                      $achats = json_decode($achat->achat);
                                      foreach ($achats as $ach) {
                                          foreach ($ach as $key => $value) {
                                              if ($key == $title) {
                                                  $total_achat_euro += $achat->total;
                                                  $total_achat_qte += $value->qte;
                                              }
                                          }
                                      }
                                  
                                      # code...
                                  }
                                  
                              @endphp
                              <tr>
                                  <td>{{ $title }}</td>
                                  <td>
                                      <div class="d-flex flex-column">
                                          <span class="text-dark">
                                              <span class="">
                                                  {{ $total_vente_qte }} Packets
                                              </span>
                                              /
                                              <span class="text-primary">
                                                  {{ $total_vente_euro }} €
                                              </span>
                                          </span>

                                      </div>
                                  </td>
                                  <td>
                                      <div class="d-flex flex-column">
                                          <span class="text-dark">
                                              <span class="">
                                                  {{ $total_achat_qte }} Packets
                                              </span>
                                              /
                                              <span class="text-primary">
                                                  {{ $total_achat_euro }} €
                                              </span>
                                          </span>

                                      </div>
                                  </td>
                              </tr>
                          @endforeach


                      </tbody>

                  </table>
              </div>

          </div>
      </div>
  @endsection
