<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Inspeccion extends Model
{
	use SoftDeletes;
    protected $table = 'inspeccion';
    protected $dates = ['deleted_at'];
	protected $fillable = [
        'estado',
    ];
	public function tipotramite()
    {
        return $this->belongsTo(Tipotramitenodoc::class, 'tipo_id');
    }
	
    public function ordenpago()
    {
        return $this->hasOne('App\Models\Gestion\Ordenpago' , 'ordenpago_id');
    }

	public function resolucion()
	{
		return $this->hasOne(Resolucion::class, 'resolucion_id');
	}

	public function inspector()
	{
		return $this->belongsTo(Personal::class, 'inspector_id');
	}

	public function getFullInspeccionAttribute()
	{
		return $this->tipotramite->descripcion . ' - ' . $this->numero;
	}

	public function carta()
	{
		return $this->hasMany(Carta::class);
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
					$subquery->where('tipo_id', 'LIKE', '%'.$tipo.'%');
				}
			})
			->orderBy('created_at', 'DESC');
	}

	public function scopeNumeroSigue($query , $tipo)
	{
			$rs = $query
				->where(function ($subquery) use ($tipo) {
					if (!is_null($tipo) && strlen($tipo) > 0) {
						$subquery->where('tipo_id', $tipo);
					}
				})->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,1,8),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 8, '0', STR_PAD_LEFT);
	}
}
