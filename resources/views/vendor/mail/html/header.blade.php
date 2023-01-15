<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('img/logo.jpg') }}" class="logo" alt="El Corte Inglés Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
