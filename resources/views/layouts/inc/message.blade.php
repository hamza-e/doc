 @if (Session::has('success'))
  <div class="alert alert-success margin-15" style="color: #fff !important">
    {{ Session::get('success') }}
</div>
@endif
@if (Session::has('error'))
  <div class="alert alert-danger margin-15" style="color: #fff !important">
      {{ Session::get('error') }}
  </div>
@endif

@if(count($errors) > 0)

<div class="alert alert-danger">
      <strong>Erreurs:</strong>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
  </div>

@endif