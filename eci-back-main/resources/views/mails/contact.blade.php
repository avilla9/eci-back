Hola,
<p>Este es un mensaje enviado desde la app</p>

<div>
  <p><b>DNI: </b>&nbsp;{{ $email->dni }}</p>
  <p><b>Nombre: </b>&nbsp;{{ $email->name }}</p>
  <p><b>Correo: </b>&nbsp;{{ $email->email }}</p>
  <p><b>Código de agente: </b>&nbsp;{{ $email->agent_code }}</p>

  <p><b>Tipo de mensaje: </b>&nbsp;{{ $email->type }}</p>
  <p><b>Mensaje: </b>&nbsp;{{ $email->message }}</p>
</div>