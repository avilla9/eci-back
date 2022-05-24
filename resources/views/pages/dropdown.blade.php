@extends('../layout/' . $layout)

@section('subhead')
    <title>Dropdown - Icewall - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Dropdown</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Basic Dropdown -->
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Basic Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-1">Show example code</label>
                        <input id="show-example-1" data-target="#basic-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="basic-dropdown" class="p-5">
                    <div class="preview">
                        <div class="flex justify-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-basic-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-basic-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="" class="dropdown-item">New Dropdown</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">Delete Dropdown</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Header & Footer Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-2">Show example code</label>
                        <input id="show-example-2" data-target="#header-footer-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="header-footer-dropdown" class="p-5">
                    <div class="preview">
                        <div class="flex justify-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                <div class="dropdown-menu w-56">
                                    <ul class="dropdown-content">
                                        <li>
                                            <h6 class="dropdown-header">Export Options</h6>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="activity" class="w-4 h-4 mr-2"></i> English
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="box" class="w-4 h-4 mr-2"></i>
                                                Indonesia
                                                <div class="text-xs text-white px-1 rounded-full bg-danger ml-auto">10</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="layout" class="w-4 h-4 mr-2"></i> English
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="sidebar" class="w-4 h-4 mr-2"></i> Indonesia
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <div class="flex p-1">
                                                <button type="button" class="btn btn-primary py-1 px-2">Settings</button>
                                                <button type="button" class="btn btn-secondary py-1 px-2 ml-auto">View Profile</button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-header-footer-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-header-footer-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false">Show Dropdown</button>
                                            <div class="dropdown-menu w-56">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <h6 class="dropdown-header">Export Options</h6>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="activity" class="w-4 h-4 mr-2"></i> English
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="box" class="w-4 h-4 mr-2"></i>
                                                            Indonesia
                                                            <div class="text-xs text-white px-1 rounded-full bg-danger ml-auto">10</div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="layout" class="w-4 h-4 mr-2"></i> English
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="sidebar" class="w-4 h-4 mr-2"></i> Indonesia
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <div class="flex p-1">
                                                            <button type="button" class="btn btn-primary py-1 px-2">Settings</button>
                                                            <button type="button" class="btn btn-secondary py-1 px-2 ml-auto">View Profile</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Icon Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-3">Show example code</label>
                        <input id="show-example-3" data-target="#icon-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="icon-dropdown" class="p-5">
                    <div class="preview">
                        <div class="flex justify-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                <div class="dropdown-menu w-48">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> New Dropdown
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Dropdown
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-icon-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-icon-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                            <div class="dropdown-menu w-48">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> New Dropdown
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete Dropdown
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Programmatically Show/Hide Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-4">Show example code</label>
                        <input id="show-example-4" data-target="#programmatically-show-hide-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="programmatically-show-hide-dropdown" class="p-5">
                    <div class="preview">
                        <div class="text-center">
                            <!-- BEGIN: Show Modal Toggle -->
                            <button id="programmatically-show-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Show</button>
                            <!-- END: Show Modal Toggle -->
                            <!-- BEGIN: Hide Modal Toggle -->
                            <button id="programmatically-hide-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Hide</button>
                            <!-- END: Hide Modal Toggle -->
                            <!-- BEGIN: Toggle Modal Toggle -->
                            <button id="programmatically-toggle-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Toggle</button>
                            <!-- END: Toggle Modal Toggle -->
                            <!-- BEGIN: Dropdown Content -->
                            <div id="programmatically-dropdown" class="dropdown inline-block">
                                <button class="dropdown-toggle btn btn-primary w-40 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Example Dropdown</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END: Dropdown Content -->
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-programmatically-show-hide-dropdown-html" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-programmatically-show-hide-dropdown-html" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <!-- BEGIN: Show Modal Toggle -->
                                        <button id="programmatically-show-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Show</button>
                                        <!-- END: Show Modal Toggle -->
                                        <!-- BEGIN: Hide Modal Toggle -->
                                        <button id="programmatically-hide-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Hide</button>
                                        <!-- END: Hide Modal Toggle -->
                                        <!-- BEGIN: Toggle Modal Toggle -->
                                        <button id="programmatically-toggle-dropdown" class="btn btn-primary w-40 mr-1 mb-2">Toggle</button>
                                        <!-- END: Toggle Modal Toggle -->
                                        <!-- BEGIN: Dropdown Content -->
                                        <div class="dropdown inline-block">
                                            <button class="dropdown-toggle btn btn-primary w-40 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown" id="programmatically-dropdown">Example Dropdown</button>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="" class="dropdown-item">New Dropdown</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">Delete Dropdown</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- END: Dropdown Content -->
                                    ') }}
                                </code>
                            </pre>
                        </div>
                        <button data-target="#copy-programmatically-show-hide-dropdown-js" class="copy-code btn py-1 px-2 btn-outline-secondary mt-5">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-programmatically-show-hide-dropdown-js" class="source-preview">
                                <code class="javascript text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        // Show dropdown
                                        const el = document.querySelector("#programmatically-dropdown");
                                        const dropdown = tailwind.Dropdown.getOrCreateInstance(el);
                                        dropdown.show();

                                        // Hide dropdown
                                        const el = document.querySelector("#programmatically-dropdown");
                                        const dropdown = tailwind.Dropdown.getOrCreateInstance(el);
                                        dropdown.hide();

                                        // Toggle dropdown
                                        const el = document.querySelector("#programmatically-dropdown");
                                        const dropdown = tailwind.Dropdown.getOrCreateInstance(el);
                                        dropdown.toggle();
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Dropdown with close button</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-5">Show example code</label>
                        <input id="show-example-5" data-target="#button-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="button-dropdown" class="p-5">
                    <div class="preview">
                        <div class="text-center">
                            <div class="dropdown inline-block" data-tw-placement="bottom-start">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                                    Filter Dropdown <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="dropdown-content">
                                        <div class="p-2">
                                            <div>
                                                <div class="text-xs">From</div>
                                                <input type="text" class="form-control mt-2 flex-1" placeholder="example@gmail.com"/>
                                            </div>
                                            <div class="mt-3">
                                                <div class="text-xs">To</div>
                                                <input type="text" class="form-control mt-2 flex-1" placeholder="example@gmail.com"/>
                                            </div>
                                            <div class="flex items-center mt-3">
                                                <button data-dismiss="dropdown" class="btn btn-secondary w-32 ml-auto">Close</button>
                                                <button class="btn btn-primary w-32 ml-2">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-button-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-button-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="text-center">
                                            <div class="dropdown inline-block" data-tw-placement="bottom-start">
                                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                                                    Filter Dropdown <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-content">
                                                        <div class="p-2">
                                                            <div>
                                                                <div class="text-xs">From</div>
                                                                <input type="text" class="form-control mt-2 flex-1" placeholder="example@gmail.com"/>
                                                            </div>
                                                            <div class="mt-3">
                                                                <div class="text-xs">To</div>
                                                                <input type="text" class="form-control mt-2 flex-1" placeholder="example@gmail.com"/>
                                                            </div>
                                                            <div class="flex items-center mt-3">
                                                                <button data-dismiss="dropdown" class="btn btn-secondary w-32 ml-auto">Close</button>
                                                                <button class="btn btn-primary w-32 ml-2">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Basic Dropdown -->
        <!-- BEGIN: Header & Footer Dropdown -->
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Scrolled Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-6">Show example code</label>
                        <input id="show-example-6" data-target="#scrolled-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="scrolled-dropdown" class="p-5">
                    <div class="preview">
                        <div class="flex justify-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content overflow-y-auto h-32">
                                        <li>
                                            <a href="" class="dropdown-item">January</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">February</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">March</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">June</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">July</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-scrolled-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-scrolled-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content overflow-y-auto h-32">
                                                    <li>
                                                        <a href="" class="dropdown-item">January</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">February</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">March</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">June</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">July</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Header & Icon Dropdown</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-7">Show example code</label>
                        <input id="show-example-7" data-target="#header-icon-dropdown" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="header-icon-dropdown" class="p-5">
                    <div class="preview">
                        <div class="flex justify-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <div class="dropdown-header">Export Tools</div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="external-link" class="w-4 h-4 mr-2"></i> Excel
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> CSV
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">
                                                <i data-feather="archive" class="w-4 h-4 mr-2"></i> PDF
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-header-icon-dropdown" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-header-icon-dropdown" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Show Dropdown</button>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <div class="dropdown-header">Export Tools</div>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="external-link" class="w-4 h-4 mr-2"></i> Excel
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="file-text" class="w-4 h-4 mr-2"></i> CSV
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item">
                                                            <i data-feather="archive" class="w-4 h-4 mr-2"></i> PDF
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Dropdown Placement</h2>
                    <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-8">Show example code</label>
                        <input id="show-example-8" data-target="#dropdown-placement" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div>
                </div>
                <div id="dropdown-placement" class="p-5">
                    <div class="preview">
                        <div class="text-center">
                            <div class="dropdown inline-block" data-tw-placement="top-start">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top Start</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="top">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="top-end">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top End</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="right-start">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right Start</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="right">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="right-end">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right End</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="bottom-end">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom End</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="bottom">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="dropdown inline-block"
                                data-tw-placement="bottom-start"
                                >
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom Start</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="left-start">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left Start</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="left">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown inline-block" data-tw-placement="left-end">
                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left End</button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item">New Dropdown</a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source-code hidden">
                        <button data-target="#copy-dropdown-placement" class="copy-code btn py-1 px-2 btn-outline-secondary">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                        </button>
                        <div class="overflow-y-auto mt-3 rounded-md">
                            <pre id="copy-dropdown-placement" class="source-preview">
                                <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10">
                                    {{ \Hp::formatCode('
                                        <div class="text-center">
                                            <div class="dropdown inline-block" data-tw-placement="top-start">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top Start</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="top">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="top-end">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Top End</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="right-start">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right Start</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="right">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="right-end">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Right End</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="bottom-end">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom End</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="bottom">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div
                                                class="dropdown inline-block"
                                                data-tw-placement="bottom-start"
                                                >
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Bottom Start</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="left-start">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left Start</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="left">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown inline-block" data-tw-placement="left-end">
                                                <button class="dropdown-toggle btn btn-primary w-32 mr-1 mb-2" aria-expanded="false" data-tw-toggle="dropdown">Left End</button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item">New Dropdown</a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item">Delete Dropdown</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    ') }}
                                </code>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Header & Footer Dropdown -->
    </div>
@endsection
