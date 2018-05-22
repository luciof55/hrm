<table>
    <thead>
    <tr>
        <th colspan="2">FICHA DE NEGOCIO</th>
    </tr>
    </thead>
    <tbody>
		<tr></tr>
		<tr>
            <td>@lang('messages.Account')</td>
            <td>{{ $command->account->name }}</td>
        </tr>
		<tr>
            <td>Sector</td>
            <td></td>
        </tr>
		<tr>
            <td>Persona de contacto del cliente</td>
            <td></td>
        </tr>
		<tr>
            <td>Proyecto</td>
            <td>{{ $command->name }}</td>
        </tr>
		<tr>
            <td>@lang('messages.Comercial')</td>
            <td>{{ $command->comercialName() }}</td>
        </tr>
		<tr>
            <td>@lang('messages.Leader')</td>
            <td>{{ $command->leaderName() }}</td>
        </tr>
		<tr>
            <td>@lang('messages.Management_tool')</td>
            <td>{{ $command->management_tool }}</td>
        </tr>
		<tr>
            <td>@lang('messages.Repository')</td>
            <td>{{ $command->repository }}</td>
        </tr>
		<tr>
            <td>@lang('messages.Notes')</td>
            <td>{{ $command->notes }}</td>
        </tr>
    </tbody>
</table>