$("#add_factureCaissier_form").on("submit", (e) => {
    e.preventDefault();
    axios
        .post(
            $("#add_factureCaissier_form").attr("action"),
            $("#add_factureCaissier_form").serialize()
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
            $("#add_factureCaissier_form").trigger("reset");
            $(".container-rows").html('')
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
