let totalSaisie = 0;
let totalPdf = 0;

$("#generateTotalSaisie").on("click", (e) => {
    var totalInput = document.getElementById("totalSaisie");
    let total = 0;
    var inputs = document.getElementsByClassName("inputMontantCalcule");
    for (var i = 0; i < inputs.length; i++) {
        total += parseFloat(inputs[i].value);
    }

    totalInput.value = total;
    console.log(total);
});
$("#generateTotalSaisiePdf").on("click", (e) => {
    var totalInput = document.getElementById("totalSaisiePdf");
    let total = 0;
    var inputs = document.getElementsByClassName("inputMontantCalculePdf");
    for (var i = 0; i < inputs.length; i++) {
        total += parseFloat(inputs[i].value);
    }

    totalInput.value = total;
    console.log(total);
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
        let diff = total1 - total2;
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
    let totalSaisie = parseFloat($("#totalSaisie").val());
    let totalSaisiePdf = parseFloat($("#totalSaisiePdf").val());
    e.preventDefault();
    $("#totalSaisiePdf").removeClass("border-danger");
    $("#totalSaisie").removeClass("border-danger");
    if (totalSaisie == 0 || totalSaisiePdf == 0) {
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
    } else {
        axios
            .post("/releve", $("#add_releve_form").serialize())
            .then((res) => {
                Swal.fire("Operation Réussite !", res.data.message, "success");
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
            console.log("====================================");
            console.log(res);
            console.log("====================================");
            // console.log(res);
            Swal.fire("Operation Réussite !", res.data.message, "success");
            // $(".errors").html("");
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
}

function checkEcart(id_saisie, id_rapport, name) {
    let first = $("#" + id_saisie).val();
    let second = $("#" + id_rapport).val();
    if (!isNaN(first) && !isNaN(second)) {
        if (first !== second) {
            console.log("====================================");
            console.log(name + " est differnent");
            console.log("====================================");
        }
    }
}
function deletRow(id) {
    $(`#${id}`).remove();
}
