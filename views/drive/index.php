<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body class="bg-light">
    
    <?php require 'views/header.php'; ?>

    <div class="container py-3">

        <div class="w-70">
            <nav class="navbar navbar-dark bg-dark rounded-top">
                <ul class="navbar-nav">                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mi drive
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo constant('URL') ?>drive/newFolder">Nueva Carpeta</a>
                            <a class="dropdown-item" href="<?php echo constant('URL') ?>upload">Subir Archivo</a>
                            <div class="dropdown-divider"></div>
                            <!-- <a class="dropdown-item" href="#">Something else here</a> -->
                        </div>
                    </li>
                </ul>
            </nav>

            <table class="table">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col" colspan="2">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Peso</th>
                        <!-- <th scope="col">Id</th> -->
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-alumnos" class="text-center">

                    <?php
                        foreach($this->files as $key => $row) {
                            $file = $row;
                    ?>
                    <tr id="fila-<?php echo $file->name; ?>">
                        <td class="align-middle" scope="row"><?php echo $key+1 ?></td>
                        <td class="align-middle"><span><img src="<?php echo $file->iconLink; ?>" alt=""></span></td>
                        <td class="align-middle text-left text-truncate" title="<?php echo $file->name ?>" style="max-width: 300px;"><?php echo $file->name ?></td>
                        <td class="align-middle"><?php echo $file->type ?></td>
                        <td class="align-middle"><?php echo ($file->mime=="application/vnd.google-apps.folder") ? "" : $file->size . " KB";?></td>
                        <!-- <td><?php //echo $file->id ?></td> -->
                        
                        <td class="navbar">
                            <li class="btn-group ml-auto mr-3">
                                <!-- Verifica si es archivo o carpeta -->
                                <?php if($file->mime=="application/vnd.google-apps.folder") { ?>
                                    <a href="<?php echo constant('URL').'drive/openFolder/'.$file->id; ?>" class="btn btn-outline-secondary btn-sm">Abrir</a>
                                <?php } else { ?>
                                    <a href="<?php echo $file->viewLink ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Ver</a>
                                <?php } ?>

                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only"></span>
                                </button>
                                <div class="dropdown-menu">
                                <?php if($file->mime!="application/vnd.google-apps.folder") { ?>
                                    <a class="dropdown-item" href="<?php echo $file->contentLink; ?>">Descargar</a>
                                <?php } ?>
                                    <a class="dropdown-item" href="<?php echo constant('URL').'drive/seeFile/'.$file->id; ?>">Renombrar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo constant('URL').'drive/deleteFile/'.$file->id; ?>">Eliminar</a>
                                </div>
                            </li>
                        </td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
            
            <div class="center"><?php echo $this->mensaje; ?></div>
            
        </div>
        <?php
            //TEST | Ver el objeto de cada archivo
            // echo '<pre>';
            // print_r($this->files);
            // echo '</pre>';
        ?>
        
    </div>

    <?php require 'views/footer.php'; ?>

</body>
</html>