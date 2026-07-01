<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listino Veicoli Disponibili</title>
    <style>
        @page { margin: 18px; }
        body { font-family: Arial, sans-serif; color: #1f2937; font-size: 12px; margin: 0; }
        h1 { color: #1f2937; font-size: 28px; margin: 0 0 18px; text-align: center; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th { background-color: #42a84f; color: white; font-size: 12px; padding: 9px 8px; text-align: left; white-space: nowrap; }
        td { border: 1px solid #d9dee3; padding: 8px; line-height: 1.25; vertical-align: middle; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .model { width: 28%; }
        .plate { width: 10%; }
        .year { width: 7%; text-align: center; }
        .km { width: 11%; text-align: right; white-space: nowrap; }
        .color { width: 13%; }
        .fuel { width: 20%; }
        .price { width: 11%; text-align: right; white-space: nowrap; }
    </style>
</head>
<body>
    <h1>Listino Veicoli Disponibili</h1>

    <table>
        <thead>
            <tr>
                <th class="model">Marca/Modello</th>
                <th class="plate">Targa</th>
                <th class="year">Anno</th>
                <th class="km">Chilometri</th>
                <th class="color">Colore</th>
                <th class="fuel">Alimentazione</th>
                <th class="price">Prezzo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
                <td class="model">{{ $vehicle->brand_model }}</td>
                <td class="plate">{{ $vehicle->license_plate }}</td>
                <td class="year">{{ $vehicle->registration_year }}</td>
                <td class="km">{{ $vehicle->km ? number_format($vehicle->km, 0, ',', '.') : '' }}</td>
                <td class="color">{{ $vehicle->color }}</td>
                <td class="fuel">{{ $vehicle->fuel_type }}</td>
                <td class="price">&euro;&nbsp;{{ number_format($vehicle->sale_price, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
