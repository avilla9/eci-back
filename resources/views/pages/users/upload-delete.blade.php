@extends('../layout/' . $layout)

@section('subhead')
<title>Eliminar usuarios</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Eliminar usuarios a partir de archivos</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 lg:col-span-12">
    <!-- BEGIN: Single File Upload -->
    <div class="intro-y box">
      <div id="single-file-upload" class="p-5">
        <div class="preview">
          <form data-single="true" action="{{route('file-delete')}}" method="POST" enctype="multipart/form-data" class="dropzone">
            @csrf
            <div class="fallback">
              <input name="file" type="file" />
            </div>
            <div class="dz-message" data-dz-message>
              <div class="text-lg font-medium">Arrastra el archivo hasta acá o haz click para subir uno.</div>
              <div class="text-slate-500">
                Seleccione archivos de hoja de cálculo en formato xls
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END: Single File Upload -->
  </div>
</div>
@endsection