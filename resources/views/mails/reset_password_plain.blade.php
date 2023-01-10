<p>Hola {{ $email->name }} por favor ingresa al siguiente enlace para cambiar tu contraseña:</p>
<a href="{{ route('users.reset.password', $email->id) }}">Cambiar Contraseña</a>