<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validar Cuenta</title>
    <link rel="stylesheet" href="./../../css/app.css">
</head>
<body>
    <h1>Validar Correo Electrónico</h1>
    <p>Por favor, haz clic en el siguiente enlace para verificar tu correo electrónico:</p>
    <a href="{{ env('APP_FRONTEND_URL') }}/verificar-email/{{ $token }}" style="display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 16px; color: white; background-color: #28a745; text-decoration: none;">Verificar Email</a>
    
</body>
</html>
