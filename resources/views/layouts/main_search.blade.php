<form class="form-inline" action="{{action('HomeController@index')}}" method="GET">
  @csrf
  <div class="input-group">
    <input type="search" class="form-control" placeholder="@lang('messages.Search')" aria-label="@lang('messages.Search')" aria-describedby="basic-addon2" id="name_filter" name="name_filter">
    <div class="input-group-append">
      <button class="btn btn-success" type="submit">@lang('messages.Search')</button>
    </div>
  </div>
</form>
