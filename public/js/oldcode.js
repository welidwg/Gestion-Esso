// // type cigars
//    <script>
//                                         let prixVC = $("#prixVC").val();
//                                         let montant = $("#montantC").val();
//                                         $("#qteC").on("input", (e) => {
//                                             $(`#prixVC`).val(parseFloat($("#montantC").val() / e.target.value)
//                                                 .toFixed(3))
//                                         })
//                                         $("#montantC").on("input", (e) => {
//                                             $(`#prixVC`).val(parseFloat(e.target.value / $("#qteC").val())
//                                                 .toFixed(3))
//                                         })

//                                         //             $("#type_selected").on("change", (e) => {
//                                         //                 // console.log(e.target.value);
//                                         //                 let value = e.target.value;
//                                         //                 let pv = $('#type_selected option:selected').data('pv');
//                                         //                 let qte = $('#type_selected option:selected').data('qte');
//                                         //                 let id = $('#type_selected option:selected').data('id');

//                                         //                 let type = $('#type_selected option:selected').data('type');
//                                         //                 if (value != "") {

//                                         //                     if ($(".container-rows").find(`#row_${value}`).length > 0) {
//                                         //                         $(`#row_${value}`).remove()

//                                         //                     } else {
//                                         //                         cigars.push({
//                                         //                             id: id,
//                                         //                             type: type
//                                         //                         });
//                                         //                         $(".container-rows").append(`
//     //             <div class="row" id="row_${value}" >
//     //     <div class="col-4">
//     //         <div class="mb-3">
//     //             <input class="form-control bg-light text-dark" type="text" required
//     //                 id="" placeholder="" required name="type" value="${type}"
//     //                 readonly />
//     //         </div>
//     //     </div>
//     //     <div class="col-4">
//     //         <div class="mb-3 ">

//     //             <input class="form-control text-dark " type="number" step="0.01" required
//     //                 id="qteC_${id}" value="0" placeholder="" required name="qteC_${id}" />

//     //                  <small>(Dans le stock : ${qte})</small>
//     //         </div>

//     //     </div>
//     //     <div class="col-md-3  visually-hidden" >
//     //         <div class="mb-3 ">
//     //             <input class="form-control text-dark bg-light" type="number" step="0.01" required
//     //                 id="prixVC_${id}" value="${pv}" hidden placeholder="" readonly required
//     //                 name="prixVC_${id}" />
//     //         </div>
//     //     </div>
//     //     <div class="col-4">
//     //         <div class="mb-3 d-flex align-items-center">
//     //             <input class="form-control  text-dark " type="number" step="0.01" required
//     //                 id="montantC_${id}" value="0" placeholder="" required
//     //                 name="montantC_${id}" />
//     //                 <a onclick="deletRow('row_${value}')" class="mx-2"><i class="fas fa-times text-danger"></i></a>
//     //         </div>

//     //     </div>
//     //     <input type="hidden" name="types[]" value="${type}">

//     // </div>
//     //             `)
//                                         //                         let prixVC = $("#prixVC_" + id).val();
//                                         //                         let montant = $("#montantC_" + id).val();
//                                         //                         $("#qteC_" + id).on("input", (e) => {

//                                         //                             $(`#prixVC_${id}`).val(parseFloat($("#montantC_" + id).val() / e.target.value)
//                                         //                                 .toFixed(3))

//                                         //                         })
//                                         //                         $("#montantC_" + id).on("input", (e) => {

//                                         //                             $(`#prixVC_${id}`).val(parseFloat(e.target.value / $("#qteC_" + id).val())
//                                         //                                 .toFixed(3))

//                                         //                         })

//                                         //                     }
//                                         //                 }

//                                         //             })
//                                     //</script>
