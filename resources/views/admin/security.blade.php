@extends('admin.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">@lang('messages.Actions')</div>
                <div class="card-body">
                    <div class="content">
						<ul class="nav flex-column nav-pills">
						  <li class="nav-item">
							<a class="nav-link active" href="#">Opción 1</a>
						  </li>
						</ul>
					</div>
                </div>
            </div>
        </div>
		<div class="col-md-10">
            <div class="card">
                <div class="card-header">
					<nav class="navbar navbar-expand-sm  navbar-dark">
						NAVBAR
					</nav>
				</div>
				<div class="row">
					<div class="container"></div>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection