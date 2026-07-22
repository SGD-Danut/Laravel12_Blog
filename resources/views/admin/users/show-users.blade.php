@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
    </div>
    <table class="table table-hover my-0" id="datatables">
        <thead>
            <tr>
                <th class="d-none d-xl-table-cell">Nume</th>
                <th class="d-none d-xl-table-cell">Email</th>
                <th class="d-none d-md-table-cell">Creat la</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="d-none d-xl-table-cell">{{ $user->name }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->created_at }}</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
@endsection