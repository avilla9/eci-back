@extends('../layout/' . $layout)

@section('subhead')
<title>Crear contenido - Salas</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Gestión de la sección</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button id="save-section" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
      Guardar <i class="w-4 h-4 ml-2" data-feather="database"></i>
    </button>
  </div>
</div>
<div id="form-body" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
  <!-- BEGIN: Post Content -->
  <div class="intro-y col-span-12 lg:col-span-12">
    <table class="table">
      <thead class="table-dark">
        <tr>
          <th class="whitespace-nowrap">Imagen</th>
          <th class="whitespace-nowrap">Título</th>
          <th class="whitespace-nowrap">Sección</th>
          <th class="whitespace-nowrap">Creación</th>
          <th class="whitespace-nowrap">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $article)
        <tr id={{$article->id}}>
          <td><img src="{{$article->img}}" class="w-40"></td>
          <td>{{$article->title}}</td>
          <td>{{$article->description}}</td>
          <td>{{$article->created_at}}</td>
          <td><button article_id="{{$article->id}}" class="delete flex items-center text-danger">
              <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
            </button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="form-inline mt-3 mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Sección</label>
      <select name="section" data-placeholder="Seleccione una sección" class="form-control tom-select w-full mb-2">
        @foreach ($sections as $section)
        <option value="{{$section->id}}">{{$section->title}}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3 overflow-y-auto h-120">
      @if (count($files))
      <div class="text-center font-bold mb-3">Seleccionar imagen</div>
      <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6">
        @foreach ($files as $file)
        <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
          <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
            <div class="absolute left-0 top-0 mt-3 ml-3">
              <input id="image" class="form-check-input" type="radio" name="image" value="{{$file['id']}}">
            </div>

            <div class="w-3/5 file__icon file__icon--image mx-auto">
              <div class="file__icon--image__preview image-fit">
                <img alt="Imagen" src="{{ asset('file/' . strtolower($file['media_name'])) }} " data-action="zoom">
              </div>
            </div>

            <a href="" class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
            <div class="text-slate-500 text-xs text-center mt-0.5">{{ number_format(
              (float)(intval($file['media_size']) / (1024 * 1024)), 2, '.', ''
              ) }} Mb</div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <label class="form-label">Cargue imágenes y vuelva a intentar</label>
      @endif
    </div>

  </div>
  <!-- END: Post Content -->
</div>
@endsection

@section('script')
<script src="{{ asset('dist/js/articles/room.js') }}"></script>
@endsection