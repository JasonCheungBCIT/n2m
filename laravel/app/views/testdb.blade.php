<table>
    <tr>
        <td>ID</td>
        <td>Name</td>
    </tr>

    @foreach($allUsers as $usr)

        <tr>
            <td>{{ $usr->id }}</td>
            <td>{{ $usr->email }}</td>
            <td>{{ $usr->password }}</td>
            <td>{{ $usr->note }}</td>


        </tr>

    @endforeach
</table>