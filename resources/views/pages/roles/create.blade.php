@extends('../layout/' . $layout)

@section('subhead')
<title>Crear Roles</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Formulario para la creación de roles</h2>
</div>
@if ($errors->any())
<div class="alert alert-danger">
  <strong>Whoops!</strong> There were some problems with your input.<br><br>
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 lg:col-span-12">
    <form action="{{ route('role.store') }}" method="POST">
      @csrf
      <!-- BEGIN: Input -->
      <div class="intro-y box">
        <div id="input" class="p-5">
          <div class="preview">
            <div>
              <label for="regular-form-1" class="form-label">Codigo de Rol</label>
              <input id="regular-form-1" name="name" type="text" class="form-control" placeholder="Codigo de Rol" required>
            </div>
            <div class="mt-3">
              <label for="regular-form-6" class="form-label">Descripción del rol</label>
              <textarea id="regular-form-6" name="description" class="form-control" placeholder="Descripción" minlength="10" required></textarea>
            </div>
<<<<<<< HEAD

            <!-- Nivel de rol dentro de panel de creación-->

            <!--<div class="mt-3">
              <label for="regular-form-4" class="form-label">Nivel del rol</label>
              <input id="regular-form-4" name="level" type="number" class="form-control" placeholder="Nivel del rol" required>
            </div>-->

=======
>>>>>>> 0bfa14b216e4f5456d687549561c78665b29e6ef
          </div>
          <div class="sm:ml-20 sm:pl-5 mt-5">
            <button type="submit" class="btn btn-primary">Crear Rol</button>
          </div>
        </div>
      </div>
      <!-- END: Input -->
    </form>
  </div>
</div>
@endsection
