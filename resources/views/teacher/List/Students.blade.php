@extends('layouts.app')

@section('content')
    <h1>Students</h1>

    <form action="/Students" method="GET">
        <div class="form-group  d-flex p-3">
            <h4 for="class" class="d-flex col-2">Select Class:</h4>
            <select name="class" id="class" class="form-control">
                <option value="">All</option>
                @foreach($classes as $id => $name)
                    <option value="{{ $id }}" {{ request('class') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Name &nbsp &nbsp &nbsp</th>
                <th>Email  &nbsp &nbsp &nbsp</th>
                <th>Class  &nbsp &nbsp &nbsp</th> 
                <th>Action  &nbsp &nbsp &nbsp</th>
            </tr>
        </thead>
        <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td> 
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->classes->first()->NameClass }}</td> 
                    <td>     
                        <a href='/Students/{{$user->id}}/edit' class='btn btn-primary'>Edit</a></button>
                        <form action='/Students/{{$user->id}}' method='POST' style='display:inline'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class='btn btn-danger'>Delete</button>       
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

 