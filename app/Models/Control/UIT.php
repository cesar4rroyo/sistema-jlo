<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UIT extends Model
{
    use SoftDeletes;
    protected $table = 'uit';
    protected $dates = ['deleted_at'];
}
