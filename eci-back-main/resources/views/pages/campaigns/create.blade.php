@extends('../layout/' . $layout)

@section('subhead')
<title>Crear campañas</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Formulario para la creación de campañas</h2>
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
    <form action="{{ route('campaign.store') }}" method="POST">
      @csrf
      <!-- BEGIN: Input -->
      <div class="intro-y box">
        <div id="input" class="p-5">
          <div class="preview">
            <div>
              <label for="regular-form-1" class="form-label">Título</label>
              <input id="regular-form-1" name="title" type="text" class="form-control" placeholder="Título">
            </div>
            <div>
              <label for="regular-form-1" class="form-label">Descripción</label>
              <input id="regular-form-1" name="description" type="text" class="form-control" placeholder="Descripción">
            </div>
          </div>
          <div class="mt-3">
            <label>Página de la campaña</label>
            <div class="mt-2">
              <select data-placeholder="Seleccione una página para ubicar la campaña" name="page_id" class="tom-select w-full">
                <option disabled selected>Seleccione una página para ubicar la campaña</option>
                @foreach ($pages as $page)
                <option value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="sm:ml-20 sm:pl-5 mt-5">
            <button type="submit" class="btn btn-primary">Crear Campaña</button>
          </div>
        </div>
      </div>
      <!-- END: Input -->
    </form>
  </div>
</div>
@endsection