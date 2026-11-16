<?php

require_once(__DIR__ . '/../model/Model.php');
require_once(__DIR__ . '/../view/shop/ArticlesPage.php');
// Carga las vistas y las funciones de presentación utilizadas por el controlador.
require_once(__DIR__ . '/FuncionsController.php'); // Opcional, pero recomendado con __DIR__ si está en la misma carpeta
require_once(__DIR__ . '/../view/Utils.php');
require_once(__DIR__ . '/../view/shop/ShopView.php');


// Procesa la acción enviada por el formulario en cada petición.
function main(): void
{
    global $aPerPagina;
    
    // 2. Calcular el total de páginas
    $total_articulos = getTotalArticles(); // Función que devuelve un SELECT COUNT(*)
    $total_paginas = ceil($total_articulos / $aPerPagina);
    if ($total_paginas < 1) $total_paginas = 1;
    
    $paginaActual = isset($_GET['p']) ? intval($_GET['p']) : 1;

    if ($paginaActual > $total_paginas || $paginaActual < 1) {
        header('Location: .');
        exit();
    };

    if ($paginaActual < 1) $paginaActual = 1;
    if ($paginaActual > $total_paginas) $paginaActual = $total_paginas;

    // 4. Calcular el OFFSET (desde dónde empieza a buscar en la BD)
    $offset = ($paginaActual - 1) * $aPerPagina;

    try {
        $mensaje = '';

        // Cargar únicamente los artículos correspondientes a esta página (evita duplicados)
        $articulosPagina = getArticlesPaginados($aPerPagina, $offset);

        // Mostrar la tabla y la paginación pasándole la página actual
        // mostrarTaulaArticles($articulosPagina);
        renderArticleSection($articulosPagina);
        
        // require
        imprimirPaginacionCompleta($aPerPagina, $paginaActual, $total_paginas);

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