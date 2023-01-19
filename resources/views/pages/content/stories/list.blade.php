@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de Stories</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8" id="users-list">
  <h2 class="text-lg font-medium mr-auto">Lista de Stories</h2>
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
              <th class="whitespace-nowrap">CTA</th>
              <th class="whitespace-nowrap">CTA Link</th>
              <th class="whitespace-nowrap">Creación</th>
              <th class="whitespace-nowrap">Usuarios</th>
              <th class="whitespace-nowrap">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($articles as $article)
            <tr id={{$article->id}}>
              <td>
                <div class="w-3/5 file__icon file__icon--image mx-auto">
                  <div class="file__icon--image__preview image-fit h-12">
                    <img alt="Imagen" src="{{$article->media_path}}" data-action="zoom">
                  </div>
                </div>
              </td>
              <td>{{$article->button_name ? $article->button_name : 'No contiene'}}</td>
              <td>
                @if ($article->button_link)
                <a href="{{$article->button_link}}" target="_blank"
                  class="text-primary block font-normal">{{$article->button_link}}</a>
                @else
                No contiene
                @endif
              </td>
              <td>{{explode(' ', $article->created_at)[0]}}</td>
              <td>
                @if ($article->unrestricted)
                Todos
                @else
                <a href="javascript:;" data-tw-toggle="modal" article_id="{{$article->id}}" data-tw-target="#user-list"
                  class="view flex items-center text-primary"><i data-feather="eye" class="w-4 h-4 mr-1"></i> Ver</a>
                @endif
              </td>
              <td><button article_id="{{$article->id}}" class="delete flex items-center text-danger">
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

<div id="user-list" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Lista de usuarios con acceso a la story</h2>
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

<!-- END: HTML Table Data -->
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
        console.log(data);
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
        console.log('error', _error);
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error');
      }
    });
  });

  $('.delete').click(function (e) {
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
                    url: "{{route('article.delete')}}",
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
                      console.log('error', _error);

                      $('#alert').html();
                      $('#alert').removeClass();
                      $('#alert').addClass('alert alert-danger show mb-2');
                      $('#alert').html('Ha ocurrido un error al eliminar la story');
                    }
                  });
            }
          })
  });
</script>
@endsection