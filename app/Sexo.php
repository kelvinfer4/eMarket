<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $fillable = array('sexo');

    protected $table = 'sexo';
}