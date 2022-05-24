@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de Roles</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Lista de Roles</h2>
</div>
<div class="intro-y col-span-12 lg:col-span-6 mt-5">
  <div class="intro-y box">
    <div class="p-5" id="head-options-table">
      <div class="preview">
        <div class="overflow-x-auto">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">Nombres</th>
                <th class="whitespace-nowrap">Descripción</th>
                <th class="whitespace-nowrap">Nivel de acceso</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($roles as $role)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>
                <td>{{ $role->level }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection