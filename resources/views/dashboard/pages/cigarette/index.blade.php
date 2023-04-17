  @extends('dashboard/base')
  @section('title')
      Cigarettes
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold "> Cigarettes

              </p>
              <div class="dropdown no-arrow  ">
                  <button class="btn  btn-sm dropdown-toggle mx-3 float-end" aria-expanded="false" data-bs-toggle="dropdown"
                      type="button">

                      <i class="fas fa-bars text-dark-400"></i> Menu
                  </button>
                  <div class="dropdown-menu shadow dropdown-menu-start animated--fade-in">

                      <p class="text-center dropdown-header">Menu cigarettes</p>
                      <a class="dropdown-item " href="{{ route('cigarette.create') }}"><i class="fas fa-plus"></i>
                          Nouveau
                          type</a>
                      <a class="dropdown-item " href="{{ route('cigarette.achat') }}"><i class="fas fa-plus"></i>
                          Nouvelle
                          achat</a>
                      <a class="dropdown-item " href="{{ route('cigarette.historique') }}"><i class="fas fa-search"></i>
                          Historique achat</a>

                      <div class="dropdown-divider"></div>
                      {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                  </div>
              </div>
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
                  <table class="table my-0" id="table_index_cigars">
                      <thead>
                          <tr>
                              <th>Type</th>
                              <th>Quantité</th>
                              <th>Prix d'achat unitaire (€)</th>
                              <th>Prix du vente unitaire (€)</th>
                              <th>Valeur du stock (€)</th>
                              <th>Action</th>

                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($cigarettes as $cigar)
                              <tr>
                                  <td>{{ $cigar->type }}</td>
                                  <td>{{ $cigar->qte }}</td>
                                  <td>{{ $cigar->prixA }}</td>
                                  <td>{{ $cigar->prixV }}</td>
                                  <td>{{ $cigar->prixV * $cigar->qte }}</td>

                                  <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          <form action="{{ route('cigarette.destroy', $cigar->id) }}" method="POST"
                                              class="">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('cigarette.prixV', $cigar->id) }}"><i
                                                      class="fas fa-edit text-info"></i></a>

                                              <button type="submit" class="btn bg-transparent border-none"
                                                  id="delete_cigar{{ $cigar->id }}"
                                                  onclick="return confirm('Vous êtes sur ?')"><i
                                                      class="fas fa-trash text-danger"></i></button>
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
              $('#table_index_cigars').DataTable({
                  order: []
              });
          });
      </script>
      <script src="{{ asset('/js/cigarettes.js') }}"></script>
  @endsection
