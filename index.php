<?php
require('script/main.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">-->

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="main">

    <div class="container">
        <h2 id="volumeTotal">Volume total : 0</h2>


        <form id="signup-form" class="signup-form">
            <?php foreach (FOURNITURES as $key => $fourniture): ?>
                <h3><?= $fourniture[0]['categorie'] ?></h3>

                <fieldset>

                    <div class="form-holder">
                        <div class="form-row">
                            <!--                            <div class="col col-md-3 mb-3">-->
                            <?PHP foreach ($fourniture as $element): ?>

                                <div class="card mb-3"
                                     style="width: 15rem; padding: 48px 0 15px; text-align: center;">
                                    <div class="card-body">
                                        <h4 class="card-title"><?= $element['nom'] ?></h4>
                                        <h5 class="card-subtitle mb-2 text-muted">Volume:
                                            <b><?= $element['volume'] ?></b> m³</h5>
                                        <div class="input-group">
                                                <span class="input-group-btn">

                                                    <button type="button" class="btn btn-danger btn-number"
                                                            data-type="minus" data-field="quant[<?= $element['id'] ?>]">
                                                        <span class="select-icon"><i class="zmdi zmdi-minus"></i></span>
              </button>
                                                 </span>
                                            <input type="text"
                                                   class="form-control input-number"
                                                   id="quant[<?= $element['id'] ?>]"
                                                   name="quant[<?= $element['id'] ?>]"
                                                   value="<?= $element['qte'] ?>"
                                                   data-volume="<?= $element['volume'] ?>"
                                                   min="0"
                                                   max="30"/>
                                            <span class="input-group-btn">

                                                    <button type="button" class="btn btn-success btn-number"
                                                            data-type="plus" data-field="quant[<?= $element['id'] ?>]">
                                                                                                            <span class="select-icon"><i class="zmdi zmdi-plus"></i></span>

                                                    </button>

                                                </span>
                                        </div>
                                    </div>
                                </div>
                            <?PHP endforeach; ?>
                            <!--                            </div>-->
                        </div>
                    </div>

                </fieldset>
            <?PHP endforeach; ?>

        </form>


    </div>

</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
<script src="vendor/jquery-steps/jquery.steps.min.js"></script>
<script src="js/main.js"></script>
<!-- Script ajouté par Marouen -->
<script src="js/calcule-volume.js" async></script>
<!-- Script Event Page -->
<script>
    $(document).ready(function () {
        //btn plus minus
        //plugin bootstrap minus and plus
        //http://jsfiddle.net/laelitenetwork/puJ6G/
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function () {
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            // Extraire l'ID de l'élément du nom de l'input
            // Extrayez l'ID de l'élément du nom de l'input
            var id = name.match(/\d+/)[0]; // Cela extrait le premier nombre du nom
            // Cela extrait le premier nombre du nom
            // console.log(id)
            // console.log(valueCurrent)
            // Envoyez la nouvelle valeur au serveur via une requête AJAX
            // $.ajax({
            //     type: 'POST',
            //     url: 'script/update_quantite.php', // Chemin vers votre script PHP de mise à jour
            //     data: {
            //         id: id,
            //         newValue: valueCurrent
            //     },
            //     success: function (response) {
            //         if (response.success) {
            //             console.log('Valeur mise à jour avec succès.');
            //             // Vous pouvez effectuer des actions supplémentaires ici si nécessaire
            //         } else {
            //             console.error('Erreur lors de la mise à jour de la valeur.');
            //         }
            //     }
            // });
        });

        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    });
</script>
</body>
</html>