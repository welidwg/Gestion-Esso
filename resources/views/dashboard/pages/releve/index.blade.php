  @extends('dashboard/base')
  @section('title')
      Journal caisse
  @endsection
  @php
      use Carbon\Carbon;
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold"> Journal caisse

              </p>
              <a class="btn shadow-sm rounded-4 mx-3" href="#" id="rapportMensuel"><i class="fas fa-file"></i>
                  Rapport mensuel</a>
              <script>
                  $("#rapportMensuel").on("click", (e) => {
                      Swal.fire({
                          title: "Choisissez le mois",
                          html: `
    <input
      type="month"
      value=""
      step=""
      class="swal2-input"
      id="monthOfRapport">`,
                          showCancelButton: true,
                          confirmButtonText: "Générer",
                          cancelButtonText: "Annuler",
                      }).then((result) => {
                          if (result.isConfirmed) {
                              let date = $("#monthOfRapport").val();
                              window.location.href = `/rapport?date=${date}`;

                          } else {
                              console.log("err");
                          }
                      });
                  })
              </script>
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

              <div class="table-responsive table mt-2 border-0" role="grid" aria-describedby="">
                  <table class="table my-0 " id="table_index_releve">
                      <thead>
                          <tr>
                              <th>Id</th>
                              <th>Date</th>
                              <th>Heure debut</th>
                              <th>Heure fin</th>
                              <th>Caissier</th>
                              <th>Total heures</th>
                              <th>Total Saisie</th>
                              <th>Total Rapport</th>
                              <th>Différence</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody class="">
                          @php
                              $prevDate = $releves->first()->date_systeme;
                          @endphp
                          @foreach ($releves as $releve)
                              @php
                                  $currentDate = $releve->date_systeme;
                                  
                              @endphp
                              <tr
                                  @if ($releve->diff != '0') style='background-color:rgba(255,0,0,0.2)' @else style='background-color:rgba(0,255,0,0.2)' @endif>
                                  <td
                                      @if ($prevDate != $currentDate) class="border-top-check" @php
                                                                        $prevDate = $releve->date_systeme;

                                  @endphp @endif>
                                      {{ $releve->id }}</td>
                                  <td>{{ $releve->date_systeme }}</td>
                                  <td>{{ date('H:i', strtotime($releve->heure_d)) }}</td>
                                  <td>{{ date('H:i', strtotime($releve->heure_f)) }}</td>
                                  <td>{{ $releve->caissier->nom }}</td>

                                  <td>
                                      @php
                                          $start = Carbon::parse($releve->heure_d);
                                          $end = Carbon::parse($releve->heure_f);
                                          $duration = $end->diffInMinutes($start);
                                          $hours = floor($duration / 60);
                                          $minutes = $duration - $hours * 60;
                                      @endphp
                                      {{ $hours . ' heures et ' . $minutes . ' mins' }}
                                  </td>
                                  <td>{{ $releve->totalSaisie }}</td>
                                  <td>{{ $releve->totalPdf }}</td>
                                  <td>{{ $releve->diff }}</td>
                                  <td>
                                      <div class="">
                                          <form action="{{ route('releve.destroy', $releve->id) }}" method="POST"
                                              class="d-flex flex-row justify-content-start align-items-center">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('releve.show', $releve->id) }}"><i
                                                      class="fas fa-eye text-primary"></i></a>
                                              <button type="submit" class="btn bg-transparent border-none"
                                                  id="delete_releve{{ $releve->id }}"
                                                  onclick="return confirm('Vois etes sur ?')"><i
                                                      class="fas fa-times text-danger"></i></button>
                                          </form>
                                      </div>
                                  </td>
                              </tr>
                          @endforeach


                      </tbody>

                  </table>
              </div>

          </div>
      </div>
      <script>
          $(document).ready(function() {
              $('#table_index_releve').DataTable({
                  "order": []
              });
          });
      </script>
      <script src="{{ asset('/js/releve.js') }}"></script>
  @endsection
