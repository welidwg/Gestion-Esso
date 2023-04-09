  @extends('dashboard/base')
  @section('title')
      Caissiers
  @endsection

  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold fs-5"> Vos Caissiers

              </p>

          </div>
          <div class="card-body">

              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                  <div>
                      <a class="btn shadow-sm rounded-3" href="{{ route('caissier.hours') }}"><i class="fal fa-clock"></i>
                          Heures du travail</a>
                  </div>
                  <table class="table my-0" id="table_index_users">
                      <thead>
                          <tr>
                              <th>Code du caissier</th>
                              <th>Nom du caissier</th>
                              <th>Mot de passe</th>
                              <th>Date de création</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($users as $user)
                              <tr>
                                  <td>{{ $user->code }}</td>
                                  <td>{{ $user->nom }}</td>

                                  <td>{{ $user->plainTextPassword }}</td>
                                  <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>

                                  <td>
                                      <div class="d-flex flex-row justify-content-start align-items-center">
                                          <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                              id="form_delete_user">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('user.rapport', $user->id) }}"
                                                  class="btn shadow-sm rounded-3">Rapport mensuel</a>
                                              <a href="{{ route('user.show', $user->id) }}"
                                                  class="btn shadow-sm rounded-3">Modifier</a>
                                              <button type="submit"
                                                  class="btn bg-transparent shadow-sm rounded-3 border-none"
                                                  id="delete_user{{ $user->id }}"
                                                  onclick="return confirm('Vois etes sur ?')">Supprimer</button>
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
              $('#table_index_users').DataTable();
          });
      </script>
      <script src="{{ asset('/js/user.js') }}"></script>
  @endsection
