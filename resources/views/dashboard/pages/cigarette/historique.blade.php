  @extends('dashboard/base')
  @section('title')
      Historique achat cigarettes
  @endsection
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold fs-5"> Historique achat cigarettes

              </p>


          </div>
          <div class="card-body">

              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                  <table class="table my-0" id="table_index_cigars" style="table-layout: fixed;width: 100%">
                      <thead>
                          <tr>
                              <th>Date d'achat</th>
                              {{-- <th>Total (€) </th> --}}
                              <th>Achat </th>

                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($cigarettes as $cigar)
                              @php
                                  $achat = json_decode($cigar->achat);
                              @endphp
                              <tr>
                                  <td>{{ $cigar->date_achat }}</td>
                                  {{-- <td>{{ $cigar->total }}</td> --}}
                                  <td>
                                      @foreach ($achat as $item)
                                          @foreach ($item as $k => $v)
                                              <div class="accordion  w-100 w-md-50" id="acc{{ $cigar->id }}">
                                                  <div class="accordion-item">
                                                      <h2 class="accordion-header" id="headingOne">
                                                          <button class="accordion-button collapsed" type="button"
                                                              data-bs-toggle="collapse"
                                                              data-bs-target="#collapse{{ $cigar->id }}" aria-expanded=""
                                                              aria-controls="collapseOne">
                                                              {{ $k }}
                                                          </button>
                                                      </h2>
                                                      <div id="collapse{{ $cigar->id }}"
                                                          class="accordion-collapse collapse " aria-labelledby=""
                                                          data-bs-parent="#acc{{ $cigar->id }}">
                                                          <div class="accordion-body w-100">
                                                              <div class="row">
                                                                  <div class="col"><span class="fw-bold">Quantité
                                                                          :</span> <br class="d-md-none">
                                                                      {{ $v->qte }}
                                                                  </div>
                                                                  <div class="col"><span class="fw-bold">Prix
                                                                          achat:</span>
                                                                      <br class="d-md-none">{{ round($v->prixA, 2) }}
                                                                      €
                                                                  </div>
                                                                  <div class="col"><span class="fw-bold">Total :</span>
                                                                      <br class="d-md-none">
                                                                      {{ $cigar->total }} €
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>


                                              </div>
                                          @endforeach
                                      @endforeach
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
