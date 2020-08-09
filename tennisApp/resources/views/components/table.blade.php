<table class="table-users">
    <thead>
    @foreach($thead as $th)
        <th>{{$th}}</th>
    @endforeach
    </thead>
    <tbody>
    @foreach($tbody ?? [] as $td)
        <tr>
            @foreach($td as $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
