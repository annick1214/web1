<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Paiement</title>
    <style>
        .error { color: red; }
        .total { margin-top: 10px; }
    </style>
</head>
<body>

    <h1>Formulaire de Paiement</h1>
    <form id="paymentForm">
        <label for="tranche1">Tranche 1 :</label>
        <input type="number" id="tranche1" value="0" min="0" onchange="calculateTotal()"><br><br>

        <label for="tranche2">Tranche 2 :</label>
        <input type="number" id="tranche2" value="0" min="0" onchange="calculateTotal()"><br><br>

        <label for="tranche3">Tranche 3 :</label>
        <input type="number" id="tranche3" value="0" min="0" onchange="calculateTotal()"><br><br>

        <div id="total" class="total">Total : 0 CFA</div>
        <div id="errorMessage" class="error"></div><br>

        <button type="submit">Payer</button>
    </form>

    <script>
        function calculateTotal() {
            const tranche1 = parseFloat(document.getElementById('tranche1').value) || 0;
            const tranche2 = parseFloat(document.getElementById('tranche2').value) || 0;
            const tranche3 = parseFloat(document.getElementById('tranche3').value) || 0;

            const total = tranche1 + tranche2 + tranche3;
            document.getElementById('total').innerText = 'Total : ' + total + ' CFA';

            // Vérification du montant total
            const errorMessage = document.getElementById('errorMessage');
            if (total > 2500) {
                errorMessage.innerText = 'Le montant total ne doit pas dépasser 2500 CFA.';
            } else {
                errorMessage.innerText = '';
            }
        }

        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            const total = parseFloat(document.getElementById('tranche1').value) +
                          parseFloat(document.getElementById('tranche2').value) +
                          parseFloat(document.getElementById('tranche3').value);
            if (total !== 2500) {
                event.preventDefault(); // Empêche la soumission
                alert('Le montant total doit être exactement 2500 CFA.');
            }
        });
    </script>

</body>
</html>
