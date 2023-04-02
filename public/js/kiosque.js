$("#add_kiosque_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    $(".errors").html("");
    axios
        .post("/kiosque/add", $("#add_kiosque_form").serialize())
        .then((res) => {
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
});
