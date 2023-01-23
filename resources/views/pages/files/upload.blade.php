@extends('../layout/' . $layout)

@section('subhead')
<title>Gestión de archivos</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Subir archivo</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="intro-y col-span-12 lg:col-span-12">
    
    <div class="alert alert-success mb-3" id="alertSuccess" style="display: none;"></div>
    
    <div id="multiple-file-upload" class="p-5">
      <div class="preview" class="dropzone">
        <form action="{{route('file.upload')}}" method="POST" enctype="multipart/form-data"
          class="dropzone" id="my-awesome-dropzone">
          @csrf
          <div class="fallback">
            <input name="file" type="file" multiple />
          </div>
          <div class="dz-message" data-dz-message>
            <div class="text-lg font-medium">Arrastra y suelta o haz clic</div>
            <div class="text-slate-500">
              Seleccione archivos multimedia y de click en "Subir archivos"
            </div>
          </div>
        </form>
        <button id="submit-files" class="btn btn-primary p-3 mt-2"> 
          <i data-feather="download" class="w-4 h-4 mr-2"></i> Subir archivos
        </button>
          <button type="button" data-tw-dismiss="modal" class="btn btn-primary p-3 mt-2" id="redirect-files" style="display: none;">
            <i data-feather="eye" class="w-4 h-4 mr-2"></i> Ver archivos
          </button>

      </div>
    </div>
    
    
    {{-- <form action="{{ route('file.upload') }}" method="POST">
      @csrf
      <div class="form-group row">
        <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title') }}</label>
        <div class="col-md-6">
          <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
            name="title" value="{{ old('title') }}" required autofocus />
          @if ($errors->has('title'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('title') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="overview" class="col-sm-4 col-form-label text-md-right">{{ __('Overview') }}</label>
        <div class="col-md-6">
          <textarea id="overview" cols="10" rows="10"
            class="form-control{{ $errors->has('overview') ? ' is-invalid' : '' }}" name="overview"
            value="{{ old('overview') }}" required autofocus></textarea>
          @if ($errors->has('overview'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('overview') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="media" class="col-sm-4 col-form-label text-md-right">{{ __('Media') }}</label>
        <div class="col-md-6">
          <input id="media" type="file" name="media"
            class="form-control{{ $errors->has('media') ? ' is-invalid' : '' }}" name="media" value="{{ old('media') }}"
            required autofocus />
          @if ($errors->has('media'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('media') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="submit" class="btn btn-primary">
            {{ __('Upload') }}
          </button>
        </div>
      </div>
    </form> --}}
  </div>
</div>
@endsection

@section('script')
    <script> 
     $('#redirect-files').on("click", function() {
                  window.location.href = "{{ route('file.list') }}"
                });
    </script>
@endsection