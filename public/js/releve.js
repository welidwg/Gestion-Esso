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
        console.log(diff);
    }
}, 1200);

$("#add_releve_form").on("submit", (e) => {
    // e.prevenetDefault();
    e.preventDefault();
    // $(".errors").html("");
    axios
        .post("/releve", $("#add_releve_form").serialize())
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
