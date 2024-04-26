<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
</head>
<body>
    <article class="articuloPetArticles w100">
        <div class="contenedor_texto">
            <p class="texto textoTitle txtCenter">
                Disponemos, de todo tipo de articulos para tu <span class="spanPetsArticle">mascota</span><br>
                Desde la más pequeña, hasta la más grande...
            </p>
        </div>
        <div class="thumbnail_articlesPets flex w100">
            <div class="contenedor_texto">
                <p class="texto textoTitleArticles txtCenter">Articulos <span class="spanTextoTitleArticles">Small Pets</span></p>
            </div>
        </div>
        <div>
            <?php
            /***
                1- Le asignamos a la variable $filename (el valor, con el mismo nombre que el archivo .json ('articlesSmallPets.json').
                2- Cargamos el contenido de la variable $filename a la variable '$json' a traves de la función 'file_get_contents()'.
                3- Convertimos el archivo '.json' en array php y se lo asignamos a la variable '$articlesSmallPet' (esta variable contiene el array convertido).
                4- Por último, con el bucle 'foreach', ya podemos recorrer el array que contiene todos los datos '.json' y mostrarlos.
            ***/
            $filename = "./assets/archivosJSON/articlesSmallPets.json";
            $json = file_get_contents($filename);
            $articlesSmallPets = json_decode($json, true);
            ?>
            <div class="container_cards">
                <div class="row flex">
                    <?php 
                        foreach ($articlesSmallPets as $value) {
                    ?>
                    <div class="col">
                        <div class="card" style="width: 18rem; height: 20rem;">
                            <img src="<?php echo $value["urlImg"] ?>" class="card-img-top imgJson" style="width: 18rem;" alt="imagenes de articlesSmallPets">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $value["titulo"] ?></h5>
                                <p class="card-text"><?php  echo $value["precio"] ?></p>
                                <div class="flex div_btnCarrito">
                                    <img src="./assets/icons/shopping-cart.png" alt="icono_carrito" class="icon" width="20" heigth="20">
                                    <button type="button" name="btnAñadir" value="" class="btnAñadir">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                    <?php
                        }         
                    ?>
                </div>
            </div>
        </div>
    </article>
    
    <!-- script bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>