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
    <form action="{{ route('file.store') }}" method="POST">
      @csrf
      <div class="intro-y box">
        <div id="single-file-upload" class="p-5">
          <div class="preview">
            <form data-single="true" action="{{route('file.upload')}}" method="POST" enctype="multipart/form-data"
              class="dropzone">
              <div class="fallback">
                <input name="file" type="file" />
              </div>
              <div class="dz-message" data-dz-message>
                <div class="text-lg font-medium">Arrastra el archivo hasta acá o haz click para subir uno.</div>
                <div class="text-slate-500">
                  Seleccione imágenes
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="upload-users"></div>
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
      <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="submit" class="btn btn-primary">
            {{ __('Upload') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var drop = new Dropzone('#file', {
    createImageThumbnails: false,
    addRemoveLinks: true,
    url: "{{ route('file.upload') }}",
    headers: {
      'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
    }
  });
</script>
@endsection