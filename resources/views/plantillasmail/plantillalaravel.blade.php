@component('mail::message')
    # Formulario de Contacto
    ## Enviado por:
    {{$nombre}}
    ## Email del remitente:
    _{{$email}}_ 
    ## Mensaje:
    > {{$contenido}}
@endcomponent