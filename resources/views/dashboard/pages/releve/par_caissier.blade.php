  @extends('dashboard/base')
  @section('title')
      Journal caisse par caissier
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold fs-5"> Journal caisse par caissier

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
                  <table class="table my-0" id="table_index_releve">
                      <thead>
                          <tr>
                              <th>Code caisser</th>
                              <th>Nom Caissier</th>
                              <th>Total saisie</th>
                              <th>Total rapport</th>
                              <th>Différence</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($releves as $releve)
                              <tr>
                                  <td>{{ $releve->caissier->code }}</td>
                                  <td>{{ $releve->caissier->nom }}</td>
                                  <td>{{ $releve->totalSaisie }}</td>
                                  <td>{{ $releve->totalPdf }}</td>
                                  <td>{{ $releve->diff }}</td>
                                  <td>
                                      <div class="d-flex flex-row justify-content-evenly align-items-center">
                                          <form action="{{ route('releve.destroy', $releve->id) }}" method="POST">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('releve.show', $releve->id) }}"><i
                                                      class="fas fa-eye text-info"></i></a>
                                              <button type="submit" class="btn bg-transparent border-none"
                                                  id="delete_releve{{ $releve->id }}"
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
              $('#table_index_releve').DataTable();
          });
      </script>
      <script src="{{ asset('/js/releve.js') }}"></script>
  @endsection
