<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($modelo, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
@switch($accion)
	@case('aceptar')
		{!!'<div class="callout callout-warning"><p class="text-primary">¿Esta seguro de aceptar el trámite?</p></div>' !!}
		@break
	@case('rechazar')
		{!!'<div class="callout callout-warning"><p class="text-primary">¿Esta seguro de rechazar el trámite?</p></div>' !!}
		@break
	@case('finalizar')
		{!!'<div class="callout callout-warning"><p class="text-primary">¿Esta seguro de finalizar el trámite?</p></div>' !!}
		@break
@endswitch
@php
	$showbtn=true;
@endphp
@if($accion=='seguimiento')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">				
                <div class="card-body">
					{{-- <div class="float-right">
						<a href="{{route('tramite.printseguimiento', $modelo->id)}}" target="_blank">
							<button type="button" class="btn btn-warning btn-sm">
								<i class="fas fa-print"></i> Imprimir
							</button>
						</a>
					</div> --}}
                    <div id="content">
                        <ul class="timeline">
							@foreach ($modelo->seguimientos as $item)
                            <li class="event">
								<h3> <i class="fas fa-calendar-times"></i> {{$item->fecha}}</h3>
								@if ($item->accion == 'DERIVAR')
                                	<h3> <i class="fas fa-map-marker-alt"></i> Área de origen:  {{ $item->area }}</h3>
									<h3><i class="fas fa-arrow-down"></i></h3>
                                	<h3> <i class="fas fa-map-marker-alt"></i> Área de destino: {{$item->areas->descripcion }}</h3>
								@else
                                	<h3> <i class="fas fa-map-marker-alt"></i> {{($item->areas) ? $item->areas->descripcion : $item->area }}</h3>
								@endif
                                <h3>  ESTADO: 
									<span class="badge {{($item->accion=='RECHAZAR')?'badge-danger':(($item->accion=='FINALIZAR')?'badge-success':(($item->accion=='ADJUNTAR')?'badge-warning':'badge-info'))}}">
										{{$item->accion}}
									</span>
								</h3>
								@if ($item->observacion)
                                	<h3>  OBSERVACION: {{$item->observacion}}</h3>
								@endif
								<h3> RESPONSABLE: {{$item->personal->nombres . ' ' .$item->personal->apellidopaterno .' ' . $item->personal->apellidomaterno}}</h3>
								@if ($item->accion=='COMENTAR' && ($item->ruta!=null || $item->ruta!=''))
									<a href="{{asset('storage\archivos2\\'.$item->ruta)}}" target="_blank"> <i class="fas fa-file-download"></i> Descargar archivo </a>
								@endif
							</li>  
							@endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if ($accion=='comentar')
<div class="form-group">
	{!! Form::label('file', 'Archivo', array('class' => 'control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::file('file', array('id'=>'file')) !!}
	</div>
	{!! Form::label('observacion', 'Observación', array('class' => 'control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
	{!! Form::textarea('observacion', '',array('class' => 'form-control form-control-sm input-xs', 'id' => 'observacion', "rows"=>2 , "style"=>"resize:none;")) !!}
	</div>
</div>
@endif
@if ($accion=='archivar')
{!!'<div class="callout callout-danger"><p class="text-primary">¿Esta seguro que desea archivar la Resolucion?</p></div>' !!}
<div class="form-group">
	{!! Form::label('observacion', 'Motivo', array('class' => 'control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
	{!! Form::textarea('observacion', '',array('class' => 'form-control form-control-sm input-xs', 'id' => 'observacion', "rows"=>2 , "style"=>"resize:none;")) !!}
	</div>
</div>
@endif
@if ($accion=='entregar')
	{!!'<div class="callout callout-danger"><p class="text-primary">¿Esta seguro que la Resolución ya fue entregada?</p></div>' !!}
@endif
@if ($accion=='coactiva')
	{!!'<div class="callout callout-danger"><p class="text-primary">¿Esta seguro que desea enviar la Resolución a Coactiva?</p></div>' !!}
@endif
@if ($accion=='pagar')
	@php
		$date_expire = $modelo->fechaentrega;    
		$date = new DateTime($date_expire);
		$now = new DateTime();
		$diff=$date->diff($now);	
	@endphp
	@if ($diff->days<='5')
		{!!'<div class="callout callout-warning"><p class="text-primary">Esta Resolución tiene la posibilidad de aplicarse descuento del 50%</p></div>' !!}
	@endif
	<div class="form-group">
		{!! Form::label('i_monto', 'Monto a Pagar', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('i_monto', $modelo->notificacion->i_monto, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'i_monto', 'readonly'=>'true')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('montocancelado', 'Monto Cancelado*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('montocancelado', '0.00', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'montocancelado', 'required'=>'true')) !!}
		@if ($diff->days<='5')
			<input type="checkbox" name="descuento" value="descuento" id="cbodescuento"> Aplicar Descuento <br/>
		@endif
		</div>
	</div>
@endif


<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">	
		@if ($accion != 'seguimiento' && $showbtn)
		{!! Form::button('<i class="fa fa-check "></i> '.$boton, array('class' => 'btn btn-warning btn-sm', 'id' => 'btnGuardar', 'type' => 'submit')) !!}
		@endif	
		{!! Form::button('<i class="fa fa-undo "></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal((contadorModal - 1));')) !!}
	</div>
</div>
{!! Form::close() !!}
<style>
	body{margin-top:20px;}
.timeline {
    border-left: 3px solid #727cf5;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    background: rgba(114, 124, 245, 0.09);
    margin: 0 auto;
    letter-spacing: 0.2px;
    position: relative;
    line-height: 1.4em;
    font-size: 1.03em;
    padding: 50px;
    list-style: none;
    text-align: left;
    max-width: 80%;
}

@media (max-width: 767px) {
    .timeline {
        max-width: 98%;
        padding: 25px;
    }
}

.timeline h1 {
    font-weight: 300;
    font-size: 1.4em;
}

.timeline h2,
.timeline h3 {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 10px;
}

.timeline .event {
    border-bottom: 1px dashed #e8ebf1;
    padding-bottom: 25px;
    margin-bottom: 25px;
    position: relative;
}

@media (max-width: 767px) {
    .timeline .event {
        padding-top: 30px;
    }
}

.timeline .event:last-of-type {
    padding-bottom: 0;
    margin-bottom: 0;
    border: none;
}

.timeline .event:before,
.timeline .event:after {
    position: absolute;
    display: block;
    top: 0;
}

.timeline .event:before {
    left: -207px;
    content: attr(data-date);
    text-align: right;
    font-weight: 100;
    font-size: 0.9em;
    min-width: 120px;
}

@media (max-width: 767px) {
    .timeline .event:before {
        left: 0px;
        text-align: left;
    }
}

.timeline .event:after {
    -webkit-box-shadow: 0 0 0 3px #727cf5;
    box-shadow: 0 0 0 3px #727cf5;
    left: -55.8px;
    background: #fff;
    border-radius: 50%;
    height: 9px;
    width: 9px;
    content: "";
    top: 5px;
}

@media (max-width: 767px) {
    .timeline .event:after {
        left: -31.8px;
    }
}

.rtl .timeline {
    border-left: 0;
    text-align: right;
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 4px;
    border-top-left-radius: 4px;
    border-right: 3px solid #727cf5;
}

.rtl .timeline .event::before {
    left: 0;
    right: -170px;
}

.rtl .timeline .event::after {
    left: 0;
    right: -55.8px;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('#i_monto').inputmask('decimal', { rightAlign: false , digits:2  });
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		configurarAnchoModal('700');
		$('input[type=checkbox][id=cbodescuento]').change(function(e){
			var val=e.target.checked;
			if(val){
				var monto = $('#i_monto').val();
				var total = (parseFloat(monto)/2).toFixed(2);
				$('#montocancelado').val(total);
			}else{
				$('#montocancelado').val('0.00');
			}
		});
		$( IDFORMMANTENIMIENTO + '{{ $entidad }}').submit(function( event ) {
			event.preventDefault();
			var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
			var entidad = "{{$entidad}}";
			var formData = new FormData($(this)[0]);
			var respuesta = '';
			var listar       = 'NO';
			if ($(idformulario + ' :input[id = "listar"]').length) {
				var listar = $(idformulario + ' :input[id = "listar"]').val();
			};
			var request = $.ajax({
			url     : $(this).attr('action'),
			method  : "POST",
			data    : formData,
			processData: false,  
			contentType: false,
			});
			request.done(function(msg) {
				respuesta = msg;
				console.log('eeeee');
			}).fail(function(jqXHR, textStatus) {
				respuesta = 'ERROR';
			}).always(function(){
				if(respuesta.trim() === 'ERROR'){
				}else {
					if (respuesta.trim() === 'OK') {
						console.log('eeee');
						cerrarModal();
						Hotel.notificaciones("Accion realizada correctamente", "Realizado" , "success");
						if (listar.trim() === 'SI') {							
							buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
						}        
					} else {
						mostrarErrores(respuesta, idformulario, entidad);
					}
				}
			}); 
    	});
	}); 
	
</script>