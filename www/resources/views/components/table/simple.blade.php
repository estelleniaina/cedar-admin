{{--@php(dump($thead))--}}
{{--@php(dump($data))--}}
<table id="datatable" class="table">
    <thead>
    <tr>
        @foreach($thead as $th => $col)
            <th> {{$col}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                @foreach($thead as $key => $col)
                    @if ($key == 'action')
                        <td> Modifier</td>
                    @else
                        <td> {{ $row[$key] ?? '' }} </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
