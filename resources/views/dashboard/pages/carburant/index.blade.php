  @extends('dashboard/base')
  @section('title')
      Carburants
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-2 d-flex  justify-content-between align-items-center ">
              <span class="text-primary m-0 fw-bold d-flex  ">Carburants
                  <div class="dropdown no-arrow  ">
                      <button class="btn  btn-sm dropdown-toggle mx-3 float-end" aria-expanded="false"
                          data-bs-toggle="dropdown" type="button">

                          <i class="fas fa-bars text-dark-400"></i> Menu
                      </button>
                      <div class="dropdown-menu shadow dropdown-menu-start animated--fade-in">

                          <p class="text-center dropdown-header">Menu carburant</p>
                          <a class="dropdown-item " href="{{ route('carburant.create') }}"><i class="fas fa-plus"></i>
                              Nouveau
                              produit</a>
                          <a class="dropdown-item" href="{{ route('carburant.prix') }}"><i class="fas fa-pen"></i>
                              Modifier
                              prix d'achat</a>
                          <a class="dropdown-item text-success fw-bold" href="{{ route('carburant.prixV') }}"><i
                                  class="fas fa-pen"></i>
                              Modifier
                              prix de vente</a>
                          <a class="dropdown-item" href="{{ route('carburant.seuil') }}"><i class="fas fa-pen"></i>
                              Modifier
                              seuil absolu</a>
                          <a class="dropdown-item" href="{{ route('carburant.jauge') }}"><i class="fas fa-pen"></i>
                              Modifier
                              Jauge</a>
                          <a class="dropdown-item" href="{{ route('carburant.marge') }}"><i class="fas fa-pen"></i>
                              Modifier
                              Marge</a>
                          <div class="dropdown-divider"></div>
                          {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                      </div>
                  </div>
              </span>
              <button class="btn shadow-sm rounded-4    mx-md-4" id="maj"><i class="far fa-cog"></i>
                  Mise à jour du seuil calculé par semaine</button>
              <script>
                  $("#maj").on("click", () => {
                      axios.post("{{ route('carburant.majSeuilCalcule') }}")
                          .then(res => {
                              console.log(res)
                              Swal.fire({
                                  title: `Opération réussite`,
                                  text: "Seuil par semaine est mis à jour. ",
                                  icon: "success",
                              });
                              setTimeout(() => {
                                  window.location.reload()
                              }, 700);
                          })
                          .catch(err => {
                              console.error(err);
                              Swal.fire({
                                  title: `Opération échouée`,
                                  text: "Erreur de serveur , veuillez réssayer plus tard. ",
                                  icon: "error",
                              });
                          })
                  })
              </script>

              <div class=" row d-flex align-items-center justify-content-start">



                  {{-- <a class="btn shadow-sm rounded-4  mb-3 col-md-2 mx-md-2" href="{{ route('carburant.seuil') }}"><i
                          class="fas fa-pen"></i>
                      Modifier
                      seuil</a> --}}
                  {{-- <a class="btn shadow-sm rounded-4  mb-3 col-md-2 mx-md-2" href="{{ route('carburant.jauge') }}"><i
                          class="fas fa-pen"></i>
                      Modifier
                      Jauge</a> --}}
                  {{-- <a class="btn shadow-sm rounded-4  mb-3 col-md-2 mx-md-2" href="{{ route('carburant.marge') }}"><i
                          class="fas fa-pen"></i>
                      Modifier
                      Marge</a> --}}
              </div>
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
                              <th>Seuil absolu</th>
                              <th>Seuil calculé</th>

                              <th>Valeur de stock</th>
                              {{-- <th>Action</th> --}}
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
                                  <td>{{ $carburant->seuilA }}</td>
                                  <td>{{ $carburant->seuil }}</td>
                                  <td>{{ $carburant->valeur_stock . '€' }}</td>
                                  {{-- <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          <a href=""><i class="fas fa-trash text-danger"></i></a>
                                      </div>
                                  </td> --}}
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
