@extends('administration.layout')
@section('administrationContent')
<div class="row justify-content-center">
	<div class="col-md-2">
		<div class="d-none d-md-block navbar-expand-md">
			@include('administration.actions', ['collapse' => '', 'navactions_id' => 'navactions'])
		</div>
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="d-flex flex-column">
				<div class="p-2 text-white bg-info border-bottom rounded-top">
					<div class="d-flex">
						<div><span>Administración</span></diV>
						<div class="ml-auto">
							<div class="d-block d-md-none">@include('administration.actions', ['collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row"><div class="container">@include('common_status')</div></div>
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
						  <div class="card-body">
							<h5 class="card-title">Gestión de Comerciales</h5>
							<p class="card-text">Administra los comerciales y las entrevistas realizadas</p>
						  </div>
						</div>
					  </div>
					  <div class="col-sm-6">
						<div class="card">
						  <div class="card-body">
							<h5 class="card-title">Gestión de Soporte</h5>
							<p class="card-text">Permite la administración de empresas y puestos</p>
						  </div>
						</div>
					  </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
