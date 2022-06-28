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
    @if(session()->get('message'))
      <div class="alert alert-success mb-3">
        {{ session()->get('message') }}
      </div>
    @endif
    <form action="{{ route('file.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div>
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" placeholder="Título">
      </div>
      <div class="mt-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="overview" class="form-control" placeholder="Descripción">
      </div>

      <div class="form-group mt-3">
        <input type="file" name="file" class="form-control"
          accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
      </div>

      <button class="btn btn-primary mt-5">Guardar</button>
    </form>
    {{-- <form action="{{ route('file.store') }}" method="POST">
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