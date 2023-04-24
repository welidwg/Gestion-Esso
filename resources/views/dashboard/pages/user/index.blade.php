  @extends('dashboard/base')
  @section('title')
      Caissiers
  @endsection

  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold "> Vos Caissiers

              </p>

          </div>
          <div class="card-body">

              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                  <div class="d-flex flex-column  flex-md-row align-items-center">
                      <div class="col mb-3"> <a class="btn shadow-sm rounded-3 bg-gradient-light text-dark"
                              href="{{ route('view.add_user') }}"><i class="fal fa-user-plus"></i>
                              Ajoutez un utilisateur</a></div>
                      <div class="col mb-3"><a class="btn shadow-sm rounded-3 bg-gradient-success text-white"
                              href="{{ route('caissier.hours') }}"><i class="fal fa-clock"></i>
                              Heures du travail / mois</a></div>

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
                                              id="form_delete_user{{ $user->id }}">
                                              @method('DELETE')
                                              @csrf
                                              <a href="{{ route('user.rapport', $user->id) }}"
                                                  class="btn shadow-sm rounded-3">Rapport mensuel</a>
                                              <a href="{{ route('user.show', $user->id) }}"
                                                  class="btn shadow-sm rounded-3">Modifier</a>
                                              <a class="btn bg-transparent shadow-sm rounded-3 border-none"
                                                  id="delete_user{{ $user->id }}">Supprimer</a>
                                          </form>
                                      </div>
                                  </td>
                                  <script>
                                      $("#delete_user{{ $user->id }}").on('click', () => {
                                          Swal.fire({
                                              title: 'Vous êtes sûr ?',
                                              text: "",
                                              icon: 'warning',
                                              html: "<p>Lorsque vous supprimez un utilisateur , toutes <strong>les relevés</strong> ajoutées par lui seront <span class='text-danger'>supprimées déffinitivement!</span></p>",
                                              showCancelButton: true,
                                              confirmButtonColor: '#d33',
                                              cancelButtonColor: '#3085d6',
                                              confirmButtonText: 'Confirmer',
                                              cancelButtonText: 'Annuler'
                                          }).then((result) => {
                                              if (result.isConfirmed) {
                                                  $("#form_delete_user{{ $user->id }}").bind().submit()
                                              }
                                          })

                                      })
                                      $("#form_delete_user{{ $user->id }}").on("submit", (e) => {
                                          e.preventDefault();
                                          axios.delete(e.target.action)
                                              .then(res => {
                                                  Swal.fire("Suppression réussite !", "", "success")
                                                  console.log(res)
                                              })
                                              .catch(err => {
                                                  console.error(err);
                                              })
                                      });
                                  </script>
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
