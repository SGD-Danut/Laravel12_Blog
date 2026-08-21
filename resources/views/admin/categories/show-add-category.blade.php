@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
  <div class="card-header">
      <h5 class="card-title mb-0">{{ $title }}</h5>
  </div>
  <form action="{{ route('admin.create-category') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
    @csrf
    <div class="mb-3 col-md-4">
        <label for="inputTitle" class="form-label">Nume</label>
        <input onblur="setSlug()" type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') }}">
        @error('title')
          <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-4">
      <label for="inputSlug" class="form-label">Slug</label>
      <input type="text" class="form-control @error('slug') is-invalid @enderror" id="inputSlug" aria-describedby="slugHelp" name="slug" value="{{ old('slug') }}">
      @error('slug')
          <div id="slugHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3 col-md-4">
      <label for="inputSubtitle" class="form-label">Subtitlu</label>
      <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="inputSubtitle" aria-describedby="subtitleHelp" name="subtitle" value="{{ old('subtitle') }}">
      @error('subtitle')
          <div id="subtitleHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3 col-md-2">
      <label for="inputPhoto" class="form-label">Imagine</label>
      <div class="mb-3 text-center" id="image-preview">
        <img src="/admin-assets/images/categories/category.png" class="img-thumbnail" alt="Imagine categorie">
      </div>
      <input type="file" name="image" accept="images/*" id="inputPhoto" class="form-control @error('image') is-invalid @enderror" aria-describedby="imageHelp">
      @error('image')
          <div id="imageHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3 col-md-10">
      <label for="textareaPresentation" class="form-label">Prezentare</label>
      <textarea type="text" class="form-control categoryTextArea @error('presentation') is-invalid @enderror" id="textareaPresentation" aria-describedby="presentationHelp" name="presentation" value="{{ old('presentation') }}"></textarea>
      @error('presentation')
          <div id="presentationHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3 row g-3">
      <div class="mb-3 col-md-4">
        <label for="inputMetaTitle" class="form-label">Meta Title</label>
        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="inputMetaTitle" aria-describedby="metaTitleHelp" name="meta_title" value="{{ old('meta_title') }}">
        @error('meta_title')
          <div id="MetaTitleHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3 col-md-4">
        <label for="inputMetaDescription" class="form-label">Meta Description</label>
        <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="inputMetaDescription" aria-describedby="metaDescriptionHelp" name="meta_description" value="{{ old('meta_description') }}">
        @error('meta_description')
          <div id="MetaDescriptionHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3 col-md-4">
        <label for="inputMetaKeywords" class="form-label">Meta Keywords</label>
        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="inputMetaKeywords" aria-describedby="metaKeywordsHelp" name="meta_keywords" value="{{ old('meta_keywords') }}">
        @error('meta_keywords')
          <div id="MetaKeywordsHelp" class="form-text text-danger">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="mb-3 mx-auto col-lg-3">
      <button type="submit" class="btn btn-primary">Adaugă categorie</button>
    </div>
  </form>
  <br>
@endsection

@section('custom-js')
  @include('scripts.image-preview')
  @include('scripts.transform-to-slug')
  @include('scripts.ckeditor')
@endsection