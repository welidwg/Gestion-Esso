$("#add_facture_form").on("submit", (e) => {
    let total = parseFloat($("#montant_facture").val());
    let compte = parseFloat($("#montant_facture").attr("max"));
    console.log(total);
    e.preventDefault();
    if (total == 0) {
        Swal.fire(
            "Erreur !",
            "Il faut calculer le montant total !<br> Appuyez sur <i class='fas fa-calculator text-primary'></i> afin de le calculer.",
            "error"
        );
    } else if (total > compte) {
        Swal.fire({
            title: "Solde insuffisant !",
            text: " Votre solde actuel est " + compte,
            icon: "error",
            timer: 5000,
        });
    } else {
        axios
            .post(
                $("#add_facture_form").attr("action"),
                $("#add_facture_form").serialize()
            )
            .then((res) => {
                console.log(res);

                Swal.fire({
                    title: "Operation Réussite !",
                    text: res.data.message,
                    icon: "success",
                    timer: 1500,
                });
                // $(".errors").html("");
                $("#add_facture_form").trigger("reset");
                $(".container-rows").html("");
                $(".caissier").html("");

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
                Swal.fire({
                    title: "Operation Echouée !",
                    text: errors.message,
                    icon: "error",
                    timer: 3000,
                });

                // $("#errors").html(errors.message);
            });
    }
});
let montant_total = 0;
$("#date_arrivage").on("change", function () {
    var dateStr = $(this).val();
    var date = new Date(dateStr);
    $("input[type=checkbox]").attr("checked", false);

    if (isNaN(date.getTime())) {
        // alert("Invalid date format, please enter a valid date.");
        $(".container-rows").html("");
        $(".caissier").html("");
    } else {
        axios
            .get(`/checkFacture/${dateStr}`)
            .then((res) => {
                $(".caissier").html("");
                $(".container-rows").html("");
                res.data.facture.map((fact, index) => {
                    res.data.carburants.map((item, ind) => {
                        if (fact[item.titre] !== 0) {
                            $(" #" + item.titre + "_checked").attr(
                                "checked",
                                true
                            );

                            $(".container-rows").append(`
                              <div class="row row${item.titre}" id="row${
                                item.titre
                            }"  >
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <input class="form-control bg-light text-dark" type="text" required
                                                        id="" placeholder="" name="titre[]" value="${
                                                            item.titre
                                                        }"
                                                        readonly required />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark "  type="number" step="0.01" required
                                                        id="prixA_${
                                                            item.id
                                                        }" value="0" placeholder="" required min="1"
                                                        name="prixA_${
                                                            item.id
                                                        }" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark  bg-light" readonly type="number" step="0.01" required
                                                        id="qte_${
                                                            item.id
                                                        }" value="${
                                fact[item.titre]
                            }" name="qte_${item.id}" />
                                                </div>
                                            </div>
                                             <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark  bg-light" readonly type="number" step="0.01" required
                                                        id="prix_u_ht_${
                                                            item.id
                                                        }" value="0" placeholder="" required
                                                        name="prix_u_ht_${
                                                            item.id
                                                        }" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark  bg-light" readonly type="number" step="0.01" required
                                                        id="prix_u_ttc_${
                                                            item.id
                                                        }" value="0" placeholder="" required
                                                        name="prix_u_ttc_${
                                                            item.id
                                                        }" />
                                                </div>
                                            </div>
                                               <div class="col-md-2">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark champMontant  bg-light" readonly type="number" step="0.01" required
                                                        id="montant_ttc_${
                                                            item.id
                                                        }" value="0" placeholder="" required
                                                        name="montant_ttc_${
                                                            item.id
                                                        }" />
                                                </div>
                                            </div>
                                            <input type="hidden" name="tva[]" id="tva_${
                                                item.id
                                            }" />
                                            
                                        </div>`);

                            $(`#prixA_${item.id}`).on("input", (e) => {
                                if (
                                    !isNaN(
                                        e.target.value && e.target.value != 0
                                    )
                                ) {
                                    $(`#prix_u_ht_${item.id}`).val(
                                        parseFloat(
                                            e.target.value / 1000
                                        ).toFixed(2)
                                    );

                                    $(`#prix_u_ttc_${item.id}`).val(
                                        parseFloat(
                                            $(`#prix_u_ht_${item.id}`).val() *
                                                1.2
                                        ).toFixed(2)
                                    );

                                    const tva = 1.2;

                                    $(`#montant_ttc_${item.id}`).val(
                                        parseFloat(
                                            $(`#qte_${item.id}`).val() *
                                                $(
                                                    `#prix_u_ttc_${item.id}`
                                                ).val()
                                        ).toFixed(2)
                                    );
                                    $(`#tva_${item.id}`).val(
                                        parseFloat(
                                            $(`#qte_${item.id}`).val() *
                                                $(
                                                    `#prix_u_ht_${item.id}`
                                                ).val() *
                                                0.2
                                        ).toFixed(2)
                                    );
                                }
                            });
                        }
                    });
                });
                $(".caissier").append(
                    `<span class="text-dark text-center">Ajouté par le caissier : ${res.data.facture[0].caissier.nom} (${res.data.facture[0].caissier.code})</span>`
                );
            })
            .catch((err) => {
                $(".caissier").html("");
                $(".container-rows").html("");
                $("input[type=checkbox]").attr("checked", false);

                console.error(err);
            });
    }
});
$("#calculetotal").on("click", () => {
    montant_total = 0;
    var values = $(".champMontant")
        .map(function () {
            montant_total += parseFloat($(this).val());
            return $(this).val();
        })
        .get();
    $("#montant_facture").val(montant_total);
});
// setInterval(() => {

// }, 700);
