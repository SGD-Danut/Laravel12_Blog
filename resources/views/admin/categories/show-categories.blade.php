@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        <br>
        <a href="{{ route('admin.show-add-category') }}">
            <button type="button" class="btn btn-success new-category-button">Categorie nouă</button>
        </a>
    </div>
    @include('admin.template.parts.messages')
    <table class="table table-hover my-0" id="categories-table">
        <thead>
            <tr>
                <th class="d-none d-xl-table-cell">Titlu</th>
                <th class="d-none d-xl-table-cell">Subtitlu</th>
                <th class="d-none d-xl-table-cell">Vizualizări</th>
                <th class="d-none d-xl-table-cell">Imagine</th>
                <th class="d-none d-xl-table-cell">Meta Desc / Key</th>
                <th class="d-none d-md-table-cell">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="d-none d-xl-table-cell">{{ $category->title }}</td>
                    <td class="d-none d-xl-table-cell">{{ $category->subtitle }}</td>
                    <td class="d-none d-xl-table-cell">{{ $category->views }}</td>
                    <td class="d-none d-xl-table-cell">
                        @if ($category->image == 'category.png')
                            <img src="/admin-assets/images/categories/{{ $category->image }}" class="mx-auto" width="35" alt="Imagine categorie">
                        @else
                            <img src="/storage/admin/images/categories/{{ $category->image }}" class="mx-auto" width="35" alt="Imagine categorie">
                        @endif
                    </td>
                    <td class="d-none d-xl-table-cell">{{ $category->meta_description . ' / ' . $category->meta_keywords }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection