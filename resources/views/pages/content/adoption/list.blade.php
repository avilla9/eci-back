@extends('../layout/' . $layout)

@section('subhead')
    <title>Lista de posts de Adopción</title>
@endsection

@section('subcontent')
    <div id="alert" class="hidden"></div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8" id="users-list">
        <h2 class="text-lg font-medium mr-auto">Lista de posts de Adopción</h2>
    </div>
    <!-- BEGIN: Table Head Options -->
    <div class="intro-y box">
        <div class="p-5" id="head-options-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th class="whitespace-nowrap">Título</th>
                                <th class="whitespace-nowrap">Sección</th>
                                <th class="whitespace-nowrap">Creación</th>
                                <th class="whitespace-nowrap">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr id={{ $article->id }}>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->section_title }}</td>
                                    <td>{{ $article->created_at }}</td>
                                    <td><button article_id="{{ $article->id }}"
                                            class="delete flex items-center text-danger">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                        </button></td>
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
                text: "Esta accion es irreversible!",
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
                            $('#alert').html('Adopción eliminada con éxito');
                            $('tr#' + data).remove();
                        },
                        error: function error(_error) {
                            console.log('error', _error);

                            $('#alert').html();
                            $('#alert').removeClass();
                            $('#alert').addClass('alert alert-danger show mb-2');
                            $('#alert').html('Ha ocurrido un error al eliminar la Adopción');
                        }
                    });
                }
            })


        });
    </script>
@endsection
