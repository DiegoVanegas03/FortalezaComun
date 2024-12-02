<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación para Contestar un Formulario</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #007bff;">¡Invitación para Contestar un Formulario!</h2>

        <p>Hola {{ $nombreCompleto }},</p>

        <p>Te invitamos a completar un nuevo formulario titulado <strong>{{ $formName }}</strong>.</p>

        <p><em>{{ $formDescription }}</em></p>

        <p>Haz clic en el siguiente enlace para acceder al formulario y completarlo:</p>

        <p style="text-align: center;">
            <a href="{{ $formUrl }}"
                style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Acceder
                al Formulario</a>
        </p>

        <p>¡Gracias por tu participación!</p>

        <footer style="text-align: center; font-size: 12px; color: #777;">
            <p>&copy; {{ date('Y') }} Nuestra Empresa. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>
