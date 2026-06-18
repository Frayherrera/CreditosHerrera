<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electrodomésticos' => ['Electrodomésticos para el hogar con la mejor calidad y precio.', null],
            'Muebles' => ['Muebles cómodos y elegantes para cada espacio de tu hogar.', null],
            'Cocina' => ['Todo lo que necesitas para equipar tu cocina.', null],
            'Tecnología' => ['Tecnología de punta al alcance de tu bolsillo.', null],
            'Hogar' => ['Accesorios y decoración para hacer de tu casa un hogar.', null],
        ];

        foreach ($categories as $name => [$desc, $parent]) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $desc,
            ]);
        }

        $categoryMap = [
            'Electrodomésticos' => Category::where('slug', 'electrodomesticos')->first()->id,
            'Muebles' => Category::where('slug', 'muebles')->first()->id,
            'Cocina' => Category::where('slug', 'cocina')->first()->id,
            'Tecnología' => Category::where('slug', 'tecnologia')->first()->id,
            'Hogar' => Category::where('slug', 'hogar')->first()->id,
        ];

        $products = [
            [
                'name' => 'Nebulizador y Humidificador',
                'category' => 'Electrodomésticos',
                'description' => 'Nebulizador y humidificador de aire ultrasónico.',
                'sku' => 'ELEC-001',
                'price' => 2499000,
                'monthly_payment' => 104125,
                'stock' => 15,
                'min_stock' => 3,
            ],
            [
                'name' => 'Lavadora 17 libras',
                'category' => 'Electrodomésticos',
                'description' => 'Lavadora automática de 17 libras.',
                'sku' => 'ELEC-002',
                'price' => 1799000,
                'monthly_payment' => 74958,
                'stock' => 10,
                'min_stock' => 2,
            ],
            [
                'name' => 'Set de Sala Moderno',
                'category' => 'Muebles',
                'description' => 'Set de sala moderno de 3 piezas.',
                'sku' => 'MUEB-001',
                'price' => 3999000,
                'monthly_payment' => 166625,
                'stock' => 5,
                'min_stock' => 1,
            ],
            [
                'name' => 'Juego de comedor 6 puestos',
                'category' => 'Muebles',
                'description' => 'Juego de comedor completo para 6 personas.',
                'sku' => 'MUEB-002',
                'price' => 2999000,
                'monthly_payment' => 124958,
                'stock' => 8,
                'min_stock' => 2,
            ],
            [
                'name' => 'Cocina 4 quemadores',
                'category' => 'Cocina',
                'description' => 'Estufa de 4 quemadores con horno.',
                'sku' => 'COCI-001',
                'price' => 1499000,
                'monthly_payment' => 62458,
                'stock' => 12,
                'min_stock' => 3,
            ],
            [
                'name' => 'Nevera 12 pies',
                'category' => 'Electrodomésticos',
                'description' => 'Nevera de 12 pies con congelador.',
                'sku' => 'ELEC-003',
                'price' => 2799000,
                'monthly_payment' => 116625,
                'stock' => 7,
                'min_stock' => 2,
            ],
            [
                'name' => 'Licuadora Profesional',
                'category' => 'Cocina',
                'description' => 'Licuadora profesional de alta potencia.',
                'sku' => 'COCI-002',
                'price' => 299000,
                'monthly_payment' => 12458,
                'stock' => 25,
                'min_stock' => 5,
            ],
            [
                'name' => 'Televisor 55 pulgadas',
                'category' => 'Tecnología',
                'description' => 'Televisor LED 4K de 55 pulgadas.',
                'sku' => 'TECN-001',
                'price' => 3499000,
                'monthly_payment' => 145792,
                'stock' => 6,
                'min_stock' => 2,
            ],
            [
                'name' => 'Portátil 15 pulgadas',
                'category' => 'Tecnología',
                'description' => 'Portátil con procesador i5, 8GB RAM.',
                'sku' => 'TECN-002',
                'price' => 2999000,
                'monthly_payment' => 124958,
                'stock' => 9,
                'min_stock' => 2,
            ],
            [
                'name' => 'Cama Queen Size',
                'category' => 'Muebles',
                'description' => 'Cama queen size con colchón ortopédico.',
                'sku' => 'MUEB-003',
                'price' => 2499000,
                'monthly_payment' => 104125,
                'stock' => 4,
                'min_stock' => 1,
            ],
            [
                'name' => 'Set de Ollas 10 piezas',
                'category' => 'Cocina',
                'description' => 'Set completo de ollas antiadherentes.',
                'sku' => 'COCI-003',
                'price' => 599000,
                'monthly_payment' => 24958,
                'stock' => 20,
                'min_stock' => 5,
            ],
            [
                'name' => 'Plancha a Vapor',
                'category' => 'Hogar',
                'description' => 'Plancha a vapor con suela de cerámica.',
                'sku' => 'HOGA-001',
                'price' => 199000,
                'monthly_payment' => 8292,
                'stock' => 30,
                'min_stock' => 5,
            ],
        ];

        foreach ($products as $data) {
            Product::create([
                'category_id' => $categoryMap[$data['category']],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'sku' => $data['sku'],
                'price' => $data['price'],
                'monthly_payment' => $data['monthly_payment'],
                'stock' => $data['stock'],
                'min_stock' => $data['min_stock'],
                'status' => 'active',
            ]);
        }

        $this->command->info('Categorías y productos creados exitosamente.');
    }
}
