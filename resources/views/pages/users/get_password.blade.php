@extends('../layout/' . $layout)

@section('head')
    <title>Login - Icewall - Tailwind HTML Admin Template</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3">
                        Icewall
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Icewall Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">A few more clicks to <br> sign in to your account.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your e-commerce accounts in one place</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Introduce tu nueva contraseña</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                    <div class="intro-x mt-8">
                        <form id="login-form">
                            <input type="hidden" id="id" value="{{ $user[0]->id }}">
                            <div class="input-group mt-2">
                                <input id="password" type="password" class="intro-x login__input form-control" placeholder="" value="">
                                <div id="togglePassword" class="input-group-text cursor-pointer"><i class="open" data-feather="eye"></i><i class="closed" data-feather="eye-off"></i>
                                </div>
                            </div>
                            <div class="input-group mt-2">
                                <input id="password-check" type="password" class="intro-x login__input form-control" placeholder="" value="">
                                <div id="togglePassword-check" class="input-group-text cursor-pointer"><i class="open-check" id="open-check" data-feather="eye"></i><i class="closed-check" id="closed-check" data-feather="eye-off"></i>
                                </div>
                            </div>
                            <div id="error-password" class="login__input-error text-danger mt-2"></div>
                        </form>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left flex justify-center">
                        <button class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top" id="send">Enviar</button>
                    </div>
                    <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                        By signin up, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#send').on('click', function (e) {
                console.log("hola");
                e.preventDefault();
                console.log("hola")
    
                let data = {
                    id: $('#id').val(),
                    password: $('#password').val(),
                    password_check: $('#password-check').val()
                }
    
                // let id = $('#id').val();

    
                // let url = "{{ route('users.reset.password', ':id') }}";
                // url.replace(':id', id);
    
                $.ajax({
                    type: "PUT",
                    url: "{{ route('users.reset.password') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        console.log("🚀 ~ file: get_password.blade.php:39 ~ response", response);
                    }
                });
            });
        });
    </script>
@endsection