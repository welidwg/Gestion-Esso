@extends('dashboard/base') @section('title')
    Achat cigarettes
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold"> Achat cigarettes</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('cigarette.achat_store') }}" id="add_achat_form">
                        @csrf
                        @method('PUT')
                        <div class="mb-">
                            <label class="form-label" for=""><strong>Sélectionnez les cigarettees achtetées
                                </strong></label>
                        </div>
                        <div class="row d-flex justify-content-between mb-3 p-3">
                            <div class="form-check col mb-2">
                                <select name="" class="form-select" id="type_selected">
                                    <option value="">---</option>
                                    @foreach ($cigarettes as $item)
                                        <option value="{{ str_replace(' ', '', $item->type) }}"
                                            data-pv="{{ $item->prixV }}" data-type="{{ $item->type }}"
                                            data-id="{{ $item->id }}">
                                            {{ $item->type }}
                                        </option>
                                    @endforeach
                                </select>
                                <script>
                                    $(function() {
                                        $('select').select2();
                                    });
                                </script>
                            </div>
                            <script>
                                $("#type_selected").on("change", (e) => {
                                    // console.log(e.target.value);
                                    let value = e.target.value;
                                    let pv = $('#type_selected option:selected').data('pv');;
                                    let type = $('#type_selected option:selected').data('type');
                                    let id = $('#type_selected option:selected').data('id');
                                    if (value != "") {
                                        if ($(".container-rows").find(`#row_${value}`).length > 0) {
                                            $(`#row_${value}`).remove()

                                        } else {


                                            $(".container-rows").append(`
                                        <div class="row" id="row_${value}" >
                                <div class="col-4">
                                    <div class="mb-3">
                                        <input class="form-control bg-light text-dark" type="text" required
                                            id="" placeholder="" required name="type" value="${type}"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3 ">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="0" placeholder="" required name="qte_${id}" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3  d-flex align-items-center">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="0" placeholder="" required
                                            name="prixA_${id}" />
                                              <a onclick="deletRow('row_${value}')" class="mx-2"><i class="fas fa-times text-danger"></i></a>

                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3 ">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="${pv}" placeholder="" required hidden
                                            name="prixV_${id}" />
                                    </div>
                                    
                                </div>
                                <input type="hidden" name="types[]" value="${type}">
                             
                            </div>
                                        `)
                                        }
                                    }
                                })
                            </script>


                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-">
                                    <label class="form-label" for=""><strong>Type</strong></label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb- ">
                                    <label class="form-label" for=""><strong>Quantité achetée </strong></label>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb- ">
                                    <label class="form-label" for=""><strong>Prix unitaire d'achat </strong></label>

                                </div>
                            </div>

                        </div>
                        <div class="container-rows">

                        </div>



                        <div class="mb-3 float-end">
                            <button class="btn btn-primary" type="submit">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $("#add_achat_form").on("submit", (e) => {
                // let data = new FormData()
                e.preventDefault();
                axios
                    .post(
                        $("#add_achat_form").attr("action"),
                        $("#add_achat_form").serialize()
                    )
                    .then((res) => {
                        $(".container-rows").html("");

                        Swal.fire({
                            title: "Operation Réussite !",
                            text: res.data.message,
                            icon: "success",
                            timer: 1500,
                        });
                        // $(".errors").html("");
                        $("#add_achat_form").trigger("reset");
                        setTimeout(() => {
                            @if (Auth::user()->role == 1)
                                // window.location.reload()
                            @else
                                window.location.href = "/cigarette";
                            @endif
                        }, 1500);
                    })
                    .catch((err) => {
                        let errors = err.response.data;
                        console.log(errors);
                        Swal.fire({
                            title: errors.error,
                            html: errors.message,
                            icon: "error",
                        });
                    });
            });
        </script>
        <script src="{{ asset('/js/cigarette.js') }}"></script>
    </div>
@endsection
