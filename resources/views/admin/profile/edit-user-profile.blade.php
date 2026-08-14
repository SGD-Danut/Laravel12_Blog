@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
  <div class="card-header">
      <h5 class="card-title mb-0">{{ $title }}</h5>
  </div>
  @include('admin.template.parts.messages')
  <form action="{{ route('admin.update-user-profile') }}" method="POST" enctype="multipart/form-data" class="col-lg-3 mx-auto">
    @csrf
    @method('put')
    <div class="mb-3">
      <label for="inputName" class="form-label">Nume complet</label>
      <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" id="inputName" aria-describedby="nameHelp">
      @error('name')
          <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputEmail" class="form-label">Adresă de email</label>
      <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" id="inputEmail" aria-describedby="emailHelp">
      @error('email')
          <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputAddress" class="form-label">Adresă</label>
      <input type="text" name="address" value="{{ $user->address }}" class="form-control @error('address') is-invalid @enderror" id="inputAddress" aria-describedby="addressHelp">
      @error('address')
          <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputPhone" class="form-label">Număr de telefon</label>
      <input type="text" name="phone" value="{{ $user->phone }}" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" aria-describedby="phoneHelp">
      @error('phone')
          <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputPhoto" class="form-label">Fotografie</label>
      <div class="mb-3 text-center" id="image-preview">
        @if ($user->photo == 'defaultUserPhoto.png')
            <img src="/admin-assets/images/users/defaultUserPhoto.png" class="img-thumbnail" alt="Fotografie utilizator"> 
        @else
            <img src="/storage/admin/images/users/{{ $user->photo }}" class="img-thumbnail" alt="Fotografie utilizator"> 
        @endif
      </div>
      <input type="file" name="photo" accept="images/*" id="inputPhoto" class="form-control @error('photo') is-invalid @enderror" aria-describedby="photoHelp">
      @error('photo')
          <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Actualizare profil utilizator</button>
  </form>
  <br>
  @if (Session::has('passwordMessage'))
    <div class="col-lg-3 mx-auto">
      <div class="text-success" role="alert">
        {!! Session::get('passwordMessage') !!}
      </div>
    </div>     
  @endif
  <form action="{{ route('admin.update-user-password') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data" id="change-password-form">
    @csrf
    @method('put')
    <div class="mb-3">
      <label for="inputPassword" class="form-label">Parolă actuală</label>
      <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="inputPassword" name="old_password">
      @error('old_password')
          <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputNewPassword" class="form-label">Noua parolă</label>
      <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="inputNewPassword" name="new_password">
      @error('new_password')
      <div id="newPasswordHelp" class="form-text text-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="inputConfirmPassword" class="form-label">Confirmare noua parolă</label>
      <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="inputConfirmPassword" name="new_password_confirmation">
    </div>
    <button type="submit" class="btn btn-primary">Schimbare parolă</button>
  </form>
  <br>
@endsection

@section('custom-js')
  @include('scripts.image-preview-script')
@endsection