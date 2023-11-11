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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main">
    <div class="container">
        <form id="signup-form" class="signup-form">
            <h2 id="volumeTotal">Volume total : 0 m³</h2>
            <?php foreach (FOURNITURES as $key => $fourniture): ?>
                <h3><?= ucwords($fourniture[0]['categorie']) ?></h3>
                <fieldset>
                    <div class="form-holder">
                        <div class="row">
                            <?PHP foreach ($fourniture as $element): ?>
                                <div class="col-md-3" >
                                    <div class="card mb-3" >
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?= $element['nom'] ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                Volume unitaire : <b><?= $element['volume'] ?></b> m³
                                            </h6>
                                            <div class="row">
                                                <div class="col-8 mx-auto">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                    class="btn btn-danger btn-number"
                                                                    data-type="minus"
                                                                    data-field="quant[<?= $element['id'] ?>]">
                                                                <i class="zmdi zmdi-minus"></i>
                                                            </button>
                                                         </span>
                                                        <input type="number"
                                                               class="form-control input-number text-center mx-1"
                                                               id="quant[<?= $element['id'] ?>]"
                                                               name="quant[<?= $element['id'] ?>]"
                                                               value="<?= $element['qte'] ?>"
                                                               data-volume="<?= $element['volume'] ?>"
                                                               min="0"
                                                               max="30"/>
                                                        <span class="input-group-btn">
                                                                <button type="button"
                                                                        class="btn btn-success btn-number"
                                                                        data-type="plus"
                                                                        data-field="quant[<?= $element['id'] ?>]">
                                                                    <i class="zmdi zmdi-plus"></i>
                                                                </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?PHP endforeach; ?>
                        </div>
                    </div>
                </fieldset>
            <?PHP endforeach; ?>
        </form>
    </div>
    <!-- Balise modale pour afficher le volume total -->
    <div class="modal fade" id="volumeModal" tabindex="-1" aria-labelledby="volumeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="volumeModalLabel">Volume total</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="volumeMessage"></p>
                </div>
                <div class="modal-footer">
                    <a href="https://demenagementfacile.pro/devis/" class="btn btn-primary">Demandez un devis</a>
                    <a href="https://demenagementfacile.pro/" class="btn btn-secondary">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
<script src="vendor/jquery-steps/jquery.steps.min.js"></script>
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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