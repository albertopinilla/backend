<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductSeeder extends Seeder
{
    private $date = date('Y-m-d H:i:s');

    // Categorias
    $cat1 = 'Bocadillos y Sándwiches';
    $cat2 = 'Snacks Dulces y Salados';
    $cat3 = 'Cafés e Infusiones';
    $cat4 = 'Refrescos';

    public function run()
    {
        DB::table('products')->insert([
            [
                "name" => "Sandwich baguette",
                "reference" => "112278",
                "price" => "5800",
                "weight" => "1",
                "category" => $this->cat1,
                "stock" => "45",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Sándwich de Jamón y queso",
                "reference" => "142577",
                "price" => "5500",
                "weight" => "1",
                "category" => $this->cat1,
                "stock" => "50",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Sándwich Vegetal con queso",
                "reference" => "135896",
                "price" => "5000",
                "weight" => "1",
                "category" => $this->cat1,
                "stock" => "50",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Sándwich Vegetal amb formatge",
                "reference" => "178964",
                "price" => "5200",
                "weight" => "1",
                "category" => $this->cat1,
                "stock" => "50",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Galletas - Biscuits",
                "reference" => "134458",
                "price" => "2200",
                "weight" => "2",
                "category" => $this->cat2,
                "stock" => "75",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Maní Con Chocolate Manitoba 50G",
                "reference" => "102988",
                "price" => "2200",
                "weight" => "50",
                "category" => $this->cat2,
                "stock" => "75",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Maní Caramelizado Chocolate Del Alba 45G",
                "reference" => "156156",
                "price" => "2950",
                "weight" => "45",
                "category" => $this->cat2,
                "stock" => "60",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Fruta Liofilizada Frut Li Frut-002 Piña 16Gr",
                "reference" => "177979",
                "price" => "2950",
                "weight" => "50",
                "category" => $this->cat2,
                "stock" => "65",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Fruta Liofilizada Frut Li Frut-002 Piña 16Gr",
                "reference" => "177979",
                "price" => "2950",
                "weight" => "50",
                "category" => $this->cat2,
                "stock" => "65",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Café",
                "reference" => "102320",
                "price" => "2650",
                "weight" => "12",
                "category" => $this->cat3,
                "stock" => "50",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Café doble",
                "reference" => "147889",
                "price" => "3800",
                "weight" => "10",
                "category" => $this->cat3,
                "stock" => "40",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Café Capuccino",
                "reference" => "112889",
                "price" => "3100",
                "weight" => "10",
                "category" => $this->cat3,
                "stock" => "95",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Descafeinado",
                "reference" => "144478",
                "price" => "2800",
                "weight" => "10",
                "category" => $this->cat3,
                "stock" => "95",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Agua Mineral 50 cl",
                "reference" => "145588",
                "price" => "2600",
                "weight" => "50",
                "category" => "$this->cat4",
                "stock" => "100",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Agua Perrier con gas",
                "reference" => "132298",
                "price" => "3100",
                "weight" => "50",
                "category" => "$this->cat4",
                "stock" => "20",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Coca-ColA Zero",
                "reference" => "102589",
                "price" => "3000",
                "weight" => "33",
                "category" => "$this->cat4",
                "stock" => "40",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Bebida Energizante Red Bull Limitada 355ML",
                "reference" => "401861",
                "price" => "7200",
                "weight" => "30",
                "category" => "$this->cat4",
                "stock" => "45",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Bebida Energizante Monster X 473Ml Bluezero Lata",
                "reference" => "212840",
                "price" => "6500",
                "weight" => "30",
                "category" => "$this->cat4",
                "stock" => "45",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Bebida Hidratante Gatorade 500Ml",
                "reference" => "212840",
                "price" => "3200",
                "weight" => "1",
                "category" => "$this->cat4",
                "stock" => "20",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Lata Gaseosa Colombiana 269Ml",
                "reference" => "175155",
                "price" => "3500",
                "weight" => "10",
                "category" => "$this->cat4",
                "stock" => "35",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
            [
                "name" => "Coca Cola X 400 Ml",
                "reference" => "209743",
                "price" => "2200",
                "weight" => "10",
                "category" => "$this->cat4",
                "stock" => "25",
                "created_at" =>  $this->date,
                "updated_at" => $this->date
            ],
        ]);
    }
}
