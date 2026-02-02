<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listino Veicoli Disponibili</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4CAF50; color: white; padding: 10px; text-align: left; }
        td { border: 1px solid #ddd; padding: 8px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Listino Veicoli Disponibili</h1>
    
    <table>
        <thead>
            <tr>
                <th>Marca/Modello</th>
                <th>Targa</th>
                <th>Anno</th>
                <th>Colore</th>
                <th>Alimentazione</th>
                <th>Prezzo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->brand_model }}</td>
                <td>{{ $vehicle->license_plate }}</td>
                <td>{{ $vehicle->registration_year }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->fuel_type }}</td>
                <td>€ {{ number_format($vehicle->sale_price, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>