@extends('../layout/' . $layout)

@section('subhead')
    <title>Gestor de archivos</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6 mt-8">
        {{-- <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Gestor de archivos</h2>
        <!-- BEGIN: File Manager Menu -->
        <div class="intro-y box p-5 mt-6">
      
      <div class="border-t border-slate-200 dark:border-darkmode-400 mt-4 pt-4">
        <a href="" class="flex items-center px-3 py-2 rounded-md">
          <div class="w-2 h-2 bg-pending rounded-full mr-3"></div> Custom Work
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <div class="w-2 h-2 bg-success rounded-full mr-3"></div> Important Meetings
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <div class="w-2 h-2 bg-warning rounded-full mr-3"></div> Work
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <div class="w-2 h-2 bg-pending rounded-full mr-3"></div> Design
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <div class="w-2 h-2 bg-danger rounded-full mr-3"></div> Next Week
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <i class="w-4 h-4 mr-2" data-feather="plus"></i> Add New Label
        </a>
      </div>
    </div>
    <!-- END: File Manager Menu -->
  </div> --}}

        <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
            <!-- BEGIN: File Manager Filter -->
            <div id="alert" class="hidden"></div>
            <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-feather="search"></i>
                    <input type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Filtrar por:" disabled
                        style="cursor: auto">
                    <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center"
                        data-tw-placement="bottom-start">
                        <i class="dropdown-toggle w-4 h-4 cursor-pointer text-slate-500" role="button"
                            aria-expanded="false" data-tw-toggle="dropdown" data-feather="chevron-down"></i>
                        <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                            <div class="dropdown-content">
                                <div class="mt-1">
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getImg()">
                                        <i class="w-4 h-4 mr-2" data-feather="image"></i> Imagenes
                                    </a>
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getVideos()">
                                        <i class="w-4 h-4
                                        mr-2"
                                            data-feather="video"></i> Videos
                                    </a>
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getDoc()">
                                        <i class="w-4 h-4
                                        mr-2"
                                            data-feather="file"></i> Documentos
                                    </a>
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getAudio()">
                                        <i class="w-4 h-4
                                        mr-2"
                                            data-feather="headphones"></i> Audio
                                    </a>
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getElse()">
                                        <i class="w-4 h-4
                                        mr-2"
                                            data-feather="globe"></i> Otros
                                    </a>
                                    <a class="dropdown-item flex items-center px-3 py-2 mt-2 rounded-md"
                                        style="cursor: pointer;" onclick="getAll()">
                                        <i class="w-4 h-4
                                        mr-2"
                                            data-feather="plus"></i> Ver todos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-auto flex">
                    <button id="redirect-upload" class="btn btn-elevated-primary mr-2 mt-2">Subir archivos</button>
                </div>
                <div class="w-full sm:w-auto flex">
                    <button id="checkAll" class="btn btn-elevated-success mr-2 mt-2">Seleccionar todos</button>
                </div>
                <div class="w-full sm:w-auto flex">
                    <button id="deleteSelection" class="btn btn-elevated-danger mr-2 mt-2">Borrar selección</button>
                </div>
            </div>
            <!-- END: File Manager Filter -->
            <!-- BEGIN: Directory & Files -->
            <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
                @foreach ($files as $file)
                    @if (explode('/', $file['media_type'])[0] == 'image')
                        <div id="file-{{ $file['id'] }}"
                            class="image intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                <div class="absolute left-0 top-0 mt-3 ml-3">
                                    <input class="form-check-input border border-slate-500" type="checkbox"
                                        value="{{ $file['id'] }}">
                                </div>
                                <div class="w-3/5 file__icon file__icon--image mx-auto">
                                    <div class="file__icon--image__preview image-fit">
                                        <img alt="image" src="{{ asset('file/' . strtolower($file['media_name'])) }} "
                                            data-action="zoom">
                                    </div>
                                </div>
                                <a href=""
                                    class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                    Mb</div>
                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                                        data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <button class="dropdown-item single-delete" value="{{ $file['id'] }}">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                                                </button>
                                                <a id="download" class="border-0 dropdown-item justify-start"
                                                    target="_blank"
                                                    onclick="downloadOnClick(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                    <i data-feather="download" class="w-4 h-4 mr-2"></i> Descargar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (explode('/', $file['media_type'])[0] == 'application')
                        <div id="file-{{ $file['id'] }}"
                            class="application intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                <div class="absolute left-0 top-0 mt-3 ml-3">
                                    <input class="form-check-input border border-slate-500" type="checkbox"
                                        value="{{ $file['id'] }}">
                                </div>
                                <div class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">

                                    </div>
                                    {{-- <a alt="" src="{{ asset('file/' . strtolower($file['media_name'])) }}"></a> --}}
                                </div>
                                <a href=""
                                    class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                    Mb</div>
                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                                        data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <button class="dropdown-item single-delete" value="{{ $file['id'] }}">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                                                </button>
                                                @if (explode('/', $file['media_type'])[0] == 'application')
                                                    @if ($file['media_type'] == 'application/pdf')
                                                        <a data-tw-toggle="modal" data-tw-target="#myPreviewModal"
                                                            class="btn border-0 dropdown-item justify-start"
                                                            onclick="modalOpen(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                            <i data-feather="eye"
                                                                class="w-4 h-4 mr-2 text-slate-500"></i>Ver
                                                        </a>
                                                    @else
                                                        <a id="download" class="border-0 dropdown-item justify-start"
                                                            data-tw-toggle="modal" data-tw-target="#myModal"
                                                            onclick="modalPreview(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                            <i data-feather="eye" class="w-4 h-4 mr-2"></i> Ver
                                                        </a>
                                                    @endif
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (explode('/', $file['media_type'])[0] == 'video')
                        <div id="file-{{ $file['id'] }}"
                            class="video intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                <div class="absolute left-0 top-0 mt-3 ml-3">
                                    <input class="form-check-input border border-slate-500" type="checkbox"
                                        value="{{ $file['id'] }}">
                                </div>
                                <div class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">.MP4

                                    </div>
                                </div>
                                <a href=""
                                    class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                    Mb</div>
                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                                        data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <button class="dropdown-item single-delete" value="{{ $file['id'] }}">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                                                </button>
                                                <a id="download" class="border-0 dropdown-item justify-start"
                                                    target="_blank"
                                                    onclick="downloadOnClick(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                    <i data-feather="eye" class="w-4 h-4 mr-2"></i>Ver
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (explode('/', $file['media_type'])[0] == 'audio')
                        <div id="file-{{ $file['id'] }}"
                            class="audio intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                <div class="absolute left-0 top-0 mt-3 ml-3">
                                    <input class="form-check-input border border-slate-500" type="checkbox"
                                        value="{{ $file['id'] }}">
                                </div>
                                <div class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">.MP3
                                    </div>
                                </div>
                                <a href=""
                                    class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                    Mb</div>
                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                                        data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <button class="dropdown-item single-delete" value="{{ $file['id'] }}">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                                                </button>
                                                <a id="download" class="border-0 dropdown-item justify-start"
                                                    target="_blank"
                                                    onclick="downloadOnClick(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                    <i data-feather="eye" class="w-4 h-4 mr-2"></i>Ver
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="file-{{ $file['id'] }}"
                            class="else intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                <div class="absolute left-0 top-0 mt-3 ml-3">
                                    <input class="form-check-input border border-slate-500" type="checkbox"
                                        value="{{ $file['id'] }}">
                                </div>
                                <div class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">{{ $file['media_type'] }}
                                    </div>
                                </div>
                                <a href=""
                                    class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ number_format((float) (intval($file['media_size']) / (1024 * 1024)), 2, '.', '') }}
                                    Mb</div>
                                <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
                                        data-tw-toggle="dropdown">
                                        <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                <button class="dropdown-item single-delete" value="{{ $file['id'] }}">
                                                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                                                </button>
                                                <a id="download" class="border-0 dropdown-item justify-start"
                                                    data-tw-toggle="modal" data-tw-target="#myModal"
                                                    onclick="modalPreview(`{{ asset('file/' . strtolower($file['media_name'])) }}`)">
                                                    <i data-feather="eye" class="w-4 h-4 mr-2"></i> Ver
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div id="myPreviewModal" class="modal " tabindex="-1" aria-hidden="true">

                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body" style="height: 80vh; overflow-y: auto;">
                                {{-- <embed src="{{ asset('file/' . strtolower($file['media_name'])) }}" width="100%" height="100%"> --}}
                                <embed src="" width="100%" height="100%" id="filePdf">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="myModal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="p-5 text-center">
                                    <i data-feather="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                    <div class="text-2xl mt-5">Este tipo de archivo no esta disponible para su
                                        previsualizacion.</div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    <a data-tw-dismiss="modal" class="id btn btn-primary" id=""
                                        onclick="downloadOnClick(this.id)">
                                        <i data-feather="download" class="w-4 h-4 mr-2"></i> Descargar
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- END: Directory & Files -->
            <!-- BEGIN: Pagination -->
            {{-- <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-6">
      <nav class="w-full sm:w-auto sm:mr-auto">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="w-4 h-4" data-feather="chevrons-left"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="w-4 h-4" data-feather="chevron-left"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">1</a>
          </li>
          <li class="page-item active">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="w-4 h-4" data-feather="chevron-right"></i>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <i class="w-4 h-4" data-feather="chevrons-right"></i>
            </a>
          </li>
        </ul>
      </nav>
      <select class="w-20 form-select box mt-3 sm:mt-0">
        <option>10</option>
        <option>25</option>
        <option>35</option>
        <option>50</option>
      </select>
    </div> --}}
            <!-- END: Pagination -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        const modalPreview = (e) => {
            $(".id").attr("id", e);
        }
        const modalOpen = (e) => {
            // console.log(e);
            $("#filePdf").attr("src", e);

        }
        const downloadOnClick = (e) => {
            // console.log(e);
            window.open(e);
        }

        const getImg = () => {
            $(".image").show();
            $(".audio").hide();
            $(".video").hide();
            $(".else").hide();
            $(".application").hide();

        }

        const getVideos = () => {
            $(".image").hide();
            $(".audio").hide();
            $(".video").show();
            $(".else").hide();
            $(".application").hide();
        }

        const getDoc = () => {
            $(".image").hide();
            $(".audio").hide();
            $(".video").hide();
            $(".else").hide();
            $(".application").show();
        }

        const getElse = () => {
            $(".image").hide();
            $(".audio").hide();
            $(".video").hide();
            $(".else").show();
            $(".application").hide();
        }
        const getAudio = () => {
            $(".image").hide();
            $(".audio").show();
            $(".video").hide();
            $(".else").hide();
            $(".application").hide();
        }
        const getAll = () => {
            $(".image").show();
            $(".audio").show();
            $(".video").show();
            $(".else").show();
            $(".application").show();
        }




        $('#deleteSelection').click(function() {
            list = $('input[type=checkbox]:checked').map(function(i, el) {
                let value = $(el).val();
                $(el).parent().parent().parent().remove();
                return value;
            }).get();

            console.log(list);

            $.ajax({
                type: "POST",
                url: "{{ route('file.delete') }}",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    data: list,
                },

                success: function success(data) {
                    $('#alert').html();
                    $('#alert').removeClass();
                    $('#alert').addClass('alert alert-success show mb-2');
                    $('#alert').html('Archivos eliminados con éxito');
                },
                error: function error(_error) {
                    console.log('error', _error);
                    $('#alert').html();
                    $('#alert').removeClass();
                    $('#alert').addClass('alert alert-danger show mb-2');
                    $('#alert').html('Ha ocurrido un error al eliminar los archivos');
                }
            });


        });

        $("#checkAll").click(function() {
            let checked = $('input:checkbox').is(':checked');
            $('input:checkbox').not(this).prop('checked', !checked);
        });

        $('#redirect-upload').click(function() {
            window.location.href = "{{ route('file.up') }}"
        });

        $('.single-delete').click(function() {
            let list = [];
            list.push($(this).val());

            $(this).parent().remove();
            $("#file-" + $(this).val()).remove();

            $.ajax({
                type: "POST",
                url: "{{ route('file.delete') }}",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    data: list,
                },

                success: function success(data) {
                    $('#alert').html();
                    $('#alert').removeClass();
                    $('#alert').addClass('alert alert-success show mb-2');
                    $('#alert').html('Archivos eliminados con éxito');
                },
                error: function error(_error) {
                    console.log('error', _error);
                    $('#alert').html();
                    $('#alert').removeClass();
                    $('#alert').addClass('alert alert-danger show mb-2');
                    $('#alert').html('Ha ocurrido un error al eliminar los archivos');
                }
            });
        });
    </script>
@endsection
