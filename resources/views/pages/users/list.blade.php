@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de usuarios</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Lista de usuarios</h2>
</div>
<div class="intro-y col-span-12 lg:col-span-6">
  <div class="intro-y box">
    <div class="p-5" id="head-options-table">
      <div class="preview">
        <div class="overflow-x-auto">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">Nombres</th>
                <th class="whitespace-nowrap">Correo</th>
                <th class="whitespace-nowrap">Activo</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->active ? 'Si' : 'No' }}</td>
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