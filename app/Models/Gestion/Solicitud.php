<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Solicitud extends Model
{
    use SoftDeletes;
    protected $table = 'solicitud';
    protected $dates = ['deleted_at'];

    public function tipotramite()
    {
        return $this->belongsTo(Tipotramitenodoc::class, 'tipo_id');
    }

	public function ordenpago()
    {
        return $this->belongsTo(Ordenpago::class , 'ordenpago_id');
    }

	public function scopeNumeroSigue($query)
	{
            $año=date('Y');
			$rs = $query
				->where(function ($subquery) use ($año) {
					if (!is_null($año) && strlen($año) > 0) {
						$subquery->where('numero', 'LIKE', '%'.$año.'-%');
					}
				})->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,6,11),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 11, '0', STR_PAD_LEFT);
	}

    public function scopelistar($query, $numero, $fecinicio, $fecfin, $contribuyente, $tipo)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('fecha', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fecha', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($tipo) {
				if (!is_null($tipo) && strlen($tipo) > 0) {
					$subquery->where('tipo_id', $tipo);
				}
			})
			->where(function ($subquery) use ($contribuyente) {
				if (!is_null($contribuyente) && strlen($contribuyente) > 0) {
					$subquery->where('nombresolicitante', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('dni', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('ruc', 'LIKE', '%'.$contribuyente.'%');
				}
			})
			->orderBy('created_at', 'DESC');
	}

}
