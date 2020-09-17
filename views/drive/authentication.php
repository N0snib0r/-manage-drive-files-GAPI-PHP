<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>

<body>
    <?php require 'views/header.php'; ?>
    
    <div class="text-center pr-3 my-3 w-50 bg-dark mx-auto text-white rounded-lg p-3">
        <span class="font-weight-light">Primero debes</span>
        <a class="btn btn-outline-danger btn-sm mb-1 border-0" href="<?php echo $this->authUrl; ?>">Iniciar Sesión</a>
        <span class="font-weight-light">y conceder los permisos necesarios.</span>
    </div>

    <?php require 'views/footer.php'; ?>
</body>
</html>