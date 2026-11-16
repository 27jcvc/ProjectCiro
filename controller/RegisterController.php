<?php

require_once(__DIR__ . '/../model/Model.php');
require_once(__DIR__ . '/../view/shop/ArticlesPage.php');
// Carga las vistas y las funciones de presentación utilizadas por el controlador.
require_once(__DIR__ . '/FuncionsController.php'); // Opcional, pero recomendado con __DIR__ si está en la misma carpeta
require_once(__DIR__ . '/../view/Utils.php');
require_once(__DIR__ . '/../view/register/RegisterView.php');


// Procesa la acción enviada por el formulario en cada petición.
function main(): void
{
    try {
        $mensaje = '';

    } catch (Throwable $e) {
        $mensaje = $e->getMessage();
    }

    mostrarMensaje($mensaje);
}

    // $userid = getSessionUserId();
    // setcookie('', $userid);
    // $userId = getSessionUserId();
function getSessionUserId(){
    return session_id();
}