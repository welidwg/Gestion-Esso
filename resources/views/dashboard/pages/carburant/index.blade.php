  @extends('dashboard/base')
  @section('title')
      Carburants
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 row d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold fs-5 col">Carburants

              </p>
              <a class="btn shadow-sm rounded-4 mx-3 col" href="{{ route('carburant.create') }}"><i class="fas fa-plus"></i>
                  Nouveau
                  produit</a>
              <a class="btn shadow-sm rounded-4 mx-3 col" href="{{ route('carburant.seuil') }}"><i class="fas fa-pen"></i>
                  Modifier
                  seuil</a>
              <a class="btn shadow-sm rounded-4 mx-3 col" href="{{ route('carburant.jauge') }}"><i class="fas fa-pen"></i>
                  Modifier
                  Jauge</a>
              <a class="btn shadow-sm rounded-4 mx-3 col" href="{{ route('carburant.marge') }}"><i class="fas fa-pen"></i>
                  Modifier
                  Marge</a>
          </div>
          <div class="card-body">

              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                  <table class="table my-0" id="table_index_carb">
                      <thead>
                          <tr>
                              <th>Titre</th>
                              <th>Prix d'achat</th>
                              <th>Prix de vente</th>
                              <th>Marge</th>
                              <th>Quantite de stock</th>
                              <th>Quantite de jauge</th>
                              <th>Seuil</th>
                              <th>Seuil absolu</th>
                              <th>Valeur de stock</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($carburants as $carburant)
                              <tr>
                                  <td>{{ $carburant->titre }}</td>
                                  <td>{{ $carburant->prixA . ' €' }}</td>
                                  <td>{{ $carburant->prixV . ' €' }}</td>
                                  <td>{{ $carburant->marge_beneficiere * 100 . ' %' }}</td>
                                  <td>
                                      @if ($carburant->qtiteStk <= $carburant->seuilA + 30)
                                          <span class="badge bg-danger">{{ $carburant->qtiteStk }}</span>
                                      @else
                                          {{ $carburant->qtiteStk }}
                                      @endif
                                  </td>
                                  <td>{{ $carburant->qtiteJg }}</td>
                                  <td>{{ $carburant->seuil }}</td>
                                  <td>{{ $carburant->seuilA }}</td>
                                  <td>{{ $carburant->valeur_stock . '€' }}</td>
                                  <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          {{-- <a href=""><i class="fas fa-edit text-info"></i></a> --}}
                                          <a href=""><i class="fas fa-trash text-danger"></i></a>
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
              $('#table_index_carb').DataTable();
          });
      </script>
  @endsection
