<?php

namespace App\Models\Control;

use App\Models\Gestion\Tramite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipotramitenodoc extends Model
{
	use SoftDeletes;
    protected $table = 'tipotramitenodoc';
    protected $dates = ['deleted_at'];

    // public function tramite()
    // {
    //     return $this->hasMany(Tramite::class, 'tipotramitenodoc_id');
    // }

   
}
