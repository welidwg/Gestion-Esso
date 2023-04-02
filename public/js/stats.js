$("#get_moyenne_form").on("submit", (e) => {
    e.preventDefault();
    let date1 = $("#date_debut").val();
    let date2 = $("#date_fin").val();
    axios
        .post(`/stats/moyenne/${date1}/${date2}`)
        .then((res) => {
            if (res.data.length !== 0) {
                Object.entries(res.data).forEach(function (key, value) {
                    if (key) {
                        $(`#${key[0]}`).val(key[1]);
                    }
                });
            } else {
                $(`input[type="number"]`).val(0);
            }
        })
        .catch((err) => {
            console.error(err);
        });
});
