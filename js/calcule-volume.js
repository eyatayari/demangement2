$(document).ready(function () {
    // Fonction pour mettre à jour le volume total
    function updateTotalVolume() {
        // Sélectionnez tous les champs d'entrée
        var inputElements = document.querySelectorAll('.input-number');

        // Initialisez le volume total à 0
        var totalVolume = 0;

        // Parcourez chaque champ d'entrée
        inputElements.forEach(function (inputElement) {
            // Obtenez la valeur et le volume de chaque champ d'entrée
            var quantity = parseFloat(inputElement.value);
            var volume = parseFloat(inputElement.getAttribute('data-volume'));

            // Ajoutez le volume multiplicatif à la somme totale
            totalVolume += quantity * volume;
        });

        // Mettez à jour le texte affichant le volume total
        document.getElementById('volumeTotal').textContent = 'Volume total : ' + totalVolume.toFixed(2) + ' m³';
    }

    // Attachez la fonction à l'événement onchange de chaque champ d'entrée
    $('.input-number').change(updateTotalVolume);
});