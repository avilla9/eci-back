@extends('../layout/' . $layout)

@section('subhead')
<title>Crear usuarios</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Formulario para la creación de usuarios</h2>
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
    <form action="{{ route('user.store') }}" method="POST">
      @csrf
      <!-- BEGIN: Input -->
      <div class="intro-y box">
        <div id="input" class="p-5">
          <div class="preview">
            <div>
              <label for="regular-form-1" class="form-label">DNI</label>
              <input id="regular-form-1" name="dni" type="number" class="form-control" placeholder="DNI">
            </div>
            <div>
              <label for="regular-form-1" class="form-label">Nombre completo</label>
              <input id="regular-form-1" name="name" type="text" class="form-control" placeholder="Nombres">
            </div>
            <div class="mt-3">
              <label>Género</label>
              <div class="flex flex-col sm:flex-row mt-2">
                <div class="form-check mr-2">
                  <input id="radio-switch-4" class="form-check-input" type="radio" name="gender" value="m">
                  <label class="form-check-label" for="radio-switch-4">Masculino</label>
                </div>
                <div class="form-check mr-2 mt-2 sm:mt-0">
                  <input id="radio-switch-5" class="form-check-input" type="radio" name="gender" value="f">
                  <label class="form-check-label" for="radio-switch-5">Femenino</label>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <label for="regular-form-1" class="form-label">Correo</label>
              <input id="regular-form-1" type="email" class="form-control" name="email" placeholder="Correo">
            </div>
            <div class="mt-3">
              <label for="regular-form-4" class="form-label">Password</label>
              <input id="regular-form-4" name="password" type="password" class="form-control" placeholder="Password">
            </div>
          </div>
          <div class="mt-3">
            <label>Rol del usuario</label>
            <div class="mt-2">
              <select data-placeholder="Seleccione un rol para el usuario" name="role_id" class="tom-select w-full">
                <option disabled selected>Seleccione un rol para el usuario</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mt-3">
            <label>Grupo del usuario</label>
            <div class="mt-2">
              <select data-placeholder="Seleccione un rol para el usuario" name="group_id" class="tom-select w-full">
                <option disabled selected>Seleccione un grupo para el usuario</option>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mt-3">
            <label>Cuartil del usuario</label>
            <div class="mt-2">
              <select data-placeholder="Seleccione un rol para el usuario" name="quartile_id" class="tom-select w-full">
                <option disabled selected>Seleccione un cuartil para el usuario</option>
                @foreach ($quartiles as $quartile)
                <option value="{{ $quartile->id }}">{{ $quartile->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="sm:ml-20 sm:pl-5 mt-5">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
          </div>
        </div>
      </div>
      <!-- END: Input -->
    </form>
  </div>
</div>
@endsection