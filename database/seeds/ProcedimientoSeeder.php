<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
            DB::table('procedimiento')->insert([
                'descripcion' => 'Procedimiento '.($i+1),            
                'areainicio_id' => 1,            
                'areafin_id' => 2,            
            ]);
        }
        
        
    }
}
