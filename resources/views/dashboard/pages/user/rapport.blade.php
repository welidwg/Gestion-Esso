  @extends('dashboard/base')
  @section('title')
      Rapport mensuel
  @endsection
  @php
      use App\Models\User;
      use App\Models\Releve;
      $user = User::find($id);
      $releves = Releve::where('user_id', $id)
          ->whereMonth('date_systeme', date('m'))
          ->whereYear('date_systeme', date('Y'))
          ->get();
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold fs-5"> Rapport mensuel du {{ $user->nom }} ({{ $user->code }})

              </p>
              {{-- <a class="btn shadow-sm rounded-4 mx-3" href="{{ route('carburant.create') }}"><i class="fas fa-plus"></i>
                  Nouveau
                  produit</a>
              <a class="btn shadow-sm rounded-4 mx-3" href="{{ route('carburant.create') }}"><i class="fas fa-pen"></i>
                  Modifier
                  seuil</a>
              <a class="btn shadow-sm rounded-4 mx-3" href="{{ route('carburant.create') }}"><i class="fas fa-pen"></i>
                  Modifier
                  Jauge</a> --}}
          </div>
          <div class="card-body">

              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                  <div class="d-flex align-items-center justify-content-center">
                      <div class="col-md-6 d-flex align-items-center">
                          <label for="" class=" w-50">Choisissez le mois : </label>
                          <input type="month" name="" class="form-control " id="mois"
                              value="{{ date('Y-m') }}">
                          <div id="spinner" class="spinner-border mx-2 spinner-border-sm text-success" role="status"
                              style="display: none">
                              <span class="sr-only">Loading...</span>
                          </div>

                      </div>
                  </div>
                  <table class="table my-0" id="table_rapport_mensuel">
                      <thead>
                          <tr>
                              <th>Date</th>
                              <th>Total recette</th>
                              <th>Différence</th>

                          </tr>
                      </thead>
                      <tbody id="tbody">
                          @foreach ($releves as $releve)
                              <tr
                                  @if ($releve->diff != '0') style='background-color:rgba(255,0,0,0.3)' @else style='background-color:rgba(0,255,0,0.3)' @endif>
                                  <td>{{ $releve->date_systeme }}</td>
                                  <td>{{ $releve->totalSaisie }}</td>
                                  <td>{{ $releve->diff }}</td>
                              </tr>
                          @endforeach


                      </tbody>

                  </table>
                  <script>
                      $("#mois").on("change", (e) => {
                          console.log(e.target.value);
                          $("#spinner").fadeIn()
                          let green = "rgba(0,255,0,0.3)"
                          let red = "rgba(255,0,0,0.3)"
                          var table = $('#table_rapport_mensuel').DataTable();
                          axios.get(`/releve/${e.target.value}/{{ $id }}`)
                              .then(res => {
                                  $("#tbody").html(``)
                                  $("#spinner").fadeOut()
                                  if (res.data.length !== 0) {
                                      table.destroy();
                                      res.data.map((releve, index) => {

                                          console.log(releve);

                                          $("#tbody").append(`
                                          <tr style="background-color:${releve.diff==0 ? green : red}"  >
                                  <td>${releve.date_systeme}</td>
                                  <td>${releve.totalSaisie}</td>
                                  <td>${releve.diff}</td>
                              </tr>
                                          `)
                                      })
                                  } else {
                                      table.destroy();
                                      $("#tbody").html(``)
                                  }
                                  $('#table_rapport_mensuel').DataTable();

                              })
                              .catch(err => {

                                  $("#spinner").fadeOut()

                                  console.error(err);
                              })

                      })
                  </script>
              </div>

          </div>
      </div>
      <script>
          $(document).ready(function() {
              $('#table_rapport_mensuel').DataTable();
          });
      </script>
      {{-- <script src="{{ asset('/js/releve.js') }}"></script> --}}
  @endsection
