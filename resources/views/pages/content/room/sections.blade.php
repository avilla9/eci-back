@extends('../layout/' . $layout)

@section('subhead')
<title>Crear contenido - Salas</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Gestión de la sección</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <input type="text" class="hidden" value= {{$sections[0]->page_id}} id="pageId">
    <button id="open-create" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
      Crear <i class="w-4 h-4 ml-2" data-feather="plus-square"></i>
    </button>
  </div>
</div>
<div id="form-body2" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
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
          <td><button article_id="{{$article->id}}" class="delete flex items-center text-danger" id="deleteSection">
              <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
            </button>
            <button article_id="{{$article->id}}" class="edit flex items-center" onclick="modalEdit(event)">
            <i data-feather="check-square" class="w-4 h-4 mr-1 my-4"></i> Editar
          </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    
    <!--EDIT Modal -->
    <div id="edit-section" class="modal fade" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
      <div class="modal-dialog modal-xl" style="overflow-y: initial !important;">
        <div class="modal-content">
          <div class="modal-body" style="max-height: calc(100vh - 130px); overflow-y: auto;">
            <h2 class="p-5 font-medium text-base mr-auto">Editar seccion</h2>
            <div id="editable">
              <form id="SubmitForm">
                @csrf
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                  <div id="input" class="p-5">
                    <div class="preview">
                      <div>
                        <label for="regular-form-1" class="form-label">Titulo</label>
                        <input id="id" name="id" type="hidden" hidden class="form-control"
                          placeholder="ID">
                        <input id="title" name="title" type="text" class="form-control"
                          placeholder="Titulo...">
                      </div>
                      <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Descripcion</label>
                        <input id="description" type="text" class="form-control"
                          placeholder="Descripcion...">
                      </div>
                      <div class="mt-3">
                      <div class="flex flex-col sm:flex-row items-center pb-4 border-b border-slate-200/60 dark:border-darkmode-400">
                        <label class="form-check-label" for="show-example-2">Visible para todos</label>
                        <input name="select-all" id="show-example-2" data-target="#boxed-accordion"
                          class="show-code form-check-input mr-0 ml-3" type="checkbox">
                      </div>
                      <div id="filters2" class="mt-2">
                        @foreach ($filters as $key => $filter)
                        <label class="form-label">{{$filter['name']}}</label>
                        <select name="{{$key}}" data-placeholder="Añadir a la visibilidad" autocomplete="off" class="selector-{{$key}} tom-select w-full mb-2" multiple>
                          @foreach ($filter['data'] as $item)
                          <option value="{{$item['id']}}" >{{$item['name']}}</option>
                          @endforeach
                        </select>
                        @endforeach
                      </div>
                      </div>
                      <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Imagen de perfil</label>
                        <div class="mb-3 overflow-y-auto" style="max-height: calc(100vh - 300px); overflow-y: auto; overflow-x: hidden;">
                          @if (count($files))
                          <div class="text-center font-bold mb-3">Seleccionar imagen</div>
                          <div class="intro-y grid grid-cols-6 gap-3 sm:gap-6">
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
                
                    <div class="modal-footer my-5">
  
                      <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                      <button type="submit" class="btn btn-primary my-4" id="updateSection">Actualizar
                        seccion</button>
                      <div class="alert alert-success my-3" role="alert" style="display:none;"
                        id="alertUpdateSuccess">
                        Seccion actualizada con exito!
                      </div>
                      <div class="alert alert-danger my-3" role="alert" style="display:none;" id="alertUpdateFailed">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Input -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END EDIT Modal -->
    </div>

    <!--CREATE Modal -->
    <div id="create-section" class="modal fade" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
      <div class="modal-dialog modal-xl" style="overflow-y: initial !important;">
        <div class="modal-content">
          <div class="modal-body" style="max-height: calc(100vh - 130px); overflow-y: auto;">
            <h2 class="p-5 font-medium text-base mr-auto">Crear seccion</h2>
            <div id="editable">
              <form id="SubmitForm">
                @csrf
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                  <div id="input" class="p-5">
                    <div class="preview">
                      <div class="col-span-12 lg:col-span-3">
                        <div class="intro-y box p-5">
                          <div>
                            <label for="regular-form-1" class="form-label">Titulo</label>
                            <input id="id-create" name="id-create" type="hidden" hidden class="form-control"
                              placeholder="ID">
                            <input id="create-title" name="title" type="text" class="form-control"
                              placeholder="Titulo...">
                          </div>
                          <div class="mt-3">
                            <label for="regular-form-1" class="form-label">Descripcion</label>
                            <input id="description-create" type="text" class="form-control"
                              placeholder="Descripcion...">
                          </div>
                          <div>
                            <label for="post-form-2" class="form-label">Fecha de carga</label>
                            <input name="create-date" type="text" class="datepicker form-control" id="post-form-2" data-single-mode="true">
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
                      <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Imagen de perfil</label>
                        <div class="mb-3 overflow-y-auto" style="max-height: calc(100vh - 300px); overflow-y: auto; overflow-x: hidden;">
                          @if (count($files))
                          <div class="text-center font-bold mb-3">Seleccionar imagen</div>
                          <div class="intro-y grid grid-cols-6 gap-3 sm:gap-6">
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
                
                    <div class="modal-footer my-5">
                      <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                      <button type="submit" class="btn btn-primary my-4" id="send-create">Crear seccion</button>
                      <div id="alert2" class="hidden"></div>
                      <div class="alert alert-success my-3" role="alert" style="display:none;"
                        id="alertCreateSuccess">
                        ¡Seccion creada con exito!
                      </div>
                      <div class="alert alert-danger my-3" role="alert" style="display:none;" id="alertCreateFailed">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END: Input -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--END CREATE Modal -->
    </div>
    

  </div>
  <!-- END: Post Content -->
