<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VeiculoModelo extends Model
{
    protected $fillable = array('veiculoModelo', 'veiculoMarcaId', 'dataCadastro', 'horaCadastro', 'isAtivo');

    protected $table = 'veiculomodelo'; 
}
