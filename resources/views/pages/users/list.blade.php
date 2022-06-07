@extends('../layout/' . $layout)

@section('subhead')
<title>Lista de usuarios</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8" id="users-list">
  <h2 class="text-lg font-medium mr-auto">Lista de usuarios</h2>
  <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    <button class="btn btn-primary shadow-md mr-2">Añadir nuevo usuario</button>
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
        <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
          <option value="name">Nombre</option>
          <option value="rol">Rol</option>
          <option value="email">Correo</option>
        </select>
      </div>
      <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
        <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto">
          <option value="like">like</option>
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
          class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reiniciar</button>
      </div>
    </form>
    <div class="flex mt-5 sm:mt-0">
      <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
        <i data-feather="printer" class="w-4 h-4 mr-2"></i> Imprimir
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
    <div id="user-tabulator" class="mt-5 table-report table-report--tabulator"></div>
  </div>
</div>

<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h2 class="p-5 font-medium text-base mr-auto">Información detallada del usuario</h2>
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th class="whitespace-nowrap">Campo</th>
              <th class="whitespace-nowrap">Dato</th>
            </tr>
          </thead>
          <tbody id="table-content">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="edit-user" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="p-5 font-medium text-base mr-auto">Editar información del usuario</h2>
        <div id="editable">
          <form id="SubmitForm">
            @csrf
            <!-- BEGIN: Input -->
            <div class="intro-y box">
              <div id="input" class="p-5">
                <div class="preview">
                  <div>
                    <label for="regular-form-1" class="form-label">DNI</label>
                    <input id="dni" name="dni" type="number" class="form-control" placeholder="DNI">
                  </div>
                  <div>
                    <label for="regular-form-1" class="form-label">Nombre completo</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Nombres">
                  </div>
                  <div class="mt-3">
                    <label>Género</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                      <div class="form-check mr-2">
                        <input id="male" class="form-check-input" type="radio" name="gender" value="m">
                        <label class="form-check-label" for="radio-switch-4">Masculino</label>
                      </div>
                      <div class="form-check mr-2 mt-2 sm:mt-0">
                        <input id="female" class="form-check-input" type="radio" name="gender" value="f">
                        <label class="form-check-label" for="radio-switch-5">Femenino</label>
                      </div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <label for="regular-form-1" class="form-label">Correo</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Correo">
                  </div>
                  <div class="mt-3">
                    <label for="regular-form-1" class="form-label">Territorial</label>
                    <input id="territorial" type="text" class="form-control" name="territorial"
                      placeholder="Territorial">
                  </div>
                  <div class="mt-3">
                    <label for="regular-form-1" class="form-label">SECI Coins</label>
                    <input id="secicoins" type="number" class="form-control" name="secicoins" placeholder="SECI Coins">
                  </div>
                  <div class="mt-3">
                    <label for="regular-form-4" class="form-label">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="mt-3">
                  <label>Rol del usuario</label>
                  <div class="mt-2">
                    <select data-placeholder="Seleccione un rol para el usuario" name="role_id" id="role_id"
                      class="tom-select w-full">
                      <option disabled>Seleccione un rol para el usuario</option>
                      @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mt-3">
                  <label>Delegación</label>
                  <div class="mt-2">
                    <select data-placeholder="Seleccione una delegación para el usuario" name="delegation_id"
                      id="delegation_id" class="tom-select w-full">
                      <option disabled>Seleccione una delegación para el usuario</option>
                      @foreach ($delegations as $delegation)
                      <option value="{{ $delegation->id }}">
                        {{ $delegation->code }} - {{ $delegation->name }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mt-3">
                  <label>Grupo del usuario</label>
                  <div class="mt-2">
                    <select data-placeholder="Seleccione un rol para el usuario" name="group_id" id="group_id"
                      class="tom-select w-full">
                      <option disabled>Seleccione un grupo para el usuario</option>
                      @foreach ($groups as $group)
                      <option value="{{ $group->id }}">{{ $group->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mt-3">
                  <label>Cuartil del usuario</label>
                  <div class="mt-2">
                    <select data-placeholder="Seleccione un rol para el usuario" name="quartile_id" id="quartile_id"
                      class="tom-select w-full">
                      <option disabled>Seleccione un cuartil para el usuario</option>
                      @foreach ($quartiles as $quartile)
                      <option value="{{ $quartile->id }}">{{ $quartile->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Actualizar
                    Usuario</button>
                </div>
              </div>
            </div>
            <!-- END: Input -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END: HTML Table Data -->
@endsection