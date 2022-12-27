@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de datos de producción</title>
@endsection

@section('subcontent')
<div id="alert" class="hidden"></div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-4" id="users-list">
  <h2 class="text-lg font-medium mr-auto">Lista de datos de producción</h2>

  <div class="w-auto ml-auto">
    <div class="dropdown mr-2">
      <div class="dropdown hidden" id="add-data">
        <button class="dropdown-toggle btn btn-primary shadow-md flex items-center" aria-expanded="false"
          data-tw-toggle="dropdown">
          Añadir datos de producción <i class="w-4 h-4 ml-2" data-feather="chevron-down"></i>
        </button>
        <div class="dropdown-menu w-fit">
          <ul class="dropdown-content">
            <li>
              <button id="manually" class="dropdown-item text-right" data-tw-toggle="modal"
                data-tw-target="#manually-modal">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Manualmente
              </button>
            <li>
              <button id="by-doc" class="dropdown-item text-right" data-tw-toggle="modal"
                data-tw-target="#automatic-modal">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Subir documento
              </button>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- BEGIN: Table Head Options -->
<div class="intro-y box">
  <div class="p-5" id="head-options-table">
    <div class="preview">
      <div class="mt-3 mb-3">
        <label>Filtrar por campaña</label>
        <div class="mt-2 mb-2">
          <select data-placeholder="Buscar..." name="page_id" class="tom-select w-full" id="campaign">
            <option disabled selected>Seleccione una campaña</option>
            @foreach ($campaigns as $campaign)
            <option value="{{ $campaign->id }}">{{ $campaign->title }} - {{ $campaign->page_title }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <table class="table table-auto hidden">
        <thead class="table-dark">
          <tr>
            <th class="text-center">DNI</th>
            <th class="text-center">Nombre</th>
            <th class="text-center">Póliza Objetivo</th>
            <th class="text-center">Ventas</th>
            <th class="text-center">%</th>
            <th class="text-center">Primas</th>
            <th class="text-center">Incentivos</th>
          </tr>
        </thead>
        <tbody id="suscribed-list">
          {{-- @foreach ($campaigns as $campaign)
          <tr id={{$campaign->id}}>
            <td>{{$campaign->title}}</td>
            <td>{{$campaign->description}}</td>
            <td>{{$campaign->page_title}}</td>
            <td>{{$campaign->created_at}}</td>
          </tr>
          @endforeach --}}
        </tbody>
      </table>
    </div>
  </div>
</div>


<div id="manually-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <a data-tw-dismiss="modal" href="javascript:;">
        <i data-feather="x" class="w-8 h-8 text-slate-400"></i>
      </a>
      <div class="modal-body p-10">
        <div id="alert" class="hidden"></div>
        <form id="add-production">
          @csrf
          <!-- BEGIN: Input -->
          <div class="intro-y box">
            <div id="input" class="p-5">
              <div class="preview">
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Objetivo de pólizas</label>
                  <input class="form-control" id="policy_objective" name="policy_objective" type="number" step="0.01"
                    placeholder="Objetivo de pólizas">
                </div>
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Pólizas logradas</label>
                  <input class="form-control" id="policy_raised" name="policy_raised" type="number" step="0.01"
                    placeholder="Pólizas logradas">
                </div>
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Primas</label>
                  <input class="form-control" id="bonus" name="bonus" type="number" step="0.01" placeholder="Primas">
                </div>
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Incentivo</label>
                  <input class="form-control" id="incentive" name="incentive" type="number" step="0.01"
                    placeholder="Incentivo">
                </div>
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Usuarios</label>
                  <select data-placeholder="Buscar..." id="user_id" name="user_id" class="tom-select w-full" multiple>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mt-3">
                  <label for="regular-form-1" class="form-label">Campaña</label>
                  <select data-placeholder="Buscar..." id="campaign_id" name="campaign_id" class="tom-select w-full">
                    <option disabled selected>Seleccione una campaña</option>
                    @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">{{ $campaign->title }} - {{ $campaign->page_title }}</option>
                    @endforeach
                  </select>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                  class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear</button>
              </div>
            </div>
          </div>
          <!-- END: Input -->
        </form>
      </div>
    </div>
  </div>
</div>

<div id="automatic-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <a data-tw-dismiss="modal" href="javascript:;">
        <i data-feather="x" class="w-8 h-8 text-slate-400"></i>
      </a>
      <div class="modal-body p-10">
        <div id="alert" class="hidden"></div>
        <div class="mt-3">
          <label for="regular-form-1" class="form-label">Campaña</label>
          <select data-placeholder="Buscar..." id="auto_campaign_id" name="campaign_id" class="tom-select w-full">
            <option disabled selected>Seleccione una campaña</option>
            @foreach ($campaigns as $campaign)
            <option value="{{ $campaign->id }}">{{ $campaign->title }} - {{ $campaign->page_title }}</option>
            @endforeach
          </select>
        </div>
        <div class="intro-y box">
          <div id="single-file-upload" class="p-5">
            <div class="preview">
              <form id="import-campaign" data-single="true" method="POST" action="{{route('production.import')}}"
                enctype="multipart/form-data" class="dropzone hidden">
                @csrf
                <div class="fallback">
                  <input name="file" type="file" />
                </div>
                <div class="dz-message" data-dz-message>
                  <div class="text-lg font-medium">Arrastra el archivo hasta acá o haz click para subir uno.</div>
                  <div class="text-slate-500">
                    Seleccione archivos de hoja de cálculo en formato xls
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $('#campaign').change(function () {
    console.log($(this).val());
    $('table, #add-data').removeClass('hidden');

    $.ajax({
      type: "GET",
      url: "{{route('production.campaign')}}",
      data: {
        "_token": "{{ csrf_token() }}",
        id: $(this).val(),
      },
      success: function success(data) {
        $('#suscribed-list').html();
        if (!data) {
          $('#suscribed-list').html('<tr><th class="text-center w-full" colspan="7">No hay registros para mostrar</th></tr>');
        } else {
          let printData = '';
          for (let i = 0; i < data.length; i++) {
            const item = data[i];
            let tr = '<tr id="' + item.id + '">'
              + '<td class="text-right">'
              + item.dni
              + '</td>'
              + '<td class="text-right">'
              + item.name
              + '</td>'
              + '<td class="text-right">'
              + item.policy_objective
              + '</td>'
              + '<td class="text-right">'
              + item.policy_raised
              + '</td>'
              + '<td class="text-right">'
              + (item.policy_raised * 100 / item.policy_objective).toPrecision(2)
              + '%</td>'
              + '<td class="text-right">'
              + item.bonus
              + '</td>'
              + '<td class="text-right">'
              + item.incentive
              + '</td>'
              + '<td><button campaign_id="' + item.id + '" class="delete flex items-center text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Eliminar</button></td></tr>';
            printData += tr;
          }
          $('#suscribed-list').html(printData);
        }
      },
      error: function error(_error) {
        console.log('error', _error);

        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error al eliminar la campaña');
      }
    });
  });

  $('#add-production').on('submit', function (e) {
    e.preventDefault();

    let data = {
      "_token": "{{ csrf_token() }}",
      policy_objective: $('#policy_objective').val().length ? parseFloat($('#policy_objective').val()) : 0,
      policy_raised: $('#policy_raised').val().length ? parseFloat($('#policy_raised').val()) : 0,
      bonus: $('#bonus').val().length ? parseFloat($('#bonus').val()) : 0,
      incentive: $('#incentive').val().length ? parseFloat($('#incentive').val()) : 0,
      user_id: $('#user_id').val().length ? $('#user_id').val() : 0,
      campaign_id: $('#campaign_id').val()?.length ? parseInt($('#campaign_id').val()) : 0,
    };

    console.log(data, !data.user_id || !data.campaign_id);

    if (!data.user_id || !data.campaign_id) {
      $('#manually-modal #alert').html();
      $('#manually-modal #alert').removeClass();
      $('#manually-modal #alert').addClass('alert alert-warning mt-2 mb-2');
      $('#manually-modal #alert').html('Debe seleccionar al menos un usuario y una campaña');
    } else {
      $.ajax({
        type: "POST",
        url: "{{route('production.create')}}",
        data: data,
        success: function (data) {
          console.log(data);
          if (!data) {
            $('#manually-modal #alert').html();
            $('#manually-modal #alert').removeClass();
            $('#manually-modal #alert').addClass('alert alert-error show mb-2');
            $('#manually-modal #alert').html('Ha ocurrido un error al crear');
          } else {
            $('#manually-modal #alert').html();
            $('#manually-modal #alert').removeClass();
            $('#manually-modal #alert').addClass('alert alert-success show mb-2');
            $('#manually-modal #alert').html('Datos añadidos con éxito');
          }

          $.ajax({
            type: "GET",
            url: "{{route('production.campaign')}}",
            data: {
              "_token": "{{ csrf_token() }}",
              id: parseInt($('#campaign').val()),
            },
            success: function success(data) {
              $('#suscribed-list').html();
              if (!data) {
                $('#suscribed-list').html('<tr><th class="text-center w-full" colspan="7">No hay registros para mostrar</th></tr>');
              } else {

                let printData = '';
                for (let i = 0; i < data.length; i++) {
                  const item = data[i];
                  let tr = '<tr id="' + item.id + '">'
                    + '<td class="text-right">'
                    + item.dni
                    + '</td>'
                    + '<td class="text-right">'
                    + item.name
                    + '</td>'
                    + '<td class="text-right">'
                    + item.policy_objective
                    + '</td>'
                    + '<td class="text-right">'
                    + item.policy_raised
                    + '</td>'
                    + '<td class="text-right">'
                    + (item.policy_raised * 100 / item.policy_objective).toPrecision(2)
                    + '%</td>'
                    + '<td class="text-right">'
                    + item.bonus
                    + '</td>'
                    + '<td class="text-right">'
                    + item.incentive
                    + '</td>'
                    + '<td><button campaign_id="' + item.id + '" class="delete flex items-center text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Eliminar</button></td></tr>';
                  printData += tr;
                }
                $('#suscribed-list').html(printData);
              }
            },
            error: function error(_error) {
              console.log('error', _error);

              $('#manually-modal #alert').html();
              $('#manually-modal #alert').removeClass();
              $('#manually-modal #alert').addClass('alert alert-danger show mb-2');
              $('#manually-modal #alert').html('Ha ocurrido un error al eliminar la campaña');
            }
          });
        },
        error: function (error) {
          console.log('error', error);
        },
      });
    }
  });

  $(document).on('click', '.delete', function (e) {
    console.log('delete', $(this).attr('campaign_id'));
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{route('production.delete')}}",
      data: {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        id: $(this).attr('campaign_id'),
      },
      success: function success(data) {
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-success show mb-2');
        $('#alert').html('Dato eliminado con éxito');
        $('tr#' + data).remove();
      },
      error: function error(_error) {
        console.log('error', _error);
  
        $('#alert').html();
        $('#alert').removeClass();
        $('#alert').addClass('alert alert-danger show mb-2');
        $('#alert').html('Ha ocurrido un error al eliminar el dato');
      }
    });
  });

</script>
@endsection