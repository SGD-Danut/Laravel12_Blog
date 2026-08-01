@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    <link rel="stylesheet" href="/admin-assets/js/datatables/datatables.css">
    {{-- Margini tabel datatables CSS custom: --}}
    <style>
        #datatables_wrapper {
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        <br>
        <a href="{{ route('admin.show-add-user') }}">
            <button type="button" class="btn btn-success new-user-button">Utilizator nou</button>
        </a>
    </div>
    <table class="table table-hover my-0" id="datatables">
        <thead>
            <tr>
                <th class="d-none d-xl-table-cell">Nume</th>
                <th class="d-none d-xl-table-cell">Email</th>
                <th class="d-none d-xl-table-cell">Adresă / Telefon</th>
                <th class="d-none d-xl-table-cell">Fotografie</th>
                <th class="d-none d-xl-table-cell">Rol</th>
                <th class="d-none d-md-table-cell">Creat la</th>
                <th class="d-none d-md-table-cell">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="d-none d-xl-table-cell">{{ $user->name }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->address . ' ' . $user->phone }}</td>
                    <td class="d-none d-xl-table-cell">
                        @if ($user->photo == 'defaultUserPhoto.png')
                            <img src="/admin-assets/images/users/{{ $user->photo }}" class="mx-auto" width="35" alt="Imagine utilizator">
                        @else
                            <img src="/storage/admin/images/users/{{ $user->photo }}" class="mx-auto" width="35" alt="Imagine utilizator">
                        @endif
                    </td>
                    <td class="d-none d-xl-table-cell">{{ $user->role }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <a href="{{ route('admin.show-edit-user', $user->id) }}"><button type="button" class="btn btn-primary">Editare</button></a>
                            <form id="delete-user-form-with-id-{{ $user->id }}" action="{{ route('delete-user', $user->id) }}" method="POST" style="display: none">
                                @csrf
                                @method('delete')
                            </form>
                            <button type="button" class="btn btn-danger" 
                                onclick="
                                    if (confirm('Sigur ștergeți acest utilizatorul: {{ addslashes($user->name) }} ?')) {
                                        document.getElementById('delete-user-form-with-id-{{ $user->id }}').submit();
                                    }
                                ">Ștergere
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('custom-js')
	<script src="/admin-assets/js/jquery/jquery-4.0.0.slim.min.js"></script>
	<script src="/admin-assets/js/datatables/datatables.min.js"></script>
	<script>
		let table = new DataTable('#datatables', {
			language: {
				search: "Căutare:",
				info: "Se afișează pagina _PAGE_ din _PAGES_",
				lengthMenu: "Afișează _MENU_ înregistrări pe pagină",
				zeroRecords: "Nu au fost găsite rezultate",
				infoEmpty: "Nu sunt înregistrări disponibile",
				infoFiltered: "(filtrate dintr-un total de _MAX_ înregistrări)",
				paginate: {
					first: "Prima",
					previous: "Precedenta",
					next: "Următoarea",
					last: "Ultima"
				}
			}
		});
	</script>
@endsection