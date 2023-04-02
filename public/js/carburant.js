$("#add_carburant_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    $(".errors").html("");
    axios
        .post(
            $("#add_carburant_form").attr("action"),
            $("#add_carburant_form").serialize()
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
            $("#add_carburant_form").trigger("reset");
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
$("#prixA , #marge_beneficiere").on("keyup", (e) => {
    let prixA = parseFloat($("#prixA").val());
    let marge = parseFloat($("#marge_beneficiere").val());
    if (!isNaN(prixA) && !isNaN(marge)) {
        $("#prixV").val(prixA * (1 + marge));
    }
    console.log(prixA, marge);
});
$("#qtiteStk , #prixV ").on("keyup", (e) => {
    let prixV = parseFloat($("#prixV").val());

    if ($("#prixV").val() !== "" && $("#qtiteStk").val() !== "") {
        let qte = parseFloat($("#qtiteStk").val());
        let vs = parseFloat(qte * prixV).toFixed(3);
        $("#v_stock").attr("value", vs);
    }
});

$("#edit_jauge_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .post(
            $("#edit_jauge_form").attr("action"),
            $("#edit_jauge_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                title: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            console.log("====================================");
            console.log(res.data);
            console.log("====================================");

            setTimeout(() => {
                window.location.href = "/carburant";
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);

            // $("#errors").html(errors.message);
        });
});

$("#edit_seuil_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .post(
            $("#edit_seuil_form").attr("action"),
            $("#edit_seuil_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                title: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            console.log("====================================");
            console.log(res.data);
            console.log("====================================");

            setTimeout(() => {
                window.location.href = "/carburant";
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);

            // $("#errors").html(errors.message);
        });
});
$("#edit_marge_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .post(
            $("#edit_marge_form").attr("action"),
            $("#edit_marge_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                title: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            console.log("====================================");
            console.log(res.data);
            console.log("====================================");

            setTimeout(() => {
                window.location.href = "/carburant";
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(errors);

            // $("#errors").html(errors.message);
        });
});
