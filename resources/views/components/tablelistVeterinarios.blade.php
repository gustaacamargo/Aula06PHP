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
                    <td>{{ $item['nome'] }}</td>
                    <td>
                        <a href="{{ route('veterinarios.edit', $item['id']) }}"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

