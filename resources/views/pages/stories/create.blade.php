@extends('../layout/' . $layout)

@section('subhead')
<title>Crear Story</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Añadir una nueva Story</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button type="button" class="btn box mr-2 flex items-center ml-auto sm:ml-0">
      <i class="w-4 h-4 mr-2" data-feather="eye"></i> Preview
    </button>
    <div class="dropdown">
      <button class="dropdown-toggle btn btn-primary shadow-md flex items-center" aria-expanded="false"
        data-tw-toggle="dropdown">
        Save <i class="w-4 h-4 ml-2" data-feather="chevron-down"></i>
      </button>
      <div class="dropdown-menu w-40">
        <ul class="dropdown-content">
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="file-text" class="w-4 h-4 mr-2"></i> As New Post
            </a>
            </a>
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="file-text" class="w-4 h-4 mr-2"></i> As Draft
            </a>
            </a>
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF
            </a>
            </a>
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Word
            </a>
            </a>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
  <!-- BEGIN: Post Content -->
  <div class="intro-y col-span-12 lg:col-span-8">
    <input type="text" class="intro-y form-control py-3 px-4 box pr-10" placeholder="Enlace (Opcional)">
    <input type="text" class="intro-y form-control py-3 px-4 box pr-10 mt-3"
      placeholder="Nombre del botón (En caso de añadir enlace)">

    <div class="mt-3">
      <label class="form-label">Cargar imagen</label>
      <div class="border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
        <div class="flex flex-wrap px-4">
          {{-- @foreach (array_slice($fakers, 0, 4) as $faker)
          <div class="w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in">
            <img class="rounded-md" alt="Icewall Tailwind HTML Admin Template"
              src="{{ asset('dist/images/' . $faker['images'][0]) }}">
            <div title="Remove this image?"
              class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
              <i data-feather="x" class="w-4 h-4"></i>
            </div>
          </div>
          @endforeach --}}
        </div>
        <div class="px-4 pb-4 flex items-center cursor-pointer relative">
          <i data-feather="image" class="w-4 h-4 mr-2"></i> <span class="text-primary mr-1">Upload a file</span> or drag
          and drop
          <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
        </div>
      </div>
    </div>

  </div>
  <!-- END: Post Content -->
  <!-- BEGIN: Post Info -->
  <div class="col-span-12 lg:col-span-4">
    <div class="intro-y box p-5">
      <div>
        <label for="post-form-2" class="form-label">Fecha de carga</label>
        <input type="text" class="datepicker form-control" id="post-form-2" data-single-mode="true">
      </div>
      <div class="mt-3">
        <label for="post-form-3" class="form-label">Visibilidad</label>
        <select data-placeholder="Visibilidad de la Storie" class="tom-select w-full" id="post-form-3" multiple>
          <option value="1" selected>Horror</option>
          <option value="2">Sci-fi</option>
          <option value="3" selected>Action</option>
          <option value="4">Drama</option>
          <option value="5">Comedy</option>
        </select>
      </div>
    </div>
  </div>
  <!-- END: Post Info -->
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection