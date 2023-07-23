  @extends('dashboard/base')
  @section('title')
      Commande
  @endsection
  @php
      use Carbon\Carbon;
  @endphp
  @section('content')
      <div class="card shadow">
          <div class="card-header py-3 d-flex align-items-center justify-content-start">
              <p class="text-primary m-0 fw-bold"> Commande

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

              <div class="table-responsive table mt-2 border-0 " role="grid" aria-describedby="">
                  <table class="table my-0 " id="">
                      <thead>
                          <tr>
                              <th></th>
                              @foreach ($carburants as $carb)
                                  <th>{{ $carb->titre }}</th>
                              @endforeach
                          </tr>
                      </thead>
                      <tbody class="">
                          <tr>
                              <td class="fw-bold">Stock actuel (litres)</td>
                              @foreach ($carburants as $carb)
                                  <td><span
                                          class="badge {{ $carb->qtiteStk <= 0 ? 'text-bg-warning' : 'text-bg-primary' }}">{{ $carb->qtiteStk }}</span>
                                  </td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="fw-bold">Moyenne de consommation par jour (litres)</td>
                              @foreach ($carburants as $carb)
                                  @if ($moyennes[$carb->titre] != 0)
                                      <td class=""> <span
                                              class="badge text-light bg-info">{{ round($moyennes[$carb->titre], 2) }}</span>
                                      </td>
                                  @else
                                      <td>-</td>
                                  @endif
                              @endforeach
                          </tr>
                          <tr>
                              <td class="fw-bold ">Stock nécessaire pour une semaine (litres)</td>
                              @foreach ($carburants as $carb)
                                  @php
                                      
                                      $week = $moyennes[$carb->titre] * 7;
                                  @endphp
                                  <td><span class="badge text-light bg-success">{{ round($week, 2) }}</span></td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="fw-bold">Quantité manquante (litres)</td>
                              @foreach ($carburants as $carb)
                                  @php
                                      
                                      $week = $moyennes[$carb->titre] * 7;
                                      $qte = round($week - $carb->qtiteStk, 2);
                                  @endphp
                                  @if ($qte > 0)
                                      <td class=""> <span class="badge text-bg-danger ">
                                              {{ round($qte, 2) }}</span>
                                      </td>
                                  @else
                                      <td>-</td>
                                  @endif
                              @endforeach
                          </tr>
                          <tr>
                              <td class="fw-bold"> Dernière commande ({{ $facture->date_facture }})
                              </td>
                              @foreach ($carburants as $carb)
                                  @php
                                      $title = $carb->titre;
                                  @endphp
                                  @if ($facture->$title != null)
                                      @php
                                          $data = json_decode($facture->$title);
                                      @endphp
                                      <td>{{ $data[0]->qte }} Litres</td>
                                  @else
                                      <td>0</td>
                                  @endif
                              @endforeach
                          </tr>
                      </tbody>

                  </table>
              </div>

          </div>
      </div>
  @endsection
