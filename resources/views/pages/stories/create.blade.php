@extends('../layout/' . $layout)

@section('subhead')
<title>Crear Story</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Añadir una nueva Story</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button id="save" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
      Guardar <i class="w-4 h-4 ml-2" data-feather="database"></i>
    </button>
  </div>
</div>
<div id="form-body" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
  <!-- BEGIN: Post Content -->
  <div class="intro-y col-span-12 lg:col-span-8">
    <input name="link" type="text" class="intro-y form-control py-3 px-4 box pr-10" placeholder="Enlace (Opcional)">
    <input name="button-name" type="text" class="intro-y form-control py-3 px-4 box pr-10 mt-3"
      placeholder="Nombre del botón (En caso de añadir enlace)">

    <div class="mt-3">
      @if (count($files))
      <label class="form-label">Seleccionar imagen</label>
      <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
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
  <!-- BEGIN: Post Info -->
  <div class="col-span-12 lg:col-span-4">
    <div class="intro-y box p-5">
      <div>
        <label for="post-form-2" class="form-label">Fecha de carga</label>
        <input name="upload-date" type="text" class="datepicker form-control" id="post-form-2" data-single-mode="true">
      </div>
      <div class="mt-3">
        <label for="post-form-3" class="form-label">Visibilidad</label>

        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
          <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
            <label class="form-check-label ml-0" for="show-example-2">Visible para todos</label>
            <input name="select-all" id="show-example-2" data-target="#boxed-accordion"
              class="show-code form-check-input mr-0 ml-3" type="checkbox">
          </div>
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
<script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
<script>
  $('input[name=select-all]').change(function () {
    if ($('input[name=select-all]').is(":checked")) {
      $('#filters').addClass('hidden');
    } else {
      $('#filters').removeClass('hidden');
    }
  });

  $('#save').click(function (e) {
    e.preventDefault();
    let data = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      link: $('#form-body input[name=link]').val(),
      button_name: $('#form-body input[name=button-name]').val(),
      image: $('#form-body input[name=image]:checked').val(),
      date: $('#form-body input[name=upload-date]').val(),
      groups: $('#form-body select[name=groups]').val(),
      delegations: $('#form-body select[name=delegations]').val(),
      roles: $('#form-body select[name=roles]').val(),
      users: $('#form-body select[name=users]').val(),
      grant_all: false,
    };

    $('#alert').html();
    $('#alert').removeClass();
    let error = false;
    let message = [];

    if (data.link.length) {
      if (!data.button_name.length) {
        error = true;
        message.push('Debe añadir un nombre para el botón del link');
      } else {
        data.button_name = $('#form-body input[name=button-name]').val();
      }
    }

    if (!$('input[name=select-all]').is(":checked")) {
      if (
        !($('#form-body select[name=groups]').val().length
          && $('#form-body select[name=delegations]').val().length
          && $('#form-body select[name=roles]').val().length
          && $('#form-body select[name=users]').val().length)
      ) {
        error = true;
        message.push('Debe seleccionar al menos un grupo objetivo');
      }
    } else {
      data.grant_all = true
    }

    if (!data.image?.length) {
      error = true;
      message.push('Debe seleccionar una imagen');
    }

    if (error) {
      $('#alert').html();
      $('#alert').removeClass();
      $('#alert').addClass('alert alert-danger show mb-2');
      let value = '';
      for (var i = 0; i < message.length; i++) {
        console.log(message[i]);
        value += '<br>' + message[i];
      }
      $('#alert').html(value);
    } else {
      console.log(data);

      $.ajax({
        type: "POST",
        url: "{{route('story.store')}}",
        data: data,
        success: function success(data) {
          console.log('success', data);

          $('#alert').html();
          $('#alert').removeClass();
          $('#alert').addClass('alert alert-success show mb-2');
          $('#alert').html('Story creada con éxito');
        },
        error: function error(_error) {
          console.log('error', _error);

          $('#alert').html();
          $('#alert').removeClass();
          $('#alert').addClass('alert alert-danger show mb-2');
          $('#alert').html('Ha ocurrido un error al crear la Story');
        }
      });
    }
  });
</script>
@endsection