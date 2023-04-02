@extends('layouts.app')

@section('template_title')
    Carburant
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Carburant') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('carburants.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Titre</th>
										<th>Prixa</th>
										<th>Prixv</th>
										<th>Qtitestk</th>
										<th>Qtitejg</th>
										<th>Seuil</th>
										<th>Valeur Stock</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carburants as $carburant)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $carburant->titre }}</td>
											<td>{{ $carburant->prixA }}</td>
											<td>{{ $carburant->prixV }}</td>
											<td>{{ $carburant->qtiteStk }}</td>
											<td>{{ $carburant->qtiteJg }}</td>
											<td>{{ $carburant->seuil }}</td>
											<td>{{ $carburant->valeur_stock }}</td>

                                            <td>
                                                <form action="{{ route('carburants.destroy',$carburant->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('carburants.show',$carburant->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('carburants.edit',$carburant->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $carburants->links() !!}
            </div>
        </div>
    </div>
@endsection
