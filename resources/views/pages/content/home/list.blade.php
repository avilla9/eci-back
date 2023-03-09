@extends('../layout/' . $layout)

@section('subhead')
    <title>Lista de posts de Home</title>
@endsection

@section('subcontent')
    <div id="alert" class="hidden"></div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8" id="users-list">
        <h2 class="text-lg font-medium mr-auto">Lista de posts de Home</h2>
    </div>
    <!-- BEGIN: Table Head Options -->
    <div class="intro-y box">
        <div class="p-5" id="head-options-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th class="whitespace-nowrap">Archivo</th>
                                <th class="whitespace-nowrap">Título</th>
                                <th class="whitespace-nowrap">Sección</th>
                                <th class="whitespace-nowrap">Creación</th>
                                <th class="whitespace-nowrap">Usuarios</th>
                                <th class="whitespace-nowrap">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr id={{ $article->id }}>
                                    <td>
                                        <div class="w-3/5 file__icon file__icon--image mx-auto">
                                          <div class="file__icon--image__preview image-fit h-12">
                                            <img alt="Imagen" src="{{$article->media_path}}" data-action="zoom">
                                          </div>
                                        </div>
                                      </td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->section_title }}</td>
                                    <td>{{ $article->created_at }}</td>
                                    <td>
                                        @if ($article->unrestricted)
                                        Todos
                                        @else
                                        <a href="javascript:;" data-tw-toggle="modal" article_id="{{$article->id}}" data-tw-target="#user-list"
                                          class="view flex items-center text-primary"><i data-feather="eye" class="w-4 h-4 mr-1"></i> Ver</a>
                                        @endif
                                      </td>
                                    <td>
                                        <a class="edit flex items-center mr-3" href="{{ route('home.get.post', $article->id) }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1 my-4"></i> Editar
                                        </a>
                                        <button article_id="{{ $article->id }}"
                                            class="delete flex items-center text-danger">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                        </button>
                                        <button article_id="{{ $article->id }}"
                                            class="copy flex items-center text-dark" style="width: 100px">
                                            <i data-feather="paperclip" class="w-4 h-4 mr-1 my-4"></i> Copiar Link
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Table Head Options -->

    <!-- END: HTML Table Data -->

    {{-- <div id="edit-home" class="modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static">
        <div class="modal-dialog modal-xl" style="overflow-y: initial !important;">
            <div class="modal-content">
                <div class="modal-body" style="max-height: calc(100vh - 130px); overflow-y: auto;">
                    <h2 class="p-5 font-medium text-base mr-auto">Editar información del usuario</h2>
                    <div id="editable">
                        <form id="SubmitForm">
                            @csrf
                            <!-- BEGIN: Input -->
                            <!-- BEGIN: Post Content -->
                            <div class="intro-y col-span-12 lg:col-span-9">
                                <input type="hidden" id="id">
                                <div class="form-inline mt-3 mb-2">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Sección</label>
                                    <select name="section" data-placeholder="Seleccione una sección"
                                        class="form-control tom-select w-full mb-2" id="section">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" id="option">{{ $section->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-inline mb-2">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Título</label>
                                    <input name="title" id="horizontal-form-2" type="text" class="title form-control"
                                        placeholder="Título del post">
                                </div>
                                <div class="form-inline mb-2">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Descripción
                                        corta</label>
                                    <input name="short_description" id="horizontal-form-2" type="text"
                                        class="short_description form-control" placeholder="Descripción corta">
                                </div>
                                <div class="form-inline mb-2">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Tipo de
                                        contenido</label>
                                    <div class="flex flex-col sm:flex-row content-center">
                                        <div class="form-check mr-2">
                                            <input id="radio-switch-4" class="form-check-input post" type="radio"
                                                name="post_type" value="post">
                                            <label class="form-check-label" for="radio-switch-4">Post</label>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="radio-switch-5" class="form-check-input external" type="radio"
                                                name="post_type" value="external">
                                            <label class="form-check-label" for="radio-switch-5">Enlace externo</label>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="radio-switch-6" class="form-check-input internal" type="radio"
                                                name="post_type" value="internal">
                                            <label class="form-check-label" for="radio-switch-6">Enlace interno</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-inline mb-2 internal hidden">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link interno</label>
                                    <input name="internal_link" id="horizontal-form-2" type="text"
                                        class="external_link form-control" placeholder="Link interno">
                                </div>
                                <div class="form-inline mb-2 external hidden">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link externo</label>
                                    <input name="external_link" id="horizontal-form-2" type="text" class="form-control"
                                        placeholder="Link externo">
                                </div>
                                <div class="form-inline mb-2 custom_post hidden">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">CTA</label>
                                    <input name="button_name" id="horizontal-form-2" type="text" class="form-control"
                                        placeholder="CTA (opcional)">
                                </div>
                                <div class="form-inline mb-2 custom_post hidden">
                                    <label for="horizontal-form-2" class="form-label font-bold sm:w-20">Link CTA</label>
                                    <input name="button_link" id="horizontal-form-2" type="text" class="form-control"
                                        placeholder="Link CTA (opcional)">
                                </div>

                                <div class="mb-3 overflow-y-auto"
                                    style="max-height: calc(100vh - 300px); overflow-y: auto; overflow-x: hidden;">
                                    @if (count($files))
                                        <div class="text-center font-bold mb-3">Seleccionar imagen</div>
                                        <div class="intro-y grid gap-6 grid-cols-6 sm:gap-4">
                                            @foreach ($files as $file)
                                                <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                                                    <div
                                                        class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                                        <div class="absolute left-0 top-0 mt-3 ml-3">
                                                            <input id="image" class="form-check-input" type="radio"
                                                                name="image" value="{{ $file['id'] }}">
                                                        </div>

                                                        <div class="w-3/5 file__icon file__icon--image mx-auto">
                                                            <div class="file__icon--image__preview image-fit">
                                                                <img alt="Imagen"
                                                                    src="{{ asset('file/' . strtolower($file['media_name'])) }} "
                                                                    data-action="zoom">
                                                            </div>
                                                        </div>

                                                        <a href=""
                                                            class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                                        <div class="text-slate-500 text-xs text-center mt-0.5">
                                                            {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                                            Mb</div>
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
                                        <input name="upload-date" type="text" class="datepicker form-control"
                                            id="post-form-2" data-single-mode="true">
                                    </div>
                                    <div class="mt-3">
                                        <div
                                            class="flex flex-col sm:flex-row items-center pb-4 border-b border-slate-200/60 dark:border-darkmode-400">
                                            <label class="form-check-label" for="show-example-2">Visible para
                                                todos</label>
                                            <input name="select-all" id="show-example-2" data-target="#boxed-accordion"
                                                class="show-code form-check-input mr-0 ml-3" type="checkbox">
                                        </div>

                                        <div id="filters" class="mt-2">
                                            @foreach ($filters as $key => $filter)
                                                <label class="form-label">{{ $filter['name'] }}</label>
                                                <select name="{{ $key }}"
                                                    data-placeholder="Añadir a la visibilidad"
                                                    class="tom-select w-full mb-2" multiple>
                                                    @foreach ($filter['data'] as $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Post Info -->
                            <!-- END: Input -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <a data-tw-target="#edit-user" data-tw-toggle="modal" data-backdrop="static" data-keyboard="false" class="edit flex items-center mr-3" href="javascript:;">
        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Editar
    </a> --}}
    <div id="user-list" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="font-medium text-base mr-auto">Lista de usuarios con acceso a los posts de Home</h2>
              <button type="button" class="btn btn-outline-secondary mr-1 mb-2" data-tw-dismiss="modal">X</button>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
              <div class="intro-y col-span-12 lg:col-span-12">
                <table class="table">
                  <thead class="table-dark">
                    <th>#</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Email</th>
                  </thead>
                  <tbody id="access-details">
      
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary w-20 mr-1" data-tw-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('script')
<script>
    $('.view').click(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{route('article.access')}}",
      data: {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        id: $(this).attr('article_id'),
      },
      success: function success(data) {
        $('#access-details').html('');
        $.map(data, function (val, index) {
          $('#access-details').append(`
          <tr>
            <td class="whitespace-nowrap">${index + 1}</td>
            <td class="whitespace-nowrap">${val.dni}</td>
            <td class="whitespace-nowrap">${val.name}</td>
            <td class="whitespace-nowrap">${val.email}</td>
          </tr>
          `);
        });
      },
      error: function error(_error) {
        
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error');
      }
    });
  });
        $('.delete').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Desea eliminar esta seleccion?',
                text: "¡Esta accion es irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, seguro!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('article.delete') }}",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            id: $(this).attr('article_id'),
                        },
                        success: function success(data) {
                            $('#alert').html();
                            $('#alert').removeClass();
                            $('#alert').addClass('alert alert-success show mb-2');
                            $('#alert').html('Campaña eliminada con éxito');
                            $('tr#' + data).remove();
                        },
                        error: function error(_error) {


                            $('#alert').html();
                            $('#alert').removeClass();
                            $('#alert').addClass('alert alert-danger show mb-2');
                            $('#alert').html('Ha ocurrido un error al eliminar la campaña');
                        }
                    });
                }
            })
        });
    $(".copy").click(function (e) { 
        e.preventDefault();
        let idTarget = e.currentTarget
        id = parseInt($(idTarget).attr("article_id"));
        let copyText = "/post/" + id
        navigator.clipboard.writeText(copyText);
        Swal.fire(
        '¡Enlace copiado al portapapeles!',
        "",
        'success'
        )
    });
</script>
@endsection
