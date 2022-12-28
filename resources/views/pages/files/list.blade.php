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
      <div class="mt-1">
        <a href="" class="flex items-center px-3 py-2 rounded-md bg-primary text-white font-medium">
          <i class="w-4 h-4 mr-2" data-feather="image"></i> Images
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <i class="w-4 h-4 mr-2" data-feather="video"></i> Videos
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <i class="w-4 h-4 mr-2" data-feather="file"></i> Documents
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <i class="w-4 h-4 mr-2" data-feather="users"></i> Shared
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
          <i class="w-4 h-4 mr-2" data-feather="trash"></i> Trash
        </a>
      </div>
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
      {{-- <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
        <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-feather="search"></i>
        <input type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Search files">
        <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center"
          data-tw-placement="bottom-start">
          <i class="dropdown-toggle w-4 h-4 cursor-pointer text-slate-500" role="button" aria-expanded="false"
            data-tw-toggle="dropdown" data-feather="chevron-down"></i>
          <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
            <div class="dropdown-content">
              <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                <div class="col-span-6">
                  <label for="input-filter-1" class="form-label text-xs">File Name</label>
                  <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="Type the file name">
                </div>
                <div class="col-span-6">
                  <label for="input-filter-2" class="form-label text-xs">Shared With</label>
                  <input id="input-filter-2" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                </div>
                <div class="col-span-6">
                  <label for="input-filter-3" class="form-label text-xs">Created At</label>
                  <input id="input-filter-3" type="text" class="form-control flex-1" placeholder="Important Meeting">
                </div>
                <div class="col-span-6">
                  <label for="input-filter-4" class="form-label text-xs">Size</label>
                  <select id="input-filter-4" class="form-select flex-1">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                  </select>
                </div>
                <div class="col-span-12 flex items-center mt-3">
                  <button class="btn btn-secondary w-32 ml-auto">Create Filter</button>
                  <button class="btn btn-primary w-32 ml-2">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
      <div class="w-full sm:w-auto flex">
        <button id="redirect-upload" class="btn btn-elevated-primary mr-2">Subir archivos</button>
      </div>
      <div class="w-full sm:w-auto flex">
        <button id="checkAll" class="btn btn-elevated-success mr-2">Seleccionar todos</button>
      </div>
      <div class="w-full sm:w-auto flex">
        <button id="deleteSelection" class="btn btn-elevated-danger mr-2">Borrar selección</button>
      </div>
    </div>
    <!-- END: File Manager Filter -->
    <!-- BEGIN: Directory & Files -->
    <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
      @foreach ($files as $file)
      <div id="file-{{$file['id']}}" class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
          <div class="absolute left-0 top-0 mt-3 ml-3">
            <input class="form-check-input border border-slate-500" type="checkbox" value="{{$file['id']}}">
          </div>

          <div class="w-3/5 file__icon file__icon--image mx-auto">
            <div class="file__icon--image__preview image-fit">
              <img alt="Imagen" src="{{ asset('file/' . strtolower($file['media_name'])) }} " data-action="zoom">
            </div>
          </div>

          {{-- @if ($file['files'][0]['type'] == 'Empty Folder')
          <a href="" class="w-3/5 file__icon file__icon--empty-directory mx-auto"></a>
          @elseif ($file['files'][0]['type'] == 'Folder')
          <a href="" class="w-3/5 file__icon file__icon--directory mx-auto"></a>
          @elseif ($file['files'][0]['type'] == 'Image')
          <a href="" class="w-3/5 file__icon file__icon--image mx-auto">
            <div class="file__icon--image__preview image-fit">
              <img alt="Icewall Tailwind HTML Admin Template"
                src="{{ asset('dist/images/' . strtolower($file['files'][0]['file_name'])) }}">
            </div>
          </a>
          @else
          <a href="" class="w-3/5 file__icon file__icon--file mx-auto">
            <div class="file__icon__file-name">{{ $file['files'][0]['type'] }}</div>
          </a>
          @endif --}}

          <a href="" class="block font-medium mt-4 text-center truncate">{{ $file['title'] }}</a>
          <div class="text-slate-500 text-xs text-center mt-0.5">{{ number_format(
            (float)(intval($file['media_size']) / (1024 * 1024)), 2, '.', ''
            ) }} Mb</div>
          <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"
              data-tw-toggle="dropdown">
              <i data-feather="more-vertical" class="w-5 h-5 text-slate-500"></i>
            </a>
            <div class="dropdown-menu w-40">
              <ul class="dropdown-content">
                <li>
                  <button class="dropdown-item single-delete" value="{{$file['id']}}">
                    <i data-feather="trash" class="w-4 h-4 mr-2"></i> Eliminar
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      @endforeach
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
  $('#deleteSelection').click(function () {
    list = $('input[type=checkbox]:checked').map(function(i, el) {
      let value = $(el).val();
      $(el).parent().parent().parent().remove();
      return value;
    }).get();

    console.log(list);

    $.ajax({
      type: "POST",
      url: "{{route('file.delete')}}",
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

  $("#checkAll").click(function () {
    let checked = $('input:checkbox').is(':checked');
    $('input:checkbox').not(this).prop('checked', !checked);
  });

  $('#redirect-upload').click(function () {
    window.location.href = "{{route('file.up')}}"
  });

  $('.single-delete').click(function () {
    let list = [];
    list.push($(this).val());

    $(this).parent().remove();
    $("#file-"+$(this).val()).remove();

    $.ajax({
      type: "POST",
      url: "{{route('file.delete')}}",
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