@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
  <div class="card-header">
      <h5 class="card-title mb-0">{{ $title }}</h5>
  </div>
  <form action="{{ route('admin.create-user') }}" method="POST" enctype="multipart/form-data" class="col-lg-3 mx-auto">
    @csrf
    <div class="mb-3">
      <label for="inputName" class="form-label">Nume complet</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="inputName" aria-describedby="nameHelp">
      @error('name')
          <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputEmail" class="form-label">Adresă de email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="inputEmail" aria-describedby="emailHelp">
      @error('email')
          <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputPassword" class="form-label">Parolă</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" aria-describedby="passwordHelp">
      @error('password')
          <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputConfirmPassword" class="form-label">Confirmare parolă</label>
      <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="inputConfirmPassword">
    </div>
    <div class="mb-3">
      <label for="selectRole" class="form-label">Rol</label>
      <select class="form-select" name="role" value="{{ old('role') }}" aria-label="selectRole">
        <option value="editor">Editor</option>
        <option value="author" selected>Autor</option>
        <option value="admin">Administrator</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="inputAddress" class="form-label">Adresă</label>
      <input type="text" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" id="inputAddress" aria-describedby="addressHelp">
      @error('address')
          <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputPhone" class="form-label">Număr de telefon</label>
      <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" aria-describedby="phoneHelp">
      @error('phone')
          <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="checkValidateEmail" class="form-label">Validare email</label>
      <div class="form-check text-start">
          <input class="form-check-input" type="checkbox" value="1" id="checkValidateEmail" name="validateEmail">
          <label class="form-check-label">Email validat</label>
      </div>
    </div>
    <div class="mb-3">
      <label for="inputPhoto" class="form-label">Fotografie</label>
      <div class="mb-3 text-center" id="image-preview">
        <img src="/admin-assets/images/users/defaultUserPhoto.png" class="img-thumbnail" alt="Fotografie utilizator">
      </div>
      <input type="file" name="photo" accept="images/*" id="inputPhoto" class="form-control @error('photo') is-invalid @enderror" aria-describedby="photoHelp">
      @error('photo')
          <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Adaugă utilizator</button>
  </form>
  <br>
@endsection

@section('custom-js')
  @include('scripts.image-preview-script')
@endsection