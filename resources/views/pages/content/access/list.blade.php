@extends('../layout/' . $layout)

@section('subhead')
    <title>Lista de posts de Accesos</title>
@endsection

@section('subcontent')
    <div id="alert" class="hidden"></div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8" id="users-list">
        <h2 class="text-lg font-medium mr-auto">Lista de posts de Accesos</h2>
    </div>
    <!-- BEGIN: Table Head Options -->
    <div class="intro-y box">
        <div class="p-5" id="head-options-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-dark">|
                            <tr>
                                <th class="whitespace-nowrap">Archivo</th>
                                <th class="whitespace-nowrap">Título</th>
                                <th class="whitespace-nowrap">Sección</th>
                                <th class="whitespace-nowrap">Creación</th>
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
                                        <a class="edit flex items-center mr-3" href="{{ route('content.access.details', $article->id) }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1 my-4"></i> Editar
                                        </a>
                                        <button article_id="{{ $article->id }}"
                                            class="delete flex items-center text-danger">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                        </button>
                                        <button article_id="{{ $article->id }}"
                                            class="copy flex items-center text-dark" style="width: 100px;">
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
@endsection

@section('script')
    <script>
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
