@extends('../layout/' . $layout)

@section('subhead')
<title>Crear contenido - Adopción</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Crear contenido para Adopción</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button id="save" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
      Guardar <i class="w-4 h-4 ml-2" data-feather="database"></i>
    </button>
  </div>
</div>
<div id="form-body" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
  <!-- BEGIN: Post Content -->
  <div class="intro-y col-span-12 lg:col-span-9">
    <div class="form-inline mt-3 mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Adopción</label>
      <select name="campaign" data-placeholder="Seleccione una Adopción" class="form-control tom-select w-full mb-2">
        @foreach ($campaigns as $campaign)
        <option value="{{$campaign->id}}">{{$campaign->title}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Sección</label>
      <select name="section" data-placeholder="Seleccione una sección" class="form-control tom-select w-full mb-2">
        @foreach ($sections as $section)
        <option value="{{$section->id}}">{{$section->title}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Título</label>
      <input name="title" id="horizontal-form-2" type="text" class="form-control" placeholder="Título del post">
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Descripción corta</label>
      <input name="short_description" id="horizontal-form-2" type="text" class="form-control" placeholder="Descripción corta">
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Tipo de contenido</label>
      <div class="flex flex-col sm:flex-row content-center">
        <div class="form-check mr-2">
          <input id="radio-switch-4" class="form-check-input" type="radio" name="post_type" value="post">
          <label class="form-check-label" for="radio-switch-4">Post</label>
        </div>
        <div class="form-check mr-2 mt-2 sm:mt-0">
          <input id="radio-switch-5" class="form-check-input" type="radio" name="post_type" value="external">
          <label class="form-check-label" for="radio-switch-5">Enlace externo</label>
        </div>
        <!-- <div class="form-check mr-2 mt-2 sm:mt-0">
          <input id="radio-switch-6" class="form-check-input" type="radio" name="post_type"
            value="internal">
          <label class="form-check-label" for="radio-switch-6">Enlace interno</label>
        </div> -->
      </div>
    </div>

    <div class="form-inline mb-2 internal hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link interno</label>
      <input name="internal_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link interno">
    </div>
    <div class="form-inline mb-2 external hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link externo</label>
      <input name="external_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link externo">
    </div>
    <div class="form-inline mb-2 custom_post hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">CTA</label>
      <input name="button_name" id="horizontal-form-2" type="text" class="form-control" placeholder="CTA (opcional)">
    </div>
    <div class="form-inline mb-2 custom_post hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link CTA</label>
      <input name="button_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link CTA (opcional)">
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

    <div class="mb-2 custom_post hidden">
      <div class="editor document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
          <div id="custom_content" class="document-editor__editable"></div>
        </div>
      </div>
    </div>

  </div>
  <!-- END: Post Content -->
  <!-- BEGIN: Post Info -->
  <div class="col-span-12 lg:col-span-3">
    <div class="intro-y box p-5">
      <div>
        <label for="post-form-2" class="form-label">Fecha de carga</label>
        <input name="upload-date" type="text" class="datepicker form-control" id="post-form-2" data-single-mode="true">
      </div>
      <div class="mt-3">
        <div class="flex flex-col sm:flex-row items-center pb-4 border-b border-slate-200/60 dark:border-darkmode-400">
          <label class="form-check-label" for="show-example-2">Visible para todos</label>
          <input name="select-all" id="show-example-2" data-target="#boxed-accordion"
            class="show-code form-check-input mr-0 ml-3" type="checkbox">
        </div>

        <div id="filters" class="mt-2">
          @foreach ($filters as $key => $filter)
          <label class="form-label">{{$filter['name']}}</label>
          <select name="{{$key}}" data-placeholder="Añadir a la visibilidad" class="tom-select w-full mb-2" multiple>
            @foreach ($filter['data'] as $item)
            <option value="{{$item['id']}}">{{$item['name']}}</option>
            @endforeach
          </select>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- END: Post Info -->
</div>
@endsection

@section('script')
<script src="{{ mix('dist/js/ckeditor-document.js') }}"></script>
<script src="{{ asset('dist/js/articles/campaign.js') }}"></script>
@endsection