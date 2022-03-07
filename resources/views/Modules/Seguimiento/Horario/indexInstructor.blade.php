@extends('templates.devoops')
@section('content')
	{!! getHeaderMod('Horario','Instructor') !!}
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="box ui-draggable ui-droppable">
				<div class="box-header">
					<div class="box-name ui-draggable-handle">
						<span>Horario - Instructor</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="expand-link">
							<i class="fa fa-expand"></i>
						</a>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<form method="GET">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 5px;">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-12 col-xs-12">
											<center><label>Trimestre Acad&eacute;mico: </label><center>
											<div class="row">
												<div class="col-md-5">
												<small>A&ntilde;o</small>
													<select name="year" id="years" class="form-control" onchange="filterList(document.getElementById('years').value)" required>
														@foreach($anioslis as $val)
															<?php $selecione = ""; ?>
															@if(isset($year) && $val == $year)
																<?php $selecione = "selected"; ?>
														    @else
															    @if(!isset($year) && $val == date('Y'))
																<?php $selecione = "selected"; ?>
                                                                @endif
															@endif
															<option value="{{$val}}" {{$selecione}}>{{$val}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-7">
													<small>Trimestre - Inicio - Fin</small>
													<select class="form-control trimestres" name="pla_fec_tri_id" required>
														<option value = "">Seleccione...</option>
														@if(isset($pla_fec_tri_id))
														<option <?php echo $pla_fec_tri_id =="todos" ? "selected" :  "" ?> value = "todos">Todos los trimestres</option>
															@foreach($trimestres as $val)
																<?php 
																$selecione = "";
																$contenido = "";
																?>
																@if($pla_fec_tri_id == $val->pla_fec_tri_id)
																	<?php $selecione = "selected"; ?>
																@endif
																@if(isset($year) && $val->pla_fec_tri_year != $year)
																  <?php $contenido ="display:none"; ?>
																@else
																  @if(!isset($year) && $val->pla_fec_tri_year != date('Y'))
																  	<?php $contenido ="display:none"; ?>
																  @endif
																@endif
																<option <?php echo $selecione; ?> value="{{ $val->pla_fec_tri_id }}" style="{{$contenido}}">{{ $val->pla_fec_tri_trimestre }} - {{ $val->pla_fec_tri_fec_inicio }} - {{ $val->pla_fec_tri_fec_fin }}</option>
															@endforeach
														@else
														    <option value = "todos">Todos los trimestres</option>
															@foreach($trimestres as $val)
															    <?php $contenido = ""; ?>
															      @if($val->pla_fec_tri_year != date('Y'))
																  	<?php $contenido ="display:none"; ?>
																  @endif
																<option value="{{ $val->pla_fec_tri_id }}" style="{{$contenido}}">{{ $val->pla_fec_tri_trimestre }} - {{ $val->pla_fec_tri_fec_inicio }} - {{ $val->pla_fec_tri_fec_fin }}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
										</div>
									</div>

									@if($rol == 5 or $rol == 3 or $rol == 0 or $rol == 8 or $rol == 10 or $rol == 16)
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 10px 0px 10px 0px;">
										<div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-12 col-xs-12">
											<label>Coordinaci&oacute;n: </label><br>
											<select class="form-control" name="par_identificacion_coordinador" id ="par_identificacion_coordinador">
												<option value = "">Seleccionar instructor(es)</option>	
												@if(isset($par_identificacion_coordinador))
													@foreach($coordinadores as $val)
														<?php $selected = ''; ?>
														@if($par_identificacion_coordinador == $val->par_identificacion)	
														<?php $selected = 'selected'; ?>
														@endif
														<option <?php echo $selected; ?> value="{{ $val->par_identificacion }}">{{ ucwords(mb_strtolower($val->par_nombres)) }} {{ ucwords(mb_strtolower($val->par_apellidos)) }}</option>
													@endforeach
													@if($par_identificacion_coordinador == 'todas')
														<option selected value="todas">Todas las coordinaciones</option>
													@else
														<option value="todas">Todas las coordinaciones</option>	
													@endif
												@else
													@foreach($coordinadores as $val)
													<option value="{{ $val->par_identificacion }}">{{ ucwords(mb_strtolower($val->par_nombres)) }} {{ ucwords(mb_strtolower($val->par_apellidos)) }}</option>
													@endforeach
													<option value="todas">Todas las coordinaciones</option>
												@endif
											</select>
										</div>
									</div>
									@endif
									<?php
										$style = '';
										$required = '';
										if(isset($par_identificacion_coordinador) and $par_identificacion_coordinador != ''){
											$style = 'style="display:none;"';
										}else{
											$required = 'required';
										}
									?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="contenedor_seleccionar_ficha" <?php echo $style; ?>>
										<div class="col-lg-6 col-lg-push-3 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
											<label>Seleccione instructor(es): </label><br>
											<select id="pla_fic_id" class="js-example-basic-multiple" name="par_identificacion[]" multiple="multiple" <?php echo $required; ?>>
												@if(isset($par_identificacion))
													@foreach($instructores as $val)
														<?php $selected = ""; ?>
														@if(in_array($val->par_identificacion, $par_identificacion))
														<?php $selected = "selected"; ?>
														@endif
														<option <?php echo $selected; ?> value="{{ $val->par_identificacion }}">{{ ucwords(mb_strtolower($val->nombre)) }}</option>
													@endforeach
												@else
													@foreach($instructores as $val)
														<option value="{{ $val->par_identificacion }}">{{ ucwords(mb_strtolower($val->nombre)) }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="col-lg-3 col-lg-push-3 col-md-3 col-md-push-3" style="margin-top: 10px;">
											<input value="Buscar" class ="form-control btn btn-primary" type="submit">
										</div>
										<div class="col-lg-3 col-lg-push-3 col-md-3 col-md-push-3" style="margin-top: 10px;">
											<a href="{{ url('seguimiento/horario/indexinstructor') }}" class ="form-control btn btn-default">Limpiar filtro</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row" id="url" data-url="{{ url('seguimiento/horario/actividadesinstructor') }}">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							@if(isset($programacion) and count($programacion)>0)
							<div style="position:fixed; z-index:10;right: 16px;">
									<a class="btn btn-success" href="exportaractinstructor?instructor={{ $par_identificacion_coordinador !='' ?$par_identificacion_coordinador: $instructor }}&year={{ isset($year) ? $year :'' }}&exportar=si">Actividades <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
									<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
									<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
									</svg></a>
								</div>
							    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
									<?php
										$host= $_SERVER["HTTP_HOST"];
										$url= $_SERVER["REQUEST_URI"];
										$url ="http://" . $host . $url.'&generar=PDF';
									?>
									<a title="Exportar a PDF" target="_blank" href="<?php echo $url; ?>"><img style="cursor:pointer;" src="{{ asset('img/horario/PDF2.png') }}"></a>
								</div>
								@foreach($programacion as $key => $val)
								 <?php $contador=0; ?>
									@foreach($val as $key1 => $val1)
									   <?php $contador++; ?>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
											<h5 style="margin: 0px;text-align:center;font-weight: bold;"> {{ $val1["instructor"] }}</h5>
											<h6 style="margin: 2px 0px 2px 0px;text-align:center;">
												<strong>Fecha inicio:</strong> {{ $key1 }}
												<strong>Fecha fin:</strong> {{ $val1['fecha_fin'] }}
											</h6>
											<?php
												$estilos = 5;
												if($rol == 0 or $rol == 5){
													$estilos = -4;
												}
											?>
											@if($contador == 1)
												<center><a style="font-size:14px;cursor:pointer;" id='abrir_tri' data-id="{{ $key }}" data-nombre="{{ $val1['instructor'] }}" data-year="{{$year}}" data-url="{{url('seguimiento/horario/actividadesinst')}}">Actividades</a> &nbsp;</center>
                                    		@endif
											<h6 style="margin: 0px 0px {{ $estilos }}px 0px;color:red;"><strong>Horas programadas:</strong><?php echo (isset($val1['horas_programadas'])) ? $val1['horas_programadas'] : 0; ?></h6>
										</div>
										@if($rol == 0 or $rol == 5)
										<!--      -->
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
											<a style="font-size:14px;cursor:pointer;" class="contenidoRestriccion" data-cc="{{ $key }}" data-fecha-inicio="{{ $key1 }}" data-fecha-fin="{{ $val1['fecha_fin'] }}" data-instructor="{{ $val1['instructor'] }}">Editar restricci&oacute;n</a> &nbsp;
											<a style="font-size:14px;cursor:pointer;padding-left: 5px;" class="complementario" data-cc="{{ $key }}" data-fecha-inicio="{{ $key1 }}" data-fecha-fin="{{ $val1['fecha_fin'] }}" data-instructor="{{ $val1['instructor'] }}">Editar complementario</a>
										</div>
										@endif
										<!--      -->
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="padding: 0px 75px;">
											<table style="margin-bottom:15px;" data-cc="{{ $key }}" data-instructor="{{ $val1['instructor'] }}" data-fecha-inicio="{{ $key1 }}" data-fecha-fin="{{ $val1['fecha_fin'] }}" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="width:78px;padding:2px;font-size:12px;text-align: center;">Hora</th>
														@for($i=0; $i<=5; $i++)
														<th style="min-width:90px;padding:2px;font-size:12px;text-align: center;">{{ $diaOrtografia[$i] }}</th>	
														@endfor
													</tr>
												</thead>
												<tbody>
													<?php
													for($h=1; $h<7; $h++){
														$horas[$h]['can'] = 16;
														$horas[$h]['total'] = 16;
													}
													?>
													@for($j=6; $j<22; $j++)
														<tr>
															<th style='padding:5px;font-size:11px;text-align:center;'>{{ $j }}:00 - {{ ($j+1) }}:00</th>
															@for($i=1; $i<7; $i++)
																@if($horas[$i]['can'] == $horas[$i]['total'])
																	<?php
																		$control = false;
																	?>
																	@foreach($val1['hInicio'] as $key2 => $val2)
																		@if($val1['dia_id'][$key2] == $i and $val2 == $j)
																			<?php
																				$ficha = $val1['ficha'][$key2];
																				$programa = $val1['programa'][$key2];
																				$sigla = $val1['sigla'][$key2];
																				$ambiente = $val1['ambiente'][$key2];
																				$horas_totales = $val1['hTotales'][$key2];
																				$numero_trimestre = $val1['trimestre'][$key2];
																				$pla_fic_id = $val1['pla_fic_id'][$key2];
																				$fecha_inicio_actividad = $val1['fecha_inicio_actividad'][$key2];
																				$fecha_fin_actividad = $val1['fecha_fin_actividad'][$key2];
																				$control = true;
																				/*if(isset($actividades_programadas[$key][$l][$instructor_cedula])){
																					$mensaje = '<h6 style="margin:1px 0px 2px 0px;font-size:9px;">Ver actividades</h6>';
																					$estilos_celda = 'background:#087b76';
																					$actividad_clase = 'actividad';
																				}else{
																					$mensaje = '<h6 style="margin:1px 0px 2px 0px;font-size:9px;">Sin actividad</h6>';
																					$estilos_celda = 'background:red';
																					$actividad_clase = '';
																				}*/
																			?>
																		@endif
																	@endforeach

																	@if($control == true)
																		<td fecha-fin-actividad='{{ $fecha_fin_actividad }}' fecha-inicio-actividad='{{ $fecha_inicio_actividad }}' title="{{ $programa }}" data-programa="{{ $programa }}" data-ficha="{{ $ficha }}" data-pla-fic-id="{{ $pla_fic_id }}" data-trimestre="{{ $numero_trimestre }}" data-cc="{{ $key }}" rowspan="{{ $horas_totales }}" class="text-center actividadInstructor" style="padding: 0px;vertical-align: middle;cursor:pointer;">
																			<h6 style="margin:2px 0px 0px 0px;font-size:10.5px;font-weight: bold;"><strong style="font-size:9px;">{{ $sigla }}</strong> {{ $ficha }}</h6>
																			<h6 style="margin:0px 0px 2px 0px;font-size:10px;font-weight: bold;">{{ $ambiente }}</h6>
																		</td>
																		<?php $horas[$i]['can'] -= $horas_totales; ?>
																	@else
																		<td></td>
																		<?php $horas[$i]['can']--; ?>
																	@endif
																@endif
																<?php $horas[$i]['total']--; ?>
															@endfor
														</tr>
													@endfor
												</tbody>
											</table>
										</div>
									@endforeach
								@endforeach
							@else
								@if(isset($par_identificacion))
								<h5 class="text-center">No se encontraron registros del instructor en el trimestre seleccionado.</h5>
								@endif
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal actividades generales del instructor-->
	<div id="modaltri" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width:76%">															
			<!-- Modal content-->
			<div class="modal-content">
				<div class="text-center">
					<button type="button" class="close" data-dismiss="modal" style="margin:8px 14px 0px 0px;">&times;</button>	
					<div class="alert alert-success" style="background-color:#087b76;margin:0px;color:white;border:black;border-radius:0px;">
						<div id="header-info">
						<strong class="modal-title" style="font-size:15px;">ACTIVIDADES</strong><br>
                            <strong class="modal-title" style="font-size:15px;">Instructor: </strong><small id="instructor" style="font-size:16px;"></small><br>
							<strong class="modal-title" style="font-size:15px;">CC: </strong><small id="cc" style="font-size:16px;"></small>						
						</div>
					</div>
				</div>
				<div class="borrar modal-body">
					<div id="fechastrimestres" class="col-md-3 text-center" style="margin-bottom:15px;left:38%;"></div>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
							    <th style="text-align:center;">Ficha</th>
							    <th style="text-align:center;">Programa</th>
							    <th style="text-align:center;">Trimestre</th>
								<th style="text-align:center;">Fase</th>
								<th style="text-align:center;">Competencia</th>
								<th style="text-align:center;">Resultado</th>
								<th style="text-align:center;">Actividad</th>
								<th style="text-align:center;">Horas</th>
								<th style="text-align:center;">Fecha Inicio</th>
								<th style="text-align:center;">Fecha Fin</th>

							</tr>
						</thead>
						<tbody id="contenido">
						</tbody>
					</table>
					<div id="botones"></div>
				</div>
				<div class="modal-footer">
					<a style="margin:0px;" class="btn btn-info btn-xs" id="descargar">Descargar</a>
					<button style="margin:0px;" class="btn btn-danger btn-xs" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Modal actividades individuales del instructor-->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width:76%">															
			<!-- Modal content-->
			<div class="modal-content">
				<div class="text-center">
					<button type="button" class="close" data-dismiss="modal" style="margin:8px 14px 0px 0px;">&times;</button>	
					<div class="alert alert-success" style="background-color:#087b76;margin:0px;color:white;border:black;border-radius:0px;">
						<span style="display: block;position: fixed;">Actividades</span>
						<strong class="modal-title" style="font-size:15px;">Ficha: </strong><small id="ficha" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Trimestre ficha # </strong><small id="trimestre" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Programa: </strong><small id="programa" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Fecha inicio: </strong><small id="fecInicio" style="font-size:16px;"></small>&nbsp;&nbsp;
						<strong class="modal-title" style="font-size:15px;">Fecha fin: </strong><small id="fecFin" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Instructor: </strong><small id="instructor" style="font-size:16px;"></small><br>	
						<strong class="modal-title" style="font-size:15px;">CC: </strong><small id="cc" style="font-size:16px;"></small>						
					</div>
				</div>
				<div class="borrar modal-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th style="text-align:center;">Fase</th>
								<th style="text-align:center;">Competencia</th>
								<th style="text-align:center;">Resultado</th>
								<th style="text-align:center;">Actividad</th>
								<th style="text-align:center;">Horas</th>
							</tr>
						</thead>
						<tbody id="contenido">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button style="margin:0px;" class="btn btn-danger btn-xs" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Restricciones-->
	<div id="modalRestricciones" class="modal fade" data-token="{{ csrf_token() }}" data-url-guardar-cambios="{{ url('seguimiento/horario/guardarcambios') }}" data-url-eliminar="{{ url('seguimiento/horario/eliminarrestriccion') }}" data-url="{{ url('seguimiento/horario/modalrestriccion') }}">
		<div class="modal-dialog" style="width:76%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="text-center">
					<button type="button" class="close" data-dismiss="modal" style="margin:8px 14px 0px 0px;">&times;</button>	
					<div class="alert alert-success" style="background-color:#087b76;margin:0px;color:white;border:black;border-radius:0px;">
						<span style="display: block;position: fixed;">Restricciones</span>
						<strong class="modal-title" style="font-size:15px;">CC: </strong><small id="cc" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Instructor: </strong><small id="instructor" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Fecha inicio: </strong><small id="fecInicio" style="font-size:16px;"></small>&nbsp;&nbsp;
						<strong class="modal-title" style="font-size:15px;">Fecha fin: </strong><small id="fecFin" style="font-size:16px;"></small><br>					
					</div>
				</div>
				<div class="borrar modal-body">
					<form id="formularioRestricciones">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center" style="padding:5px;">D&iacute;a</th>
									<th class="text-center" style="padding:5px;">Hora inicio</th>
									<th class="text-center" style="padding:5px;">Hora fin</th>
									<th class="text-center" style="padding:5px;">Ambiente</th>
									<th class="text-center" style="padding:5px;">Acci&oacute;n</th>
								</tr>
							</thead>
							<tbody id="contenidoTabla">
							</tbody>
						</table>
					</form>
					
					<div id="contenedorGuardarCambiosRestriccion" class="row" style="display:none;">
						<div class="col-lg-12 col-md-12 text-center">
							<a class="btn btn-success btn-xs botonGuardarCambiosRestriccion">Guardar cambios</a>
						</div>
					</div>

					<div class="row">
						<div style="display:none;" id="notificaciones" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">														
								<h5><strong>Notificaciones</strong></h5>
							</div>
							<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-1 col-sm-12 col-xs-12 text-center">	
								<div id="contenidoNotificaciones" style="border: solid 1px black;background:#ececec;color:black;" class="alert alert-info">
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button style="margin:0px;" class="btn btn-danger btn-xs" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal complementario-->
	<div id="modalComplementario" class="modal fade" data-url-guardar-cambios="{{ url('seguimiento/horario/guardarcambioscomplementario') }}" data-token="{{ csrf_token() }}" data-url-eliminar="{{ url('seguimiento/horario/eliminarrestriccion') }}" data-url="{{ url('seguimiento/horario/modalcomplementario') }}">
		<div class="modal-dialog" style="width:76%">															
			<!-- Modal content-->
			<div class="modal-content">
				<div class="text-center">
					<button type="button" class="close" data-dismiss="modal" style="margin:8px 14px 0px 0px;">&times;</button>	
					<div class="alert alert-success" style="background-color:#087b76;margin:0px;color:white;border:black;border-radius:0px;">
						<span style="display: block;position: fixed;">Complementario</span>
						<strong class="modal-title" style="font-size:15px;">CC: </strong><small id="cc" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Instructor: </strong><small id="instructor" style="font-size:16px;"></small><br>
						<strong class="modal-title" style="font-size:15px;">Fecha inicio: </strong><small id="fecInicio" style="font-size:16px;"></small>&nbsp;&nbsp;
						<strong class="modal-title" style="font-size:15px;">Fecha fin: </strong><small id="fecFin" style="font-size:16px;"></small><br>					
					</div>
				</div>
				<div class="borrar modal-body">
					<form id="formularioComplementario">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center" style="padding:5px;">D&iacute;a</th>
									<th class="text-center" style="padding:5px;">Hora inicio</th>
									<th class="text-center" style="padding:5px;">Hora fin</th>
									<th class="text-center" style="padding:5px;">Ambiente</th>
									<th class="text-center" style="padding:5px;">Acci&oacute;n</th>
								</tr>
							</thead>
							<tbody id="contenidoTabla">
							</tbody>
						</table>
					</form>

					<div id="contenedorGuardarCambiosComplementario" class="row" style="display:none;">
						<div class="col-lg-12 col-md-12 text-center">
							<a class="btn btn-success btn-xs botonGuardarCambiosComplementario">Guardar cambios</a>
						</div>
					</div>

					<div class="row">
						<div style="display:none;" id="notificaciones" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">														
								<h5><strong>Notificaciones</strong></h5>
							</div>
							<div class="col-lg-8 col-lg-push-2 col-md-10 col-md-push-1 col-sm-12 col-xs-12 text-center">	
								<div id="contenidoNotificaciones" style="border: solid 1px black;background:#ececec;color:black;" class="alert alert-info">
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button style="margin:0px;" class="btn btn-danger btn-xs" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function filterList(param) {
			document.querySelectorAll(".trimestres").forEach(val => {
				options = val.options;
                for (let index = 0; index < options.length; index++) {
					ele = options[index].text;
					valor = options[index].value;
					console.log(valor);
					if (!ele.toLowerCase().includes(param.toLowerCase()) &&  valor!="" && valor!="todos") {
						options[index].style.display="none";
					}else{
						options[0].selected = true;
						options[index].style.display="block";
					}
				}
			});
		}
	</script>
@endsection
@section('plugins-js')
<script type="text/javascript">
	//modal
    $(document).ready(function () {
        $(document).on('click','#abrir_tri', function(){
            $("#modaltri").modal();
			$("#contenido").html('');
			$("#botones").html('');
            var url = $(this).attr("data-url");
            var data_id = $(this).attr("data-id");
            var data_year = $(this).attr("data-year");
			var data_nombre = $(this).attr("data-nombre");
			var ruta = "exportaractinstructor?instructor="+data_id+"&year="+data_year;
            $("#descargar").attr("href",ruta); 
			$("#cc").html(data_id);
			$("#instructor").html(data_nombre);
            $.ajax({
                url:url,
                type:"GET",
                data:"instructor="+data_id+"&year="+data_year,
				success:function (html){
					$("#fechastrimestres").html(html[0]);
					$("#contenido").html(html[1]);
					$("#botones").html(html[2]);
				}
            });
        });

        $(document).on("change","#fechastri", function(){
			var url = $("#abrir_tri").attr("data-url");
            var data_id = $(this).attr("data-id");
		    var data_year = $("#abrir_tri").attr("data-year");
			var data_tri = $(this).val();
			$("#contenido").html('');
			$("#botones").html('');
			$.ajax({
                url:url,
                type:"GET",
                data:"instructor="+data_id+"&year="+data_year+"&trimestre="+data_tri,
				success:function (html){
					$("#fechastrimestres").html(html[0]);
					$("#contenido").html(html[1]);
					$("#botones").html(html[2]);
				}
            });
		});

		$(document).on("click", ".pagina2", function(){
			var url = $(this).attr("data-url2");
			var data_pagina = $(this).attr("data-pagina2");
			var data_year = $("#abrir_tri").attr("data-year");
			var data_id = $("#fechastri").attr("data-id");
			var data_tri = $("#fechastri").val();
			$("#contenido").html('');
			$("#botones").html('');	
					
			 $.ajax({
				url:url,
				type:"GET",
				data:"pagina="+data_pagina+"&year="+data_year+"&instructor="+data_id+"&trimestre="+data_tri, 
				success: function (data) {
					$("#fechastrimestres").html(data[0]);
					$("#contenido").html(data[1]);
					$("#botones").html(data[2]);
				}
			}); 
		});
    });

    </script>
    @endsection