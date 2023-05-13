let totalSaisie = 0;
let totalPdf = 0;

$("#generateTotalSaisie").on("click", (e) => {
    var totalInput = document.getElementById("totalSaisie");
    let total = 0;
    var inputs = document.getElementsByClassName("inputMontantCalcule");
    for (var i = 0; i < inputs.length; i++) {
        total += parseFloat(inputs[i].value);
    }

    totalInput.value = parseFloat(total).toFixed(2);
});
$("#generateTotalSaisiePdf").on("click", (e) => {
    var totalInput = document.getElementById("totalSaisiePdf");
    let total = 0;
    var inputs = document.getElementsByClassName("inputMontantCalculePdf");
    for (var i = 0; i < inputs.length; i++) {
        total += parseFloat(inputs[i].value);
    }

    totalInput.value = parseFloat(total).toFixed(2);
});
// Get all the input fields
// var incrementInputs = document.querySelectorAll(".inputMontantCalcule");
// var totalInput = document.querySelector("#totalSaisie");

// // Add event listeners to each input field
// incrementInputs.forEach(function (input) {
//     input.addEventListener("keyup", function (e) {
//         // Loop through all the input fields and add their values
//         incrementInputs.forEach(function (input) {
//             console.log(parseFloat(input.value));
//             if (!isNaN(parseFloat(input.value))) {
//                 totalSaisie += parseFloat(input.value);
//             }
//         });
//         // Set the total value to the total input field
//         totalInput.value = totalSaisie;
//     });
// });

setInterval(() => {
    let total1 = $("#totalSaisie").val();
    let total2 = $("#totalSaisiePdf").val();
    let inp = document.getElementById("diff");
    $("#diff").css("color", "white !important");
    $("#diff").css("background-color", "limegreen !important");

    if (total1 !== 0 && total2 !== 0) {
        let diff = parseFloat(total1 - total2).toFixed(2);
        inp.style.color = "white";

        $("#diff").val(diff);
        if (diff == 0) {
            $("#diff").css("color", "white !important");
            $("#diff").css("background-color", "limegreen !important");
            inp.style.backgroundColor = "limegreen";
        } else {
            // $("#diff").addClass("bg-danger text-white");
            inp.style.backgroundColor = "red";
        }
    }
}, 1200);

$("#add_releve_form").on("submit", (e) => {
    $("#submitBtnReleve").attr("disabled", true);
    let totalSaisie = parseFloat($("#totalSaisie").val());
    let totalSaisiePdf = parseFloat($("#totalSaisiePdf").val());
    e.preventDefault();
    $("#totalSaisiePdf").removeClass("border-danger");
    $("#totalSaisie").removeClass("border-danger");
    if (
        totalSaisie == 0 ||
        totalSaisiePdf == 0 ||
        isNaN(totalSaisie) ||
        isNaN(totalSaisiePdf)
    ) {
        if (totalSaisie == 0) {
            $("#totalSaisie").addClass("border-danger");
        }
        if (totalSaisiePdf == 0) {
            $("#totalSaisiePdf").addClass("border-danger");
        }
        Swal.fire(
            "Erreur !",
            "Il faut calculer les totaux! <br> Appuyez sur <i class='fas fa-calculator text-primary'></i> afin de les calculer.",
            "error"
        );
        $("#submitBtnReleve").attr("disabled", false);
        // Swal.fire("Erreur !", divElement, "error");
    } else {
        const divElement = document.createElement("div");
        const titleCarb = document.createElement("h5");

        const titleCigars = document.createElement("h5");

        if (carbs.length !== 0) {
            titleCarb.innerHTML = "Carburants";
            divElement.appendChild(titleCarb);
            carbs.forEach((element) => {
                let qte = $(`input[name="qte_${element.title}"]`).val();
                let montant = $(`input[name="montant_${element.title}"]`).val();

                //   console.log(
                //       element.title +
                //           " => " +
                //           $(`input[name="qte_${element.title}"]`).val() +
                //           " : " +
                //           $(`input[name="montant_${element.title}"]`).val()
                // );
                if (qte != 0) {
                    let childElement = document.createElement("p");
                    childElement.innerHTML = `<span class="fw-bold">${element.title} <i class="fas fa-long-arrow-alt-right"></i> </span> Quantité : ${qte} | Montant : ${montant}`;
                    divElement.appendChild(childElement);
                }
            });
        }

        if (cigars.length !== 0) {
            titleCigars.innerHTML = "Cigarettes";
            divElement.appendChild(titleCigars);
            cigars.forEach((element) => {
                let qte = $(`input[name="qteC_${element.id}"]`).val();
                let montant = $(`input[name="montantC_${element.id}"]`).val();

                let childElement = document.createElement("p");
                childElement.innerHTML = `<span class="fw-bold">${element.type} <i class="fas fa-long-arrow-alt-right"></i> </span> Quantité : ${qte} | Montant : ${montant}`;
                divElement.appendChild(childElement);
            });
        }

        Swal.fire({
            title: "Vous confirmez ces valeurs ?",
            text: "",
            icon: "warning",
            html: divElement,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Confirmer",
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .post("/releve", $("#add_releve_form").serialize())
                    .then((res) => {
                        Swal.fire(
                            "Operation Réussite !",
                            res.data.message + "",
                            "success"
                        );
                        setTimeout(() => {
                            window.location.href = "/caissier/releves";
                        }, 600);
                    })
                    .catch((err) => {
                        let errors = err.response.data;
                        console.log(errors);
                        Swal.fire(
                            "Operation Echouée !",
                            err.response.data.message,
                            "error"
                        );
                        $("#submitBtnReleve").attr("disabled", false);
                    });
            } else {
                $("#submitBtnReleve").attr("disabled", false);
            }
        });
    }
});
$("#edit_releve_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .put(
            $("#edit_releve_form").attr("action"),
            $("#edit_releve_form").serialize()
        )
        .then((res) => {
            Swal.fire("Operation Réussite !", res.data.message, "success");

            setTimeout(() => {
                window.location.reload();
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);
            Swal.fire(
                "Operation Echouée !",
                err.response.data.message,
                "error"
            );

            // $("#errors").html(errors.message);
        });
});
function DeleteReleve(path) {
    axios
        .delete(path)
        .then((res) => {
            // console.log(res);
            Swal.fire("Operation Réussite !", res.data.message, "success");
            // $(".errors").html("");
            // $("#add_kiosque_form").trigger("reset");
            setTimeout(() => {
                window.location.href = "/main";
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);

            // $("#errors").html(errors.message);
        });
}

function checkEcart(id_saisie, id_rapport, name) {
    let first = $("#" + id_saisie).val();
    let second = $("#" + id_rapport).val();
    $("#" + id_saisie).removeClass("border-danger text-danger");

    $("#" + id_rapport).removeClass("border-danger text-danger");
    if (!isNaN(first) && !isNaN(second)) {
        if (first !== second) {
            $("#" + id_saisie).addClass("border-danger text-danger ");

            $("#" + id_rapport).addClass("border-danger text-danger");
            console.log("====================================");
            console.log(name + " est differnent");
            console.log("====================================");
        }
    }
}
function deletRow(id) {
    $(`#${id}`).remove();
}
