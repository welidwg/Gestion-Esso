$("#add_user_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    $(".errors").html("");
    axios
        .post("/user/add", $("#add_user_form").serialize())
        .then((res) => {
            // console.log(res);
            Swal.fire("Operation Réussite !", res.data.message, "success");
            $(".errors").html("");
            $("#add_user_form").trigger("reset");
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            if (errors.message.login !== undefined) {
                $("#username_error").html(errors.message.login[0]);
            }
            if (errors.message.password !== undefined) {
                $("#password_error").html(errors.message.password[0]);
            }
            if (errors.message.code !== undefined) {
                $("#code_error").html(errors.message.code[0]);
            }
            console.log(errors);
            // Swal.fire(
            //     "Operation Echouée!",
            //     "Erreur de serveur.Veuillez réssayer ultérieurement",
            //     "error"
            // );
        });
});
$("#user_auth_form").on("submit", (e) => {
    // let data = new FormData()
    e.preventDefault();
    $(".errors").html("");
    $("#spinner").fadeIn();

    axios
        .post("/user/auth", $("#user_auth_form").serialize())
        .then((res) => {
            // console.log(res);
            // Swal.fire("Operation Réussite !", res.data.message, "success");
            $(".errors").html("");
            $("#user_auth_form").trigger("reset");
            $("#spinner").fadeOut();
            setTimeout(() => {
                window.location.href = "/main";
            }, 600);
        })
        .catch((err) => {
            // console.error();
            let errors = err.response.data;
            console.log(err.response);
            $("#spinner").fadeOut();

            $("#errors").html(`<div class="alert alert-danger" role="alert">
    ${errors.message}
</div>`);
        });
});

$("#edit_user_form").on("submit", (e) => {
    e.preventDefault();
    $(".errors").html("");
    axios
        .post(
            $("#edit_user_form").attr("action"),
            $("#edit_user_form").serialize()
        )
        .then((res) => {
            // console.log(res);
            Swal.fire("Operation Réussite !", res.data.message, "success");
            $(".errors").html("");
            setTimeout(() => {
                window.location.href = "/caissier";
            }, 700);
        })
        .catch((err) => {
            // console.error();
            // let errors = err.response.data;
            // if (errors.message.login !== undefined) {
            //     $("#username_error").html(errors.message.login[0]);
            // }
            // if (errors.message.password !== undefined) {
            //     $("#password_error").html(errors.message.password[0]);
            // }
            // if (errors.message.code !== undefined) {
            //     $("#code_error").html(errors.message.code[0]);
            // }
            console.log(err.message);
            Swal.fire(
                "Operation Echouée!",
                "Erreur de serveur.Veuillez réssayer ultérieurement",
                "error"
            );
        });
});
