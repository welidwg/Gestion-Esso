$("#add_facture_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .post(
            $("#add_facture_form").attr("action"),
            $("#add_facture_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                tile: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            // $(".errors").html("");
            $("#add_facture_form").trigger("reset");
            $(".container-rows").html("");
            console.log(res);

            // $("#add_kiosque_form").trigger("reset");
            // setTimeout(() => {
            //     window.location.href = "/main";
            // }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);

            // $("#errors").html(errors.message);
        });
});
$("#date_arrivage").on("change", function () {
    var dateStr = $(this).val();
    var date = new Date(dateStr);
    if (isNaN(date.getTime())) {
        // alert("Invalid date format, please enter a valid date.");
        $(".container-rows").html("");
    } else {
        axios
            .get(`/checkFacture/${dateStr}`)
            .then((res) => {
                res.data.carburants.map((item, index) => {
                    res.data.facture.map((fact, ind) => {
                        if (fact.hasOwnProperty(item.titre)) {
                            let data = JSON.parse(fact[item.titre]);
                            if (data && data.length > 0) {
                                console.log(data);
                                $(" #" + item.titre + "_checked").attr(
                                    "checked",
                                    true
                                );
                                $(".container-rows").append(`
                              <div class="row row${item.titre}" id="row${
                                    item.titre
                                }"  >
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <input class="form-control bg-light text-dark" type="text" required
                                                        id="" placeholder="" name="titre" value="${
                                                            item.titre
                                                        }"
                                                        readonly required />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01" required
                                                        id="" value="${parseFloat(
                                                            data[0].prixAHT
                                                        ).toFixed(
                                                            3
                                                        )}" placeholder="" required
                                                        name="prixA_${
                                                            item.id
                                                        }" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01" required
                                                        id="" value="${
                                                            data[0].qte
                                                        }" placeholder="" name="qte_${
                                    item.titre
                                }" />
                                                </div>
                                            </div>
                                        </div>`);
                            }
                        }
                    });
                });
                $(".container-rows").append(
                    `<span class="text-dark text-center">Ajouté par le caissier : ${res.data.facture[0].caissier.nom} (${res.data.facture[0].caissier.code})</span>`
                );
            })
            .catch((err) => {
                $(".container-rows").html("");
                console.error(err);
            });
    }
});