</div>
@endsection

@section('script')
{{-- <script src="{{ asset('dist/js/articles/room.js') }}"></script> --}}
<script>
  const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector("#edit-section"));
  const modalEdit = async(e) => {
   
    
    let idTarget = e.currentTarget
    id = parseInt($(idTarget).attr("article_id"))
    $.ajax({
        type: "GET",
        url: "/api/posts/sections-filters/" + id,
        success: function(response) {
            console.log(response.sectionsFilters[0].groups);
            $.each(response.sectionsFilters[0].groups, function(index, value) {
                $('.selector-groups').find('option[value="' + value + '"]').attr("selected", "selected");
            });
            $.each(response.sectionsFilters[0].delegations, function(index, value) {
              $('.selector-delegations').find('option[value="' + value + '"]').attr("selected", "selected");
            });
            $.each(response.sectionsFilters[0].roles, function(index, value) {
                $('.selector-roles').find('option[value="' + value + '"]').attr("selected", "selected");
            });
            $.each(response.sectionsFilters[0].users, function(index, value) {
                $('.selector-users').find('option[value="' + value + '"]').attr("selected", "selected");
            });
            $.each(response.sectionsFilters[0].quartiles, function(index, value) {
                $('.selector-quartiles').find('option[value="' + value + '"]').attr("selected", "selected");
                // $("select-quartiles").ultiselect();
            });
            myModal.show()
        },
        error: function error(_error) {
            console.log(_error.responseJSON.message);
            // console.log(error);
            let errors = _error.responseJSON.message;

            if (errors === undefined) {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html('Ha ocurrido un error al consultar la seccion');

            } else {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html(errors);
            }
            setTimeout(function() {
                $('#alert').fadeOut(4000);
            }, 2000);
        }
    });
    $.ajax({
        type: "GET",
        url: `/api/posts/room/${id}`,
        success: function success(data) {
            $("#id").val(data[0].id)
            $("#title").val(data[0].title)
            $("#description").val(data[0].description)
            $('input[name=image]').each(function() {
                if ($(this).val() == data[0].file_id) {
                    $(this).attr("checked", "true")
                }
            })
            
        },
        error: function error(_error) {
            console.log(_error.responseJSON.message);
            // console.log(error);
            let errors = _error.responseJSON.message;

            if (errors === undefined) {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html('Ha ocurrido un error al consultar la seccion');

            } else {
                $('#alert').html();
                $('#alert').removeClass();
                $('#alert').addClass('alert alert-danger show mb-2 my-3');
                $('#alert').html(errors);
            }
            setTimeout(function() {
                $('#alert').fadeOut(4000);
            }, 2000);

        }
    });
}

</script>
@endsection