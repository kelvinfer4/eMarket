<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = array('produtoMarca', 'dataCadastro','horaCadastro', 'isAtivo');

    protected $table = 'produtomarca';
}
