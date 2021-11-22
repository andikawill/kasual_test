<div class="table-responsive">
    <table class="table" id="spreadsheets-table">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Ip Address</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            <pre>
</pre>

        @foreach($spreadsheets as $key => $value)

            @if(!empty($value['id']))
            <tr>
                <td>{{ $value['id'] }}</td>
                <td>{{ $value['first_name'] }}</td>
                <td>{{ $value['last_name'] }}</td>
                <td>{{ $value['gender'] }}</td>
                <td>{{ $value['email'] }}</td>
                <td>{{ $value['ip_address'] }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['spreadsheets.destroy', $value['id']], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('spreadsheets.show', [$value['id']]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('spreadsheets.edit', [$value['id']]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
