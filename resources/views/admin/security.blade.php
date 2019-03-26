@extends('admin.layout')
@section('securityContent')
<div class="row justify-content-center">
	<div class="col-md-2">
		@include('admin.actions')
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="d-flex flex-column">
				<div class="p-2 text-white bg-info border-bottom rounded-top">Seguridad</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="container">
						@include('common_status')
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
						  <div class="card-body">
							<h5 class="card-title">Gestión de Perfiles</h5>
							<p class="card-text">Los perfiles determinan el conjunto de permisos de un usuario</p>
						  </div>
						</div>
					  </div>
					  <div class="col-sm-6">
						<div class="card">
						  <div class="card-body">
							<h5 class="card-title">Gestión de Usuarios</h5>
							<p class="card-text">Los usuarios que tendrán acceso a la aplicación</p>
						  </div>
						</div>
					  </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
