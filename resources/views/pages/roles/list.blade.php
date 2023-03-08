@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de Roles</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">Lista de roles</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button class="btn btn-primary shadow-md mr-2">Añadir nuevo rol</button>
    <div class="dropdown ml-auto sm:ml-0">
      <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
        <span class="w-5 h-5 flex items-center justify-center">
          <i class="w-4 h-4" data-feather="plus"></i>
        </span>
      </button>
      <div class="dropdown-menu w-40">
        <ul class="dropdown-content">
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> New Category
            </a>
          </li>
          <li>
            <a href="" class="dropdown-item">
              <i data-feather="users" class="w-4 h-4 mr-2"></i> New Group
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- BEGIN: HTML Table Data -->
<div class="intro-y box p-5 mt-5">
  <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
    <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto">
      <div class="sm:flex items-center sm:mr-4">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Campo</label>
        <select id="tabulator-html-filter-field" class="form-select w-full 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
          <option value="name">Codigo de Rol</option>
          <option value="description">Descripcion</option>
        </select>
      </div>
      <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Tipo</label>
        <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto">
          <option value="like" selected>Parecido a</option>
          <option value="=">=</option>
          <option value="<">&lt;</option>
          <option value="<=">&lt;=</option>
          <option value=">">></option>
          <option value=">=">>=</option>
          <option value="!=">!=</option>
        </select>
      </div>
      <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Valor</label>
        <input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"
          placeholder="Buscar...">
      </div>
      <div class="mt-2 xl:mt-0">
        <button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16">
          Buscar
        </button>
        <button id="tabulator-html-filter-reset" type="button"
          class="btn btn-secondary w-full sm:w-16 sm:mt-0 sm:ml-1">Reiniciar</button>
      </div>
    </form>
    <div class="flex mt-5 sm:mt-0">
      <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
        <i data-feather="printer" class="w-4 h-4"></i>
      </button>
      <div class="dropdown w-1/2 sm:w-auto">
        <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false"
          data-tw-toggle="dropdown">
          <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exportar <i data-feather="chevron-down"
            class="w-4 h-4 ml-auto sm:ml-2"></i>
        </button>
        <div class="dropdown-menu w-40">
          <ul class="dropdown-content">
            <li>
              <a id="tabulator-export-csv" href="javascript:;" class="dropdown-item">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exportar CSV
              </a>
            </li>
            <li>
              <a id="tabulator-export-json" href="javascript:;" class="dropdown-item">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exportar JSON
              </a>
            </li>
            <li>
              <a id="tabulator-export-xlsx" href="javascript:;" class="dropdown-item">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exportar XLSX
              </a>
            </li>
            <li>
              <a id="tabulator-export-html" href="javascript:;" class="dropdown-item">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Exportar HTML
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="overflow-x-auto scrollbar-hidden">
    <div id="role-tabulator" class="mt-5 table-report table-report--tabulator"></div>
  </div>
</div>
<!-- END: HTML Table Data -->

{{-- <div class="intro-y flex items-center mt-8">
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
</div> --}}
@endsection