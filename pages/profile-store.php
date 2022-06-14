<?php
    session_start();
    $sesion = isset($_SESSION["login"]);

    $conexion = mysqli_connect("localhost","root","","usuarios");
    mysqli_set_charset($conexion,"utf8");

    $infUsuario;

    if($sesion==1){
        //Hay sesión de usuario
        $correo = $_SESSION["login"];
        $sqlUsuario = "SELECT * FROM organizaciones WHERE CORREO_ELECTRONICO = '$correo'";
        $resUsuario = mysqli_query($conexion,$sqlUsuario);
        $infUsuario = mysqli_fetch_row($resUsuario);
        
        $tipoUsuario = $infUsuario[0];

        $trOrganizacionesCard = "";
        if($infUsuario[10] == NULL) $fila10 = "";
        else $fila10 = "($infUsuario[10])";
        $trOrganizacionesCard .= 
            "<h1 id='name'>$infUsuario[3]</h1>
            <h5 id='email'>$infUsuario[4]</h5>
            <h5 id='phone'>$infUsuario[9] $fila10</h5>
            ";
    }else{
        //No hay sesión de usuario
        header("location: ./login.html");
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helping Hands - Empresa</title>
    <link rel="icon" type="image/x-icon" href="./../rsc/favicon.ico">
    <!--CSS-->
    <link rel="stylesheet" href="./../css/index.css">
    <link rel="stylesheet" href="./../css/profile-store.css">
    <link href="./../js/plugins/validetta101/validetta.min.css" rel="stylesheet">
    <link href="./../js/plugins/confirm334/jquery-confirm.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--js-->
    <script src="./../js/jquery-3.6.0.min.js"></script>
    <script src="./../js/plugins/validetta101/validetta.min.js"></script>
    <script src="./../js/plugins/validetta101/validettaLang-es-ES.js"></script>
    <script src="./../js/plugins/confirm334/jquery-confirm.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="./../js/profile-store.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./../index.php">Helping <img src="./../rsc/logo.png" class="img-hm30"> Hands</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <form class="d-flex me-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Enlatados, líquidos, otros"
                        aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
                <ul class="navbar-nav me-left mb-2 mb-lg-0">
                    <?php if($sesion) echo "<li class='nav-item'>
                        <a class='nav-link text-light black-bold' href='./../pages/carrito.php'><i class='fa-solid fa-cart-shopping'></i> Carrito</a>
                    </li>";?>
                    <li class="nav-item">
                        <a class="nav-link text-dark grey-bold" href='<?php if($sesion) if($tipoUsuario ==0) echo "./profile-client.php"; else echo "./profile-store.php"; else echo "./login.html";?>'> <i
                                class="fa-solid fa-user"></i> <?php if($sesion) echo "Página de usuario"; else echo "Iniciar sesión";?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark grey-bold" href='<?php if($sesion) echo "./../pages/logout.php"; else echo "./../pages/registro.html";?>'> <?php if($sesion) echo "Cerrar sesión"; else echo "Registrarse";?></a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>


    <div class="container-fluid d-flex" id="main">

        <div class="panel-lateral mt-2 ">
        </div>

        <div class="panel-principal" style="padding-top: 15vh;">
            <!--Data User-->
            <div class="data-user  mb-5 d-flex">
                <img src="./../rsc/user-new.png" alt="profile-picture" class="rounded-circle bordes">
                <div class="data">
                    <?php echo $trOrganizacionesCard;?>
                    <a href="./pedidos.php">Ver pedidos</a>
                    <a id="editar" href="#info" data-bs-toggle="collapse">Editar Información</a>
                </div>
            </div>

            <div id="info" class="collapse mb-5">
                    <div class="datos-generales">

                        <div class="mb-3 mt-3">
                            <form id="formName" name="forName" class="d-flex">
                                <div class="op d-flex">
                                    <label class="">Nombre:</label>
                                    <input name="name" id="nombre" data-validetta="name" value='<?php echo $infUsuario[3];?>' disabled />
                                </div>
                                <div class="botones">
                                    <a class="btn brown cambiarName">Modificar</a>
                                    <button type="submit" name="btnUpdatePhone" id="btnUpdateName" class="btn btn-outline-success updatePhone" disabled>Actualizar</button>
                                </div>                      
                            </form>
                        </div>

                        <div class="mb-3 mt-3">
                            <form id="formPhone" name="formPhone" class="d-flex">
                                <div class="op">
                                    <label>Teléfono celular:</label>
                                    <input name="phone1" id="phone1" data-validetta="number" value='<?php echo $infUsuario[9];?>' disabled />
                                </div>
                                <div class="botones">
                                    <a class="btn brown cambiarPhone">Modificar</a>
                                    <button type="submit" name="btnUpdatePhone" id="btnUpdatePhone" class="btn btn-outline-success updatePhone" disabled>Actualizar</button>
                                </div>                            
                            </form>
                        </div>

                        <div class="mb-3 mt-3">
                            <form id="formEmail" name="formEmail" class="d-flex">
                               <div class="op">
                                    <label>Correo electronico:</label>
                                    <input name="correo" id="correo" data-validetta="email" value='<?php echo $infUsuario[4];?>' disabled />
                                </div>
                                <div class="botones">
                                    <a class="btn brown cambiarEmail">Modificar</a>
                                    <button type="submit" name="btnUpdateEmail" id="btnUpdateEmail" class="btn btn-outline-success" disabled>Actualizar</button>
                                </div>
                            </form>
                        </div>

                    </div>
            </div>

            <div class="dirrecion">
               
                    <h3>Dirección</h3>

                    <div class="mb-3 mt-3">
                        <form id="formStreet" name="formStreet" class="d-flex">
                           <div class="op">
                                <label>Calle:</label>
                                <input name="street" id="street" data-validetta="street"  class="w-75"value='<?php echo $infUsuario[8];?>' disabled />
                           </div>
                            <div class="botones">
                                <a class="btn brown cambiarCalle">Modificar</a>
                                <button type="t" name="btnUpdateStreet" id="btnUpdateStreet" class="btn btn-outline-success"                                     disabled>Actualizar</button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-3 mt-3" >
                        <form id="formAlcaldia" name="forAlcaldia" class="d-flex" >
                            <div class="op">
                                <label for="">Alcaldia:</label>
                                <select id="alcaldia"  disabled >
                                    <option value="Azcapotzalco">Azcapotzalco</option>
                                    <option value="Coyoacán">Coyoacán</option>
                                    <option value="Cuajimalpa de Morelos">Cuajimalpa</option>
                                    <option value="Gustavo A. Madero"> Gustavo A. Madero</option>
                                    <option value="Iztacalco">Iztacalco</option>
                                    <option value="Iztapalapa">Iztapalapa</option>
                                    <option value="La Magdalena Contreras">La Magdalena Contreras</option>
                                    <option value="Milpa Alta">Milpa Alta</option>
                                    <option value="Álvaro Obregón">Álvaro Obregón</option>
                                    <option value="Tláhuac">Tláhuac</option>
                                    <option value="Tlalpan">Tlalpan</option>
                                    <option value="Xochimilco">Xochimilco</option>
                                    <option value="Benito Juárez">Benito Juárez</option>
                                    <option value="Cuauhtémoc">Cuauhtémoc</option>
                                    <option value="">Miguel Hidalgo</option>
                                    <option value="">Venustiano Carranza</option>
                                </select>
                            </div>
                            <div class="botones">
                                <a class="btn brown cambiarAlcaldia ">Modificar</a>
                                <button type="submit" name="btnUpdateAlcaldia" id="btnUpdateAlcaldia" 
                                class="btn btn-outline-success" disabled>Actualizar</button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-3 mt-3">
                        <form id="formZipCode" name="forZip" class="d-flex">
                           <div class="op">
                                <label>Codigo Postal:</label>
                                <input name="ZipCode" id="zipCode"  data-validetta="zip" value='<?php echo $infUsuario[7];?>' disabled />
                           </div>
                           <div class="botones">
                                <a class="btn brown cambiarCodigo">Modificar</a>
                                <button type="submit" name="btnUpdateZipCode" id="btnUpdateZipCode" class="btn btn-outline-success " disabled>Actualizar</button>
                           </div>
                        </form>
                    </div>
            </div>

        </div>

    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>

</body>

</html>