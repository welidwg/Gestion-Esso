  @extends('dashboard/base')
  @section('title')
      Stats carburants
  @endsection
  @php
      use App\Models\Releve;
      use App\Models\Facture;
      $date = request('date');
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-2 d-flex  justify-content-between align-items-center ">
              <span class="text-primary m-0 fw-bold d-flex  ">Statistiques carburants

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
                          window.location.href = `/carburant/stats?date=${e.target.value}`

                      });
                  </script>
              </div>
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                  <table class="table my-0">
                      <thead>
                          <tr>
                              <th>Carburant</th>
                              <th>Vente</th>
                              <th>Achat</th>
                              {{-- <th>Action</th> --}}
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($carburants as $carb)
                              @php
                                  $id = $carb->id;
                                  $total_vente_euro = 0;
                                  $total_vente_qte = 0;
                                  $total_achat_euro = 0;
                                  $total_achat_qte = 0;
                                  $test = [];
                                  $title = $carb->titre;
                                  
                                  $relevesStat1 = Releve::whereMonth('date_systeme', date('m', strtotime($date)))
                                      ->whereYear('date_systeme', date('Y', strtotime($date)))
                                      ->get();
                                  
                                  $factureStat = Facture::whereMonth('date_facture', date('m', strtotime($date)))
                                      ->whereYear('date_facture', date('Y', strtotime($date)))
                                      ->get();
                                  foreach ($relevesStat1 as $r) {
                                      $ventes = json_decode($r->vente);
                                      if ($ventes != null) {
                                          foreach ($ventes as $vente) {
                                              foreach ($vente as $k => $v) {
                                                  if ($k == $carb->titre) {
                                                      if ($v->montant != 0) {
                                                          $total_vente_euro += $v->montant;
                                                          $total_vente_qte += $v->qte;
                                                      }
                                                  }
                                              }
                                          }
                                      }
                                  }
                                  
                                  foreach ($factureStat as $fact) {
                                      if ($fact->$title != null) {
                                          $achats = json_decode($fact->$title);
                                          foreach ($achats as $achat) {
                                              foreach ($achat as $k => $v) {
                                                  if ($k == 'qte') {
                                                      $total_achat_qte += $v;
                                                  }
                                                  if ($k == 'montant') {
                                                      $total_achat_euro += $v;
                                                  }
                                              }
                                              # code...
                                          }
                                      }
                                  
                                      # code...
                                  }
                              @endphp
                              <tr>
                                  <td>{{ $carb->titre }}</td>
                                  <td>
                                      <div class="d-flex flex-column">
                                          <span class="text-dark">
                                              <span class="">
                                                  {{ $total_vente_qte }} Litres
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
                                                  {{ $total_achat_qte }} Litres
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
