<div class="table-responsive" style="overflow-x: visible; overflow-y: visible;">
    <table class='table table-striped'>
        <thead>
            <tr style="text-align: center">
                @foreach ($header as $item)
                    <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr style="text-align: center">
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['nome'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['telefone'] }}</td>
                    <td>
                        <a href="{{ route('clientes.show', $item['id']) }}"><img src="{{ asset('img/icons/info.svg') }}"></a>
                        <a href="{{ route('clientes.edit', $item['id']) }}"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                        <a href="javascript:form_{{$item['id']}}.submit()"><img src="{{ asset('img/icons/delete.png') }}"></a>
                    </td>
                </tr>
                <form action="{{ route('clientes.destroy', $item['id']) }}"
                    method="POST" name="form_{{$item['id']}}">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </tbody>
    </table>
</div>

