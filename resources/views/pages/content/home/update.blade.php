@extends('../layout/' . $layout)

@section('subhead')
<title>Actualizar contenido - Home</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Crear contenido para Home</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button id="update-home" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
      Actualizar <i class="w-4 h-4 ml-2" data-feather="database"></i>
    </button>
  </div>
</div>
<div id="form-body" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
  <!-- BEGIN: Post Content -->
  <div class="intro-y col-span-12 lg:col-span-9">
    <div class="form-inline mt-3 mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Sección</label>
      <select name="section" data-placeholder="Seleccione una sección" class="form-control tom-select w-full mb-2" id="section">
        {{-- <option selected="{{ $article->section_id }}">{{ $article->section_title }}</option> --}}
        @foreach ($sections as $section)
        <option value="{{$section->id}}" {{ $article->section_id == $section->id ? 'selected' : '' }}>{{$section->title}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Título</label>
      <input name="title" id="horizontal-form-2" type="text" class="form-control" placeholder="Título del post" value="{{ $article->title }}">
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Descripción corta</label>
      <input name="short_description" id="horizontal-form-2" type="text" class="form-control" placeholder="Descripción corta" value="{{ $article->short_description }}">
    </div>
    <div class="form-inline mb-2">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Tipo de contenido</label>
      <div class="flex flex-col sm:flex-row content-center">
        <div class="form-check mr-2">
          <input id="radio-switch-4" class="form-check-input" type="radio" name="post_type" value="post" {{ $article->post_type == 'post' ? 'checked' : '' }}>
          <label class="form-check-label" for="radio-switch-4">Post</label>
        </div>
        <div class="form-check mr-2 mt-2 sm:mt-0">
          <input id="radio-switch-5" class="form-check-input" type="radio" name="post_type" value="external" {{ $article->post_type == 'external' ? 'checked' : ' ' }}>
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
    @if ($article->post_type == "post")
    <div class="form-inline mb-2 external hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link externo</label>
      <input name="external_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link externo">
    </div>
    <div class="form-inline mb-2 custom_post">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">CTA</label>
      <input name="button_name" id="horizontal-form-2" type="text" class="form-control" placeholder="CTA (opcional)" value="{{ $article->button_name }}">
    </div>
    <div class="form-inline mb-2 custom_post">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link CTA</label>
      <input name="button_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link CTA (opcional)" value="{{ $article->button_link }}">
      <button id="getFile" class="btn btn-primary shadow-md flex items-center ml-3" aria-expanded="false" onclick="openFilesPath()">
        Adjuntar archivo <i class="w-4 h-4 ml-2" data-feather="plus-square"></i>
      </button>
    </div>
    @else
    <div class="form-inline mb-2 external">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link externo</label>
      <input name="external_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link externo" value="{{ $article->external_link }}">
    </div>
    <div class="form-inline mb-2 custom_post hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">CTA</label>
      <input name="button_name" id="horizontal-form-2" type="text" class="form-control" placeholder="CTA (opcional)">
    </div>
    <div class="form-inline mb-2 custom_post hidden">
      <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link CTA</label>
      <input name="button_link" id="horizontal-form-2" type="text" class="form-control" placeholder="Link CTA (opcional)">
      <button id="getFile" class="btn btn-primary shadow-md flex items-center ml-3" aria-expanded="false" onclick="openFilesPath()">
        Adjuntar archivo <i class="w-4 h-4 ml-2" data-feather="plus-square"></i>
      </button>
    </div>
    @endif

    <div class="mb-3 overflow-y-auto" style="max-height: calc(100vh - 300px); overflow-y: auto; overflow-x: hidden;">
      @if (count($files))
      <div class="text-center font-bold mb-3">Seleccionar imagen</div>
      <div class="intro-y grid gap-6 grid-cols-6 sm:gap-4">
        @foreach ($files as $file)
        <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
          <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
            <div class="absolute left-0 top-0 mt-3 ml-3">
              <input id="image" class="form-check-input" type="radio" name="image" value="{{$file['id']}}" {{ $article->file_id == $file['id'] ? 'checked' : '' }}>
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

    <div class="mb-2 custom_post {{ $article->post_type == 'post' ? '' : 'hidden' }}">
      <div class="editor document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
          <div id="custom_content" class="document-editor__editable">
            {!! $article->description !!}
          </div>
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
            class="show-code form-check-input mr-0 ml-3" type="checkbox" {{ $article->unrestricted == 0 ? 'checked' : '' }}>
        </div>

        <div id="filters" class="mt-2 {{ $article->unrestricted == 1 ? 'hidden' : '' }}">
          @foreach ($filters as $key => $filter)
          <label class="form-label">{{$filter['name']}}</label>
          <select name="{{$key}}" data-placeholder="Añadir a la visibilidad" class="select-{{$key}} tom-select w-full mb-2" multiple>
            @foreach ($filter['data'] as $item)
            <option value="{{$item['id']}}" >{{$item['name']}}</option>
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
<script src="{{ asset('dist/js/ckeditor-document.js') }}"></script>
<script src="{{ asset('dist/js/articles/home.js') }}"></script>
<script>
  $(document).ready(function () {
    var settings = {};
    $('.datepicker').val("{{date('Y-m-d', strtotime($article->created_at))}}");
    
    // $('.select-groups').removeAttr('selected').prop('selected', false);
    // $('.select-delegations').removeAttr('selected').prop('selected', false);
    // $('.select-roles').removeAttr('selected').prop('selected', false);
    // $('.select-users').removeAttr('selected').prop('selected', false);
    // $('.select-quartiles').removeAttr('selected').prop('selected', false);
    
    // $('#section').val('{{ $article->section_id }}').change();

    // AQUI TIENES PARA RELLENAR LOS CAMPOS QUE SEAN SELECTED
   function haveFilters(unrestricted) {
    // ALMACENAS EL ID DEL ARTICULO O LA SECCION PARA FILTRAR SU DATA EN ARTICLEFILTERS
    let id = "{{ $article->id }}";
    // SI ES UNRESTRICTED NO TIENES QUE HACER NADA PORQUE ES VISIBLE PARA TODOS
      if(unrestricted == 1) {
        return 0;
      } else {
        // CASO CONTRARIO LLAMAS A UNA FUNCION DEL CONTROLADOR QUE TE RETORNE LOS FILTROS DE ESE ARTICULO O SECCIÓN
        $.ajax({
          type: "GET",
          // PARA ESTE CASO MANDE EL ID EN LA RUTA
          url: "/api/posts/home/article-filters/" + id,
          success: function (response) {
            console.log("🚀 ~ file: update.blade.php:222 ~ haveFilters ~ response:", response)
            // A CADA SELECT LE PONES UNA CLASE PARA IDENTIFICAR SUS OPCIONES Y APLICAS UN FOREACH POR CADA SELECT QUE TENGAS
            if(response.articleFilters[0].groups) {
              $.each(response.articleFilters[0].groups, function (index, value) { 
                document.querySelector('.select-groups').tomselect.addItem(value);
                // $("select-groups").multiselect();
              });
            }
            if(response.articleFilters[0].delegations) {
              $.each(response.articleFilters[0].delegations, function (index, value) {
                document.querySelector('.select-delegations').tomselect.addItem(value);
              });
            }
            if(response.articleFilters[0].roles) {
              $.each(response.articleFilters[0].roles, function (index, value) {
                document.querySelector('.select-roles').tomselect.addItem(value);
              });
            }
            if(response.articleFilters[0].users) {
              $.each(response.articleFilters[0].users, function (index, value) { 
                document.querySelector('.select-users').tomselect.addItem(value);
              });
            }
            if(response.articleFilters[0].quartiles) {
              $.each(response.articleFilters[0].quartiles, function (index, value) { 
                document.querySelector('.select-quartiles').tomselect.addItem(value);
              });
            }
          }
        });
      }
   }

   haveFilters("{{ $article->unrestricted }}");

   $('#update-home').on('click', function (e) {
    let id = '{{ $article->id }}';

    var d = new Date($('#form-body input[name=upload-date]').val())
    var year = d.getFullYear();
    var month = ("0" + (d.getMonth() + 1)).slice(-2);
    var day = ("0" + d.getDate()).slice(-2);
    var hour = ("0" + d.getHours()).slice(-2);
    var minutes = ("0" + d.getMinutes()).slice(-2);
    var seconds = ("0" + d.getSeconds()).slice(-2);
    let timestamp = year + "-" + month + "-" + day + " " + hour + ":" + minutes + ":" + seconds;

    e.preventDefault();
    let data = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      id: id,
      section: $('select[name=section]').val(),
      title: $('input[name=title]').val(),
      short_description: $('input[name=short_description]').val(),
      post_type: $('input[name=post_type]:checked').val(),
      internal_link: $('input[name=internal_link]').val(),
      external_link: $('input[name=external_link]').val(),
      button_name: $('input[name=button_name]').val(),
      button_link: $('input[name=button_link]').val(),
      image: $('input[name=image]:checked').val(),
      description: $('#custom_content').html(),
      date: timestamp,
      groups: $('#form-body select[name=groups]').val(),
      quartiles: $('#form-body select[name=quartiles]').val(),
      delegations: $('#form-body select[name=delegations]').val(),
      roles: $('#form-body select[name=roles]').val(),
      users: $('#form-body select[name=users]').val(),
      grant_all: $('input[name=select-all]:checked').is(':checked') ? 1 : 0,
    };
    $('#alert').html();
    $('#alert').removeClass();
    let error = false;
    let message = [];

  if (data.button_link.length) {
    if (!data.button_name.length) {
      error = true;
      message.push('Debe añadir un nombre para el botón del link');
    }
  }

  if (!$('input[name=select-all]').is(":checked")) {
    if (
      !$('#form-body select[name=groups]').val().length
      && !$('#form-body select[name=delegations]').val().length
      && !$('#form-body select[name=quartiles]').val().length
      && !$('#form-body select[name=roles]').val().length
      && !$('#form-body select[name=users]').val().length
    ) {
      error = true;
      message.push('Debe seleccionar al menos un grupo objetivo');
    }
  } else {
    data.grant_all = 1
  }

  if (!data.image?.length) {
    error = true;
    message.push('Debe seleccionar una imagen');
  }

  if (!data.post_type) {
    error = true;
    message.push('Debe seleccionar un tipo de contenido');
  } else if (data.post_type == 'post') {
    if (data.description == '<p><br data-cke-filler="true"></p>') {
      error = true;
      message.push('Debe redactar contenido para mostrar en el post');
    }
  } else if (data.post_type == 'external') {
    if (!data.external_link?.length) {
      error = true;
      message.push('Debe añadir un enlace');
    }
  } else if (data.post_type == 'internal') {
    if (!data.internal_link?.length) {
      error = true;
      message.push('Debe añadir un enlace');
    }
  }

  if (!data.title?.length) {
    error = true;
    message.push('Debe añadir un título');
  }

  if (!data.short_description?.length) {
    error = true;
    message.push('Debe añadir una descripción corta');
  }

  if (error) {
    $('#alert').html();
    $('#alert').removeClass();
    $('#alert').addClass('alert alert-danger show mb-2');
    let value = '';
    for (var i = 0; i < message.length; i++) {
      value += message[i];
      if (i + 1 != message.length) {
        value += '<br>';
      }
    }
    $('#alert').html(value);
  } else {
    $.ajax({
      type: "PUT",
      url: "{{ route('home.update.article') }}",
      data: data,
      dataType: "JSON",
      success: function (response) {
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-success show mb-2');
        $('#alert').html('Post actualizado con éxito');
      },
      error: function (error) {
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error al actualizar el Post');
      }
    });
  }
   });
  });
</script>
@endsection