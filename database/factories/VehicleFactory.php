<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        $brands = ['BMW', 'Mercedes', 'Audi', 'Volkswagen', 'Fiat', 'Ford', 'Toyota', 'Honda', 'Nissan', 'Hyundai'];
        $models = ['Serie 3', 'Classe A', 'A4', 'Golf', 'Punto', 'Fiesta', 'Corolla', 'Civic', 'Micra', 'i20'];
        $colors = ['Nero', 'Bianco', 'Grigio', 'Blu', 'Rosso', 'Argento', 'Verde', 'Marrone'];
        $fuels = ['Benzina', 'Diesel', 'GPL', 'Metano', 'Elettrico', 'Ibrido'];
        $purchasePrice = $this->faker->numberBetween(5000, 45000);
        $costs = [
            'broker' => $this->faker->numberBetween(0, 1500),
            'transport' => $this->faker->numberBetween(0, 800),
            'mechatronics' => $this->faker->numberBetween(0, 3000),
            'bodywork' => $this->faker->numberBetween(0, 2500),
            'tire_shop' => $this->faker->numberBetween(0, 800),
            'upholstery' => $this->faker->numberBetween(0, 1200),
            'travel' => $this->faker->numberBetween(0, 500),
            'inspection' => $this->faker->numberBetween(0, 300),
            'miscellaneous' => $this->faker->numberBetween(0, 1000),
            'spare_parts' => $this->faker->numberBetween(0, 2000),
            'washing' => $this->faker->numberBetween(0, 200),
        ];
        $totalCost = $purchasePrice + array_sum($costs);
        return [
            'brand_model' => $this->faker->randomElement($brands) . ' ' . $this->faker->randomElement($models),
            'license_plate' => strtoupper($this->faker->lexify('??###??')),
            'chassis' => 'VIN' . $this->faker->numerify('##############'),
            'registration_year' => $this->faker->numberBetween(2010, 2024),
            'color' => $this->faker->randomElement($colors),
            'fuel_type' => $this->faker->randomElement($fuels),
            'second_key' => $this->faker->boolean(70),
            'origin' => $this->faker->randomElement(['Concessionario', 'Privato', 'Asta', 'Permuta']),
            'vat_exposed' => $this->faker->boolean(30),
            'purchase_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'registry_number' => 'REG' . str_replace('.', '', microtime(true)) . $this->faker->numberBetween(10, 99),
            'archive_number' => 'ARC' . str_replace('.', '', microtime(true)) . $this->faker->numberBetween(10, 99),
            'customer_name' => $this->faker->firstName(),
            'customer_surname' => $this->faker->lastName(),
            'payment_method' => $this->faker->randomElement(['contanti', 'bonifico', 'permuta', 'finanziamento', 'misto']),
            
            'purchase_price' => $purchasePrice,
            'broker' => $costs['broker'],
            'transport' => $costs['transport'],
            'mechatronics' => $costs['mechatronics'],
            'bodywork' => $costs['bodywork'],
            'tire_shop' => $costs['tire_shop'],
            'upholstery' => $costs['upholstery'],
            'travel' => $costs['travel'],
            'inspection' => $costs['inspection'],
            'miscellaneous' => $costs['miscellaneous'],
            'spare_parts' => $costs['spare_parts'],
            'washing' => $costs['washing'],
            'total_cost' => $totalCost,
            
            'status' => $this->faker->randomElement(['disponibile', 'venduto', 'archiviato']),
            'sale_price' => $this->faker->numberBetween($totalCost + 1000, $totalCost + 15000),
        ];
    }
}