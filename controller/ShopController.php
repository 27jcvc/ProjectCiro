<?php

require_once(__DIR__ . '/../model/Model.php');
require_once(__DIR__ . '/../view/shop/ArticlesPage.php');
// Carga las vistas y las funciones de presentación utilizadas por el controlador.
require_once(__DIR__ . '/FuncionsController.php'); // Opcional, pero recomendado con __DIR__ si está en la misma carpeta
require_once(__DIR__ . '/../view/Utils.php');
require_once(__DIR__ . '/../view/shop/ShopView.php');


// Procesa la acción enviada por el formulario en cada petición.
function carregarArticles(): void
{
    global $aPerPagina;
    $optArticles = [6, 12, 24]; // Llistat de opcions que tindra l'usuari per seleccionar
    
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
        imprimirPaginacionCompleta($aPerPagina, $paginaActual, $total_paginas, $optArticles);

    } catch (Throwable $e) {
        $mensaje = $e->getMessage();
    }

    mostrarMensaje($mensaje);
}


function desarDades(){
    global $aPerPagina;
    $aPerPagina = comprovarDades();
}

function getSessionUserId(){
    return session_id();
}


function desarSessio() : void{
    if (isset($_COOKIE['sessio'])) {
        $userid = getSessionUserId();
        setcookie('sessio', $userid);
    }
}

function comprovarDades() : int {
    $articles = 0;
    $minArticles = 6;
    $maxArticles = 24;

    // TODO: Cambiar QT_PAGINES por QT_ARTICLES que seria lo mas correcto...
    if (isset($_GET['qt_pagines']) && ($_GET['qt_pagines'] < $minArticles || $_GET['qt_pagines'] > $maxArticles)) {
        header('Location: .');
        exit();
    };

    // 1. Prioritat: Si l'usuari ha seleccionat un nombre per URL, l'agafem i actualitzem la cookie
    if (isset($_GET['qt_pagines'])) {
        $articles = intval($_GET['qt_pagines']);
        setcookie('paginacio', $articles);
        return $articles;
    }
    // 2. Segona opció: Si no ve per URL, però la galeta ja existeix prèviament
    elseif (isset($_COOKIE['paginacio'])) {
        $articles = intval($_COOKIE['paginacio']);
        return $articles;
    }
    // 3. Valor per defecte si no hi ha ni URL ni galeta
        return $articles = $minArticles;
}