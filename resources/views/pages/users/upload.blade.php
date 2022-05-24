@extends('../layout/' . $layout)

@section('subhead')
<title>Subir usuarios</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Subir usuarios a partir de archivos</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 lg:col-span-12">
    <!-- BEGIN: Single File Upload -->
    <div class="intro-y box">
      <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">Single File Upload</h2>
      </div>
      <div id="single-file-upload" class="p-5">
        <div class="preview">
          <form data-single="true" action="/file-upload" class="dropzone">
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
        <div class="sm:ml-6 sm:pl-5 mt-5">
          <button class="btn btn-primary">Subir Usuarios</button>
        </div>
      </div>
    </div>
    <!-- END: Single File Upload -->
  </div>
</div>
@endsection