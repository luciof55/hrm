@if (!is_null(Request::get('googleAuthorize')) && Request::get('googleAuthorize'))
  <h3>{{$AppName}}</h3>
  @if (isset($results))
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
          <th>@lang('messages.Files')</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($results->getFiles() as $file)
            <tr>
              <td><img src="{{ asset('public/img/icon_1_spreadsheet_x16.png')}}" alt=""> {{ $file->getName() }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endif
