<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get Password</title>
</head>
<body>
    <form action="">
        <input type="hidden" id="id" class="id-password" value="{{ $user[0]->id }}">
        <input type="password" id="password" class="password"> 
    </form>
    <button id="send">Enviar</button>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>    <script>
        $(document).ready(function () {
            $('#send').on('click', function (e) {
                console.log("hola");
                e.preventDefault();

                let data = {
                    id: $('#id').val(),
                    password: $('#password').val()
                }

                let id = $('#id').val();

                let url = "{{ route('users.reset.password', ':id') }}";
                url.replace(':id', id);

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
</body>
</html>