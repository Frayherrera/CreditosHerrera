<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewInventorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electrodomésticos' => 'Electrodomésticos para el hogar con la mejor calidad y precio.',
            'Muebles' => 'Muebles cómodos y elegantes para cada espacio de tu hogar.',
            'Cocina' => 'Todo lo que necesitas para equipar tu cocina.',
            'Hogar' => 'Accesorios, ropa de cama y decoración para hacer de tu casa un hogar.',
        ];

        $categoryIds = [];
        foreach ($categories as $name => $desc) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $desc]
            );
            $categoryIds[$name] = $cat->id;
        }

        $products = [
            // ─── Electrodomésticos ───
            ['Microondas', 'Electrodomésticos', 1],
            ['Ventilador pedestal Blanco', 'Electrodomésticos', 28],
            ['Ventilador pedestal Negro', 'Electrodomésticos', 20],
            ['Licuadora VV Samurai', 'Electrodomésticos', 13],
            ['Estufa Gavinet', 'Electrodomésticos', 3],
            ['Ventilador BL', 'Electrodomésticos', 2],
            ['Sanduchera 3 en 1', 'Electrodomésticos', 6],
            ['Estufa 4 puestos aluminio', 'Electrodomésticos', 1],
            ['Estufa 4 puestos lata', 'Electrodomésticos', 1],
            ['Ventilador blanco pared', 'Electrodomésticos', 5],
            ['Ventilador negro pared', 'Electrodomésticos', 2],
            ['Ventilador techo', 'Electrodomésticos', 1],
            ['Licuadora Samurai VP', 'Electrodomésticos', 19],
            ['Licuadora Altezza', 'Electrodomésticos', 1],
            ['Combo plancha y secador', 'Electrodomésticos', 5],
            ['Procesador de alimentos', 'Electrodomésticos', 9],
            ['Cafetera', 'Electrodomésticos', 2],
            ['Freidora Hisense 6.7 L', 'Electrodomésticos', 1],
            ['Batidora', 'Electrodomésticos', 4],
            ['Plancha keratina', 'Electrodomésticos', 3],
            ['Plancha a vapor', 'Electrodomésticos', 7],
            ['Exprimidor', 'Electrodomésticos', 3],
            ['Vanti', 'Electrodomésticos', 2],
            ['Plancha asar grande', 'Electrodomésticos', 6],
            ['Plancha asar pequeña', 'Electrodomésticos', 1],

            // ─── Cocina ───
            ['Indio 60x60', 'Cocina', 1],
            ['Indio 40x40', 'Cocina', 11],
            ['Indio 50x50', 'Cocina', 6],
            ['Juego de indios 32 - 40', 'Cocina', 3],
            ['Indio #38', 'Cocina', 1],
            ['Olla arrocera', 'Cocina', 3],
            ['Porta vajilla cúpula', 'Cocina', 8],
            ['Juego de utensilios', 'Cocina', 7],
            ['Olla espress 6L Imusa', 'Cocina', 12],
            ['Olla espress 6L Kalley', 'Cocina', 19],
            ['Vajilla Kiara', 'Cocina', 1],
            ['Vajilla tradicional', 'Cocina', 20],
            ['Vajilla cuadrada', 'Cocina', 1],
            ['Vajilla Home Element', 'Cocina', 1],
            ['Caldero #11', 'Cocina', 6],
            ['Caldero #5', 'Cocina', 15],
            ['Caldero #7', 'Cocina', 11],
            ['Juego de caserolas x3 rojo', 'Cocina', 11],
            ['Juego de ollas x5 tapa azul', 'Cocina', 4],
            ['Juego de ollas x5 tapa aluminio', 'Cocina', 7],
            ['Juego de ollas x5 aro', 'Cocina', 1],
            ['Juego de batería 6 piezas', 'Cocina', 1],
            ['Juego de cubiertos', 'Cocina', 1],
            ['Termo 5L', 'Cocina', 2],
            ['Olla spress 4L Imusa', 'Cocina', 3],
            ['Olla spress 4L Kalley', 'Cocina', 6],
            ['Termo tinto bomba', 'Cocina', 7],
            ['Termo tinto', 'Cocina', 8],
            ['Termo', 'Cocina', 23],
            ['Botella térmica', 'Cocina', 20],

            // ─── Muebles ───
            ['Mecedora', 'Muebles', 6],
            ['Mesas grande', 'Muebles', 2],
            ['Butaco', 'Muebles', 6],
            ['Base cama 140', 'Muebles', 7],
            ['Base cama 1 metro', 'Muebles', 1],
            ['Clóset un cuerpo', 'Muebles', 1],
            ['Cabina visivo', 'Muebles', 3],
            ['Silla eterna blanco arena', 'Muebles', 4],
            ['Silla Rimo beige', 'Muebles', 20],
            ['Silla Rimo naranja', 'Muebles', 20],
            ['Silla Rimo azul intenso', 'Muebles', 20],
            ['Silla Rimo verde limón', 'Muebles', 20],
            ['Silla Rimo rojo', 'Muebles', 20],
            ['Silla Rimo azul marino', 'Muebles', 20],
            ['Mesa ratán blanco arena', 'Muebles', 1],
            ['Mesa azul marino', 'Muebles', 6],
            ['Mesa naranja', 'Muebles', 5],
            ['Mesa roja', 'Muebles', 5],
            ['Mesa verde limón', 'Muebles', 5],
            ['Mesa azul intenso', 'Muebles', 5],
            ['Gavetero x5 gris', 'Muebles', 4],
            ['Gavetero x5 rosado', 'Muebles', 2],
            ['Gavetero x5 pastel', 'Muebles', 3],
            ['Gavetero x5 azul celeste', 'Muebles', 1],
            ['Gavetero x5 marrón', 'Muebles', 2],
            ['Gavetero x3 pastel', 'Muebles', 1],
            ['Silla Allure blanca', 'Muebles', 2],
            ['Silla Allure marrón', 'Muebles', 1],
            ['Silla Allure azul', 'Muebles', 2],
            ['Silla Allure blanca', 'Muebles', 4],
            ['Silla Allure roja', 'Muebles', 2],
            ['Silla Allure beige', 'Muebles', 4],
            ['Silla Allure naranja', 'Muebles', 5],
            ['Silla Allure verde limón', 'Muebles', 2],

            // ─── Hogar ───
            ['Cubrelecho doble', 'Hogar', 19],
            ['Cubrelecho grande', 'Hogar', 3],
            ['Cubrelecho combo doble', 'Hogar', 1],
            ['Platero x5', 'Hogar', 5],
            ['Almohada', 'Hogar', 11],
            ['Tanque 220', 'Hogar', 2],
            ['Tanque 160', 'Hogar', 15],
            ['Ponchera', 'Hogar', 4],
            ['Tendido doble', 'Hogar', 15],
            ['Tendido sencillo', 'Hogar', 9],
            ['Tendido king', 'Hogar', 23],
            ['Tendido extradoble', 'Hogar', 4],
            ['Tendido combo cortina doble', 'Hogar', 14],
            ['Forro colchón sencillo', 'Hogar', 5],
            ['Forro colchón king', 'Hogar', 10],
            ['Forro colchón extradoble', 'Hogar', 3],
            ['Toallón', 'Hogar', 2],
            ['Cortina', 'Hogar', 17],
        ];

        $skuCounters = [
            'Electrodomésticos' => 3,
            'Cocina' => 3,
            'Muebles' => 3,
            'Hogar' => 1,
        ];

        $prefixes = [
            'Electrodomésticos' => 'ELEC',
            'Cocina' => 'COCI',
            'Muebles' => 'MUEB',
            'Hogar' => 'HOGA',
        ];

        foreach ($products as [$name, $category, $stock]) {
            $skuCounters[$category]++;
            $sku = $prefixes[$category] . '-' . str_pad((string) $skuCounters[$category], 3, '0', STR_PAD_LEFT);

            Product::create([
                'category_id' => $categoryIds[$category],
                'name' => $name,
                'slug' => Str::slug($name . '-' . uniqid()),
                'description' => $name,
                'sku' => $sku,
                'price' => 1,
                'monthly_payment' => 1,
                'stock' => $stock,
                'min_stock' => 1,
                'status' => 'active',
            ]);
        }

        $this->command->info('Inventario creado exitosamente: ' . count($products) . ' productos.');
    }
}
