<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($opcionmenu, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="form-group">
		{!! Form::label('nombre', 'Descripción:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion', 'placeholder' => 'Ingrese la descripción')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('icono', 'Icono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('icono', $opcionmenu?$opcionmenu->icono : null, array('class' => 'form-control input-xs', 'id' => 'icono', 'placeholder' => 'Ingrese el ícono')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('orden', 'Orden', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('orden', $opcionmenu?$opcionmenu->orden : null, array('class' => 'form-control input-xs', 'id' => 'orden', 'placeholder' => 'Ingrese el nro de orden')) !!}
		</div>
	</div>	
	<div class="form-group">
		{!! Form::label('link', 'Link', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('link', $opcionmenu?$opcionmenu->link : null, array('class' => 'form-control input-xs', 'id' => 'link', 'placeholder' => 'Ingrese el nro de link')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('grupomenu_id', 'Grupo de Menú:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('grupomenu_id', $cboGrupos, null, array('class' => 'form-control input-xs', 'id' => 'grupomenu_id')) !!}
		</div>
	</div>		
	
	</div>
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('400');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
}); 
</script>