  @extends('dashboard/base')
  @section('title')
      Carburants
  @endsection
  @php
      use App\Models\Releve;
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-2 d-flex flex-column flex-md-row justify-content-between align-items-center ">
              <div class="text-primary m-0 fw-bold d-flex  ">Carburants
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
              </div>
              <button class="btn shadow-sm rounded-4 " id="maj"><i class="far fa-cog"></i>
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
                              <th class="d-none d-md-table-cell">Prix d'achat</th>
                              <th class="d-none d-md-table-cell">Prix de vente</th>
                              <th class="d-none d-md-table-cell">Marge</th>
                              <th>Quantite de stock</th>
                              <th class="d-none d-md-table-cell">Quantite de jauge</th>
                              <th class="d-none d-md-table-cell">Seuil absolu</th>
                              <th class="d-none d-md-table-cell">Seuil calculé</th>
                              <th class="d-none d-md-table-cell">Valeur de stock</th>
                              <th>Action</th>
                              {{-- <th>Action</th> --}}
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($carburants as $carburant)
                              @php
                                  $id = $carburant->id;
                              @endphp
                              <tr>
                                  <td>{{ $carburant->titre }}</td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->prixA . ' €' }}</td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->prixV . ' €' }}</td>
                                  <td class="d-none d-md-table-cell"> {{ $carburant->marge_beneficiere * 100 . ' %' }}</td>
                                  <td>
                                      @if ($carburant->qtiteStk <= $carburant->seuil)
                                          <span class="badge bg-danger">{{ $carburant->qtiteStk }}</span>
                                      @else
                                          {{ $carburant->qtiteStk }}
                                      @endif
                                  </td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->qtiteJg }}</td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->seuilA }}</td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->seuil }}</td>
                                  <td class="d-none d-md-table-cell">{{ $carburant->valeur_stock . '€' }}</td>
                                  <td><a class="btn btn-sm bg-gradient-success text-light rounded-5 d-none d-md-block"
                                          href="#offcanvasExample{{ $carburant->id }}" data-bs-toggle="offcanvas">Recette /
                                          mois</a>
                                      <a class="btn btn-sm bg-gradient-primary text-light rounded-5 d-block d-md-none"
                                          href="#detailsCarburant{{ $carburant->id }}"
                                          data-bs-toggle="offcanvas">Détails</a>
                                  </td>
                                  {{-- <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          <a href=""><i class="fas fa-trash text-danger"></i></a>
                                      </div>
                                  </td> --}}
                              </tr>
                              <div class="offcanvas offcanvas-start text-dark" tabindex="-1"
                                  id="detailsCarburant{{ $carburant->id }}" aria-labelledby="detailsCarburant">
                                  <div class="offcanvas-header">
                                      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Détails du :
                                          <strong>{{ $carburant->titre }}</strong>
                                      </h5>
                                      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                          aria-label="Close"></button>
                                  </div>
                                  <div class="offcanvas-body">
                                      <div class="d-flex flex-column align-items-start w-100">
                                          <div class="mb-2">
                                              <span class="fw-bold">Quantité stock :</span>
                                              {{ $carburant->qtiteStk . ' Litres' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Jauge :</span> {{ $carburant->qtiteJg . ' Litres' }}
                                          </div>

                                          <div class="mb-2">
                                              <span class="fw-bold">Prix d'achat :</span> {{ $carburant->prixA . ' €' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Prix de vente :</span> {{ $carburant->prixV . ' €' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Marge :</span>
                                              {{ $carburant->marge_beneficiere * 100 . ' %' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Seuil absolue :</span>
                                              {{ $carburant->seuilA . ' Litres' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Seuil calculé :</span>
                                              {{ $carburant->seuil . ' Litres' }}
                                          </div>
                                          <div class="mb-2">
                                              <span class="fw-bold">Valeur du stock :</span>
                                              {{ $carburant->valeur_stock . ' €' }}
                                          </div>
                                          <div class="mb-2 mt-3 mx-auto">
                                              <a class="btn btn-sm bg-gradient-success text-light rounded-5"
                                                  href="#offcanvasExample{{ $carburant->id }}"
                                                  data-bs-toggle="offcanvas">Recette /
                                                  mois</a>
                                          </div>

                                      </div>
                                  </div>
                              </div>

                              <div class="offcanvas offcanvas-start text-dark" tabindex="-1"
                                  id="offcanvasExample{{ $carburant->id }}" aria-labelledby="offcanvasExampleLabel">
                                  <div class="offcanvas-header">
                                      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Recette par mois :
                                          <strong>{{ $carburant->titre }}</strong>
                                      </h5>
                                      <button type="button" class="btn-close text-reset d-none d-md-block"
                                          data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                      <button type="button" class="btn-close text-reset d-block d-md-none"
                                          href="#detailsCarburant{{ $carburant->id }}"
                                          data-bs-toggle="offcanvas"></button>
                                  </div>
                                  <div class="offcanvas-body">
                                      <div>
                                          @php
                                              $rels = Releve::whereMonth('date_systeme', date('m'))
                                                  ->whereYear('date_systeme', date('Y'))
                                                  ->get();
                                              $rec = 0;
                                              $qte = 0;
                                              foreach ($rels as $rel) {
                                                  $ventes = json_decode($rel->vente);
                                                  foreach ($ventes as $vente) {
                                                      foreach ($vente as $key => $value) {
                                                          if ($key == $carburant->titre) {
                                                              $rec += $value->montant;
                                                              $qte += $value->qte;
                                                          }
                                                      }
                                                  }
                                              }
                                          @endphp
                                          <div class="mb-3">
                                              <label class="form-label" for=""><strong>Choisissez le
                                                      mois</strong>
                                              </label>
                                              <div id="spinner{{ $id }}"
                                                  class="spinner-border mx-2 spinner-border-sm text-success"
                                                  role="status" style="display: none">
                                                  <span class="sr-only">Loading...</span>
                                              </div>
                                              <input class="form-control  text-dark" type="month" required
                                                  id="mois{{ $id }}" placeholder="" name="date1"
                                                  value="{{ date('Y-m') }}" />
                                              <script>
                                                  $("#mois{{ $id }}").change((e) => {
                                                      $("#spinner{{ $id }}").fadeIn();
                                                      axios.get("{{ route('carburant.ventes', $id) }}", {
                                                              params: {
                                                                  date: e.target.value
                                                              }
                                                          })
                                                          .then(res => {

                                                              $("#container{{ $id }}").html("")
                                                              $("#container{{ $id }}").append(`
                                                              <h5><strong>Recette :</strong> <span>${parseFloat(res.data.rec).toFixed(2)} €</span></h5>
                                          <h5><strong>Quantité vendue :</strong>  <span>${parseFloat(res.data.qte).toFixed(2)} Litres</span></h5>
                                                              `)
                                                          })
                                                          .catch(err => {
                                                              console.error(err);
                                                          })
                                                      $("#spinner{{ $id }}").fadeOut();
                                                  })
                                              </script>
                                          </div>
                                      </div>
                                      <div class="row d-flex flex-row text-dark" id="container{{ $id }}">
                                          <h5><strong>Recette :</strong> <span>{{ $rec }} €</span></h5>
                                          <h5><strong>Quantité vendue :</strong> <span>{{ $qte }} Litres</span>
                                          </h5>

                                      </div>

                                  </div>
                              </div>
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
