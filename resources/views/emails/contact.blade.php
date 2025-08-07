<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 5px;
        }
        h1 {
            color: #e53e3e;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .message-info {
            margin-bottom: 20px;
        }
        .message-body {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nuevo mensaje de contacto</h1>
        
        <div class="message-info">
            <p><strong>Nombre:</strong> {{ $contactData['name'] }}</p>
            <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
            <p><strong>Asunto:</strong> {{ $contactData['subject'] }}</p>
        </div>
        
        <div class="message-body">
            <p><strong>Mensaje:</strong></p>
            <p>{{ $contactData['message'] }}</p>
        </div>
        
        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de PizzaPlace.</p>
        </div>
    </div>
</body>
</html>