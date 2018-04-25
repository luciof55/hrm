@extends('admin.profiles.profile')

@section('button_content')
<div class="form-group row mb-0">
	<div class="col-md-6 offset-md-4">
		<button type="submit" class="btn btn-primary">
			{{ __('Update') }}
		</button>
		<button class="btn btn-primary" onclick="crudInstance.postFormBack('commandForm', '{{ $actionBack }}', 'GET');">{{ __('Cancel') }}</button>
	</div>
</div>
@endsection
