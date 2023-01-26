@extends('../layout/' . $layout)

@section('head')
    <title>Cambio de contraseña</title>
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
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Ingresa tu email</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                    <div class="intro-x mt-8">
                        <form id="login-form">
                            <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 block mb-2" placeholder="Email" value="midone@left4code.com">
                            <p id="error-text" class="text-red-700"></p>
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
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
    <script>
       $(document).ready(function () {
            $('#send').on('click', function (e) {
                e.preventDefault();


                let data = {
                    email: $('#email').val(),
                    origin: window.location.hostname + '/nueva-contraseña'
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('users.password') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        // console.log("🚀 ~ file:x get_email.blade.php:87 ~ response", response)
                        if(response.status === 400) {
                            $('#email').css('border-color', '#B91C1C');
                            $.each(response.errors, function (key, error) { 
                                 $('#error-text').text(error[0]);
                            });
                        } else {
                            swal.fire({
                                title: "Excelente!",
                                text: response.message,
                                type: "success"
                            }).then(function() {
                                window.location = "{{ route('login.index') }}";
                            });
                            $('#email').css('border-color', '#E2E8F0');
                            $('#error-text').text("");
                        }
                    }
                });
            });
       });
    </script>
@endsection
