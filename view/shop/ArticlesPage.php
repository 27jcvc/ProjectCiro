<?php

function renderArticleCard(Article $article): string
{
    $id = (int) $article->id();
    $titol = htmlspecialchars($article->title());
    $preu = number_format((float) $article->preu(), 2, ',', '.') . ' €';
    $imatge = htmlspecialchars($article->imatge() ?? '');

    return <<<HTML
            <section class="flex flex-col items-start group">
                <div class="w-full aspect-[16/10] bg-colorPrimary rounded-md overflow-hidden mb-3 relative shadow-sm">
                    <img src="{$imatge}"
                        alt="{$titol}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <button onclick="addToCart()" data-id="{$id}" class="bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText text-[11px] px-3 py-1 rounded-md mb-2 transition-colors cursor-pointer">
                    Afegir a la cesta
                </button>
                <h3 class="italic font-semibold text-lg md:text-xl text-colorTitol leading-snug">{$titol}</h3>
                <p class="text-colorSubtitul text-xs md:text-sm font-medium mt-1">{$preu}</p>
            </section>
    HTML;
}

function renderArticleSection(array $articles): void
{
    echo '<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">';

    foreach ($articles as $article) {
        // getArticles() devuelve objetos Article; getArticlesPaginados() devuelve arrays.
        if (is_array($article)) {
            $article = new Article(
                (int) ($article['id'] ?? 0),
                $article['titol'] ?? '',
                $article['cos'] ?? '',
                $article['preu'] ?? 0,
                $article['imatge'] ?? ''
            );
        }

        if ($article instanceof Article) {
            echo renderArticleCard($article);
        }
    }

    echo '</section>';
}

function imprimirPaginacionCompleta(int $articles_per_pagina, int $currentPage, int $nPages): void
{
    // Normalitza els valors per evitar estats incoherents.
    if ($articles_per_pagina < 1) {
        $articles_per_pagina = 5;
    }
    if ($nPages < 1) {
        $nPages = 1;
    }
    $currentPage = max(1, min($currentPage, $nPages));


    echo '<section class="mt-12 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs">';

    // 1. Selector de quantitat per pàgina (dins d'un formulari perquè submit funcioni).
    $classSelect = 'appearance-none bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText px-4 py-1.5 pr-8 rounded-md font-medium cursor-pointer focus:outline-none';
    echo '<form method="get" action="" class="relative m-0">';

    // Manté la resta de filtres de la URL (ordenació, cerca, etc.).
    foreach ($_GET as $clau => $valor) {
        if ($clau === 'p' || $clau === 'qt_pagines' || is_array($valor)) {
            continue;
        }
        echo '<input type="hidden" name="' . htmlspecialchars((string) $clau) . '" value="' . htmlspecialchars((string) $valor) . '">';
    }

    // En canviar la quantitat, es torna a la primera pàgina.
    echo '<input type="hidden" name="p" value="1">';
    echo '<select name="qt_pagines" id="qt_pagines_select" class="' . $classSelect . '" onchange="this.form.submit()">';

    // Opcions habituals i, si cal, el valor actual perquè quedi seleccionat.
    // TODO: Hacer que la qt de articulos por pagina no se definan individualmente
    $opcions = array_values(array_unique(array_merge([6, 12, 24], [$articles_per_pagina])));
    sort($opcions);
    foreach ($opcions as $cantidad) {
        $selected = ($cantidad === $articles_per_pagina) ? ' selected' : '';
        echo '<option value="' . $cantidad . '"' . $selected . '>' . $cantidad . '</option>';
    }

    echo '</select>';
    echo '<i class="fa-solid fa-chevron-down absolute right-2.5 top-2.5 text-colorBtnText text-[10px] pointer-events-none"></i>';
    echo '</form>';

    // 2. Controls de paginació.
    $classAnterior = 'bg-colorPrimary/10 text-colorPrimary hover:bg-colorPrimary-hover hover:text-colorBtnText border border-colorPrimary/30 px-3 py-1.5 rounded-md font-medium transition-colors flex items-center gap-1 cursor-pointer';
    $classSeguent = 'bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText px-3 py-1.5 rounded-md font-medium transition-colors flex items-center gap-1 cursor-pointer';
    $classNumber = 'w-7 h-7 bg-colorPrimary text-colorBtnText rounded-md flex items-center justify-center font-bold cursor-pointer';
    $classNumberInactiu = 'w-7 h-7 bg-colorPrimary/10 hover:bg-colorPrimary-hover text-colorPrimary border border-colorPrimary/30 hover:text-colorBtnText rounded-md flex items-center justify-center font-medium transition-colors cursor-pointer';

    echo '<nav class="flex flex-wrap items-center justify-center gap-1.5" aria-label="Paginació">';

    // Botó anterior (només si no estem a la primera pàgina).
    if ($currentPage > 1) {
        echo '<a class="' . $classAnterior . '" href="' . urlPaginacio(['p' => $currentPage - 1]) . '" rel="prev">';
        echo '<i class="fa-solid fa-arrow-left text-[10px]"></i> Anterior';
        echo '</a>';
    }

    // Mostra com a màxim 3 botons de pàgina, centrats en la pàgina actual.
    $inici = max(1, $currentPage - 1);
    $final = min($nPages, $inici + 2);
    $inici = max(1, $final - 2);

    for ($i = $inici; $i <= $final; $i++) {
        if ($i === $currentPage) {
            echo '<span class="' . $classNumber . '" aria-current="page">' . $i . '</span>';
        } else {
            echo '<a class="' . $classNumberInactiu . '" href="' . urlPaginacio(['p' => $i]) . '">' . $i . '</a>';
        }
    }

    // Botó següent (només si no estem a l'última pàgina).
    if ($currentPage < $nPages) {
        echo '<a class="' . $classSeguent . '" href="' . urlPaginacio(['p' => $currentPage + 1]) . '" rel="next">';
        echo 'Seguent <i class="fa-solid fa-arrow-right text-[10px]"></i>';
        echo '</a>';
    }

    echo '</nav>';
    echo '</section>';
}

// Conserva els paràmetres actuals de la URL i aplica els canvis indicats.
function urlPaginacio(array $canvis): string
{
    $params = $_GET;

    // Descarta valors buits o arrays per no generar enllaços incorrectes.
    foreach ($params as $clau => $valor) {
        if ($valor === '' || is_array($valor)) {
            unset($params[$clau]);
        }
    }

    $params = array_merge($params, $canvis);

    return '?' . http_build_query($params);
}