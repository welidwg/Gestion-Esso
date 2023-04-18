$("#add_cigarette_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    axios
        .post(
            $("#add_cigarette_form").attr("action"),
            $("#add_cigarette_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                title: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            // $(".errors").html("");
            // $("#add_cigarette_form").trigger("reset");
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
                text: errors.error,
                icon: "error",
                timer: 3000,
            });
            // $("#errors").html(errors.message);
        });
});

function deletRow(id) {
    $(`#${id}`).remove();
}


$("#edit_prixV_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    axios
        .post(
            $("#edit_prixV_form").attr("action"),
            $("#edit_prixV_form").serialize()
        )
        .then((res) => {
            // console.log(res);

            Swal.fire({
                title: "Operation Réussite !",
                text: res.data.message,
                icon: "success",
                timer: 1500,
            });
            // $(".errors").html("");
            $("#add_cigarette_form").trigger("reset");
            // $("#add_kiosque_form").trigger("reset");
            setTimeout(() => {
                window.location.href = "/cigarette";
            }, 1000);
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
});
