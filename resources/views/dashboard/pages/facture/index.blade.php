  @extends('dashboard/base')
  @section('title')
      Historique factures
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold "> Historique des factures

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
                  <table class="table my-0" id="table_index_facture">
                      <thead>
                          <tr>
                              <th>Référence</th>
                              <th>Date du facture</th>
                              <th>Montant</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($factures as $facture)
                              <tr>
                                  <td>{{ $facture->ref }}</td>
                                  <td>{{ $facture->date_facture }}</td>
                                  <td>{{ $facture->montant . ' €' }}</td>

                                  <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          <form action="{{ route('facture.destroy', $facture->id) }}" method="POST"
                                              class="">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('facture.show', $facture->id) }}"><i
                                                      class="fas fa-eye text-info"></i></a>
                                              <button type="submit" class="btn bg-transparent border-none"
                                                  id="delete_facture{{ $facture->id }}"
                                                  onclick="return confirm('Vois etes sur ?')"><i
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
              $('#table_index_facture').DataTable({
                  order: []
              });
          });
      </script>
      <script src="{{ asset('/js/facture.js') }}"></script>
  @endsection
