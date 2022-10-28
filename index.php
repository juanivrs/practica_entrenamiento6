<?php
    function printForm($nombre,$apellidos,$edad,$altura,$arrayvalidado):void
    {
        echo <<<END
            <form action="#" method="post">
                <p>
                    Nombre: <input type="text" name="nombre" id="nombre" value="$nombre">
                </p>   
        END;
        if ( $arrayvalidado !=null){
         echo $arrayvalidado['nombre'] === false ? "Dato Introducido incorrectamente" : ""; 
        }     
        echo <<<END
                <p>
                    Apellidos: <input type="text" name="apellidos" id="apellidos" value="$apellidos">
                </p>
        END;
        if ( $arrayvalidado !=null){
        echo $arrayvalidado['apellidos'] === false ? "Dato Introducido incorrectamente" : "";
        }      
        echo <<<END
                <p>
                    Edad: <input type="text" name="edad" id="edad" value="$edad">
                </p>
        END;
        if ( $arrayvalidado !=null){
        echo $arrayvalidado['edad'] === false ? "Dato Introducido incorrectamente" : ""; 
        }     
        echo <<<END
                <p>
                    Altura: <input type="text" name="altura" id="altura" value="$altura">
                </p>
        END;
        if ( $arrayvalidado !=null){
        echo $arrayvalidado['altura'] === false ? "Dato Introducido incorrectamente" : ""; 
        }     
        echo <<<END
                <p>
                    <input type="submit" value="Enviar">
                </p>
            </form>
        END;
    }

    function nameValidator($nombre){
       $pingamateo = explode(" ",$nombre);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        if (!$_POST){
            printForm("","","","",[]);
        }else{
            $nombreSaneado = htmlentities(trim($_POST["nombre"]));
            $apellidosSaneado = htmlentities(trim($_POST["apellidos"])) ;
            $edadSaneado = htmlentities(trim($_POST["edad"]));
            $alturaSaneado = htmlentities(trim($_POST["altura"]));

            $datos = [
                'nombre' => $nombreSaneado,
                'apellidos' => $apellidosSaneado,
                'edad' => $edadSaneado,
                'altura' => $alturaSaneado,
            ];

            $argumentos= array(
                'nombre' => array(
                   /* 'filter' => FILTER_CALLBACK,
                    'options' => 'nameValidator', */
                ),
                'apellidos' => array(
                   /*  'filter' => FILTER_CALLBACK,
                    'options' => 'nameValidator', */
                 ),
                'edad' => array(
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => array(
                        'min_range' => 0,
                    )
                ),
                'altura' => array(
                    'filter' => FILTER_VALIDATE_FLOAT,
                    'options' => array(
                        'min_range' => 0.5,
                        'max_range' => 2.5,
                    )
                ),
             );

             $validaciones= filter_var_array($datos,$argumentos);
             print_r($validaciones);
             if (!in_array(false,$validaciones)){
                echo <<<END
                <p>Tu nombre es : {$validaciones['nombre']}</p>
                <p>Tus apellidos es : {$validaciones['apellidos']}</p>
                <p>Tu edad es : {$validaciones['edad']}</p>
                <p>Tu altura es : {$validaciones['altura']}</p>
                END;
             }else {
                $nombreValidado = $validaciones['nombre'] != false ? $validaciones['nombre'] : $nombreSaneado;
                $apellidosValidado = $validaciones['apellidos'] != false ? $validaciones['apellidos'] : $apellidosSaneado;
                $edadValidado = $validaciones['edad'] != false ? $validaciones['edad'] : $edadSaneado;
                $alturaValidado = $validaciones['altura'] != false ? $validaciones['altura'] : $alturaSaneado;

                printForm($nombreValidado,$apellidosValidado,$edadValidado,$alturaValidado,$validaciones);
             }


        }
    ?>
</body>
</html>