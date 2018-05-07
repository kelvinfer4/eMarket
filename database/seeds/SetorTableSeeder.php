<?php

use Illuminate\Database\Seeder;

class SetorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produtosetores')->insert([
            'nome'    => 'PADARIA',
            'isAtivo' => 1
        ]);

        DB::table('produtosetores')->insert([
            'nome'    => 'HORTIFRUTI',
            'isAtivo' => 1
        ]);
    }
}