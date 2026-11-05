<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu de paiement {{ $paiement->reference_paiement }}</title>
    <style>
        body {
            color: #222;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 4px;
            font-size: 24px;
        }

        .subtitle {
            margin-top: 0;
            color: #555;
        }

        .details {
            margin: 24px 0;
            line-height: 1.7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 9px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .amount {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Reçu de paiement</h1>
    <p class="subtitle">Paiement reçu à la livraison</p>

    <div class="details">
        <div><strong>Référence :</strong> {{ $paiement->reference_paiement }}</div>
        <div><strong>Commande :</strong> {{ $commande->numero_commande }}</div>
        <div><strong>Client :</strong> {{ $clientName }}</div>
        <div><strong>Date du paiement :</strong> {{ $paiement->date_paiement->format('d/m/Y H:i') }}</div>
        <div><strong>Mode de paiement :</strong> {{ $modePaiement }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commande->lignesCommande as $ligne)
                <tr>
                    <td>{{ $ligne->produit->nom }}</td>
                    <td>{{ $ligne->quantite }}</td>
                    <td>{{ number_format((float) $ligne->prix_unitaire, 2, ',', ' ') }}</td>
                    <td>{{ number_format((float) $ligne->sous_total, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="amount">
        Total payé : {{ number_format((float) $paiement->montant_paye, 2, ',', ' ') }}
    </p>
</body>
</html>
