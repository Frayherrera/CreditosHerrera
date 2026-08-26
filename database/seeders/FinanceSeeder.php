<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\TransactionClassification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@creditosherrera.com'],
            ['name' => 'Administrador', 'password' => bcrypt('password')]
        );

        $categoriasIngreso = [
            ['name' => 'Ventas de productos', 'type' => 'ingreso'],
            ['name' => 'Servicios de crédito', 'type' => 'ingreso'],
            ['name' => 'Comisiones bancarias', 'type' => 'ingreso'],
            ['name' => 'Alquiler de local', 'type' => 'ingreso'],
            ['name' => 'Intereses percibidos', 'type' => 'ingreso'],
            ['name' => 'venta de activo', 'type' => 'ingreso'],
            ['name' => 'Préstamos otorgados', 'type' => 'ingreso'],
        ];

        $categoriasEgreso = [
            ['name' => 'Sueldos y nómina', 'type' => 'egreso'],
            ['name' => 'Alquiler del local', 'type' => 'egreso'],
            ['name' => 'Servicios (luz, agua, internet)', 'type' => 'egreso'],
            ['name' => 'Compra de inventario', 'type' => 'egreso'],
            ['name' => 'Mantenimiento', 'type' => 'egreso'],
            ['name' => 'Impuestos y permisos', 'type' => 'egreso'],
            ['name' => 'Transporte y logística', 'type' => 'egreso'],
            ['name' => 'Marketing y publicidad', 'type' => 'egreso'],
        ];

        $categories = collect();
        foreach (array_merge($categoriasIngreso, $categoriasEgreso) as $cat) {
            $categories->push(TransactionCategory::create(array_merge($cat, ['user_id' => $user->id])));
        }

        $ingresoCategories = $categories->where('type', 'ingreso')->values();
        $egresoCategories = $categories->where('type', 'egreso')->values();

        $clasificacionesData = [
            ['name' => 'Operativo', 'type' => 'ingreso'],
            ['name' => 'No operativo', 'type' => 'ingreso'],
            ['name' => 'Capital', 'type' => 'ingreso'],
            ['name' => 'Operativo', 'type' => 'egreso'],
            ['name' => 'No operativo', 'type' => 'egreso'],
            ['name' => 'Capital', 'type' => 'egreso'],
        ];

        $classifications = collect();
        foreach ($clasificacionesData as $cls) {
            $classifications->push(TransactionClassification::create(array_merge($cls, ['user_id' => $user->id])));
        }

        $descripcionesIngreso = [
            'Venta de equipo de cómputo',
            'Pago de préstamo cliente Juan Pérez',
            'Comisión por transferencia',
            'Alquiler de oficina planta alta',
            'Intereses de cuenta de ahorro',
            'Venta de escritorio usado',
            'Abono de préstamo María López',
            'Venta de materiales varios',
            'Comisión por venta de producto X',
            'Ingreso por servicio de asesoría',
            'Pago de deuda cliente Carlos Ruiz',
            'Ingreso por arrendamiento de equipo',
            'Venta de mercancía en efectivo',
            'Depósito de capital social',
            'Pago de préstamo cliente Ana García',
            'Ingreso por comisión de seguros',
        ];

        $descripcionesEgreso = [
            'Pago de nómina personal enero',
            'Renta local comercial',
            'Factura de luz ENEL',
            'Compra de mercancía proveedor A',
            'Reparación de equipo de cómputo',
            'Pago de impuesto municipal',
            'Flete de mercancía desde proveedor',
            'Campaña de publicidad Facebook',
            'Pago de nómina personal febrero',
            'Servicio de internet Telmex',
            'Compra de material de oficina',
            'Mantenimiento preventivo aire acondicionado',
            'Pago de permiso de operación',
            'Publicidad en Google Ads',
            'Pago de nómina personal marzo',
            'Compra de inventario proveedor B',
            'Servicio de agua potable',
            'Transporte de mercancía',
            'Pago de contador mensual',
            'Reposición de equipo dañado',
        ];

        $now = Carbon::now();

        for ($month = 0; $month < 6; $month++) {
            $fechaBase = $now->copy()->subMonths($month)->startOfMonth();

            $numIngresos = rand(8, 14);
            for ($i = 0; $i < $numIngresos; $i++) {
                $dia = rand(1, $fechaBase->daysInMonth);
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'ingreso',
                    'transaction_classification_id' => $classifications->where('type', 'ingreso')->random()->id,
                    'transaction_category_id' => $ingresoCategories->random()->id,
                    'amount' => rand(500, 25000) + (rand(0, 99) / 100),
                    'description' => $descripcionesIngreso[array_rand($descripcionesIngreso)],
                    'date' => $fechaBase->copy()->day($dia),
                ]);
            }

            $numEgresos = rand(10, 16);
            for ($i = 0; $i < $numEgresos; $i++) {
                $dia = rand(1, $fechaBase->daysInMonth);
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'egreso',
                    'transaction_classification_id' => $classifications->where('type', 'egreso')->random()->id,
                    'transaction_category_id' => $egresoCategories->random()->id,
                    'amount' => rand(200, 15000) + (rand(0, 99) / 100),
                    'description' => $descripcionesEgreso[array_rand($descripcionesEgreso)],
                    'date' => $fechaBase->copy()->day($dia),
                ]);
            }
        }

        $this->command->info("Finanzas seeded: {$categories->count()} categorías y ".Transaction::count().' transacciones creadas.');
    }
}
