<?= 
    desarDades();
    comprovarDades();
?>

<!DOCTYPE html>
<html lang="ca" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciro - Joyería</title>

    <script src="./public/js/shop.js"></script>
    <link href="./public/src/output.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body class="bg-colorFons min-h-screen flex flex-col justify-between overflow-x-hidden">
    <!-- HEADER / NAVIGATION -->
    <header
        class="w-full px-6 py-6 md:px-12 flex justify-end items-center gap-4 md:gap-6 text-xs md:text-sm font-medium">
        <a href="index.html#chi-siamo" class="text-colorTitol hover:text-colorPrimary-hover transition-colors mr-2">
            Qui som?</a>

        <!-- Con clases nativas de Tailwind -->
        <a href="index.php?action=login"
            class="bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText px-4 py-2 rounded-md transition-all shadow-sm text-xs md:text-sm font-normal">
            Iniciar sessió
        </a>

        <a href="index.php?action=register"
            class="bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText px-4 py-2 rounded-md transition-all shadow-sm text-xs md:text-sm font-normal">
            Crear compte
        </a>

        <!-- Cart Icon with badge -->
        <div class="relative cursor-pointer ml-1 p-1 group" title="Carrito de compras">
            <i class="fa-solid fa-cart-shopping group-hover:text-colorPrimary transition-colors text-lg md:text-xl"></i>
            <span id="cart-badge"
                class="absolute -top-1 -right-2 bg-colorPrimary text-colorBtnText text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-colorBorder">
                0
            </span>
        </div>
    </header>

    <!-- MAIN CONTENT (CONTROLES Y TIENDA) -->
    <main class="flex-grow p-4 md:p-8 lg:p-10 max-w-6xl mx-auto w-full">

        <!-- BARRA DE FILTROS Y BÚSQUEDA -->
        <div class="flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center mb-8">

            <!-- Izquierda: Menú Hamburguesa + Buscador -->
            <div class="flex items-center gap-3">
                <button
                    class="bg-colorPrimary hover:bg-colorPrimary-hover text-colorBtnText w-9 h-9 rounded-full flex items-center justify-center transition-colors text-sm cursor-pointer"
                    aria-label="Filtros">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="relative flex-grow sm:flex-grow-0">
                    <input type="text" placeholder="Search"
                        class="bg-colorPrimary text-colorBtnText placeholder-colorBtnText/70 text-xs rounded-full px-4 py-2 pr-8 w-full sm:w-44 focus:outline-none focus:ring-1 focus:ring-colorPrimary ">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-2.5 text-colorBtnText/70 text-xs"></i>
                </div>
            </div>
            <!-- Derecha: Botones de ordenación (Checkboxes) -->
            <div class="flex flex-wrap items-center gap-2 text-xs">


                <!-- Opción: New -->
                <label class="cursor-pointer">
                    <input type="checkbox" name="sort" value="new" class="peer hidden" checked>

                    <span class="bg-colorPrimary/10 
                text-colorPrimary 
                hover:bg-colorPrimary-hover 
                hover:text-colorBtnText 
                peer-checked:bg-colorPrimary 
                peer-checked:text-colorBtnText px-3 py-1.5 
                rounded-md font-medium 
                transition-colors 
                inline-flex 
                items-center gap-1.5">
                        <!-- <i class="fa-solid fa-check text-[10px]"></i> -->
                        New
                    </span>
                </label>



                <!-- Opción: Preu ascendent -->
                <label class="cursor-pointer">
                    <input type="checkbox" name="sort" value="price-asc" class="peer hidden">
                    <span class=" bg-colorPrimary/10
                                    text-colorPrimary
                                    hover:bg-colorPrimary-hover
                                    hover:text-colorBtnText
                                    peer-checked:bg-colorPrimary 
                                    peer-checked:text-colorBtnText 
                                    px-3 
                                    py-1.5 
                                    rounded-md 
                                    font-medium 
                                    transition-colors">
                        Preu ascendent
                    </span>
                </label>

                <!-- Opción: Preu descendent -->
                <label class="cursor-pointer">
                    <input type="checkbox" name="sort" value="price-desc" class="peer hidden">
                    <span class=" bg-colorPrimary/10
                                    text-colorPrimary   
                                    hover:bg-colorPrimary-hover
                                    hover:text-colorBtnText
                                    peer-checked:bg-colorPrimary 
                                    peer-checked:text-colorBtnText 
                                    px-3 
                                    py-1.5 
                                    rounded-md 
                                    font-medium 
                                    transition-colors">
                        Preu descendent
                    </span>
                </label>

                <!-- Opción: Puntuació -->
                <label class="cursor-pointer">
                    <input type="checkbox" name="sort" value="rating" class="peer hidden" checked>
                    <span class="bg-colorPrimary/10
                                    text-colorPrimary
                                    hover:bg-colorPrimary-hover
                                    hover:text-colorBtnText
                                    peer-checked:bg-colorPrimary 
                                    peer-checked:text-colorBtnText 
                                    px-3 
                                    py-1.5 
                                    rounded-md 
                                    font-medium 
                                    transition-colors
                                    ">
                        Puntuació
                    </span>
                </label>
            </div>
        </div>
                <!-- CONTROLES DE PAGINACIÓN INFERIORES -->
                <?= carregarArticles(); ?>
    </main>

    <!-- FOOTER -->
    <footer class="w-full border-t border-colorBorderDark/50 mt-12 pt-12 pb-8 px-6 md:px-12">
        <div class="max-w-6xl mx-auto">

            <!-- 4 Column Footer Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-12 text-xs md:text-sm">

                <!-- Column 1: Atención al Cliente -->
                <div class="space-y-3">
                    <h3 class="font-medium text-sm md:text-base text-colorTitol mb-3">Atención al Cliente</h3>
                    <ul class="space-y-2 text-colorSubtitol text-xs">
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Preguntas Frecuentes
                                (FAQ)</a></li>
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Seguimiento de
                                pedidos</a>
                        </li>
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Política de devoluciones
                                y
                                reembolsos</a></li>
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Información de envíos y
                                tiempos de entrega</a></li>
                        <li class="pt-1"><a href="#"
                                class="hover:text-colorPrimary-hover transition-colors leading-relaxed block">Contacto:
                                Correo de soporte, teléfono o acceso directo a WhatsApp/Chat.</a></li>
                    </ul>
                </div>

                <!-- Column 2: Confianza y Seguridad -->
                <div class="space-y-3">
                    <h3 class="font-medium text-sm md:text-base text-colorTitol mb-3">Confianza y Seguridad</h3>
                    <ul class="space-y-2 text-colorSubtitol text-xs">
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Métodos de pago
                                aceptados</a></li>
                        <li><a href="#" class="hover:text-brand-burgundy transition-colors">Empresas de transporte</a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Información Legal y Corporativa -->
                <div class="space-y-3">
                    <h3 class="font-medium text-sm md:text-base text-colorTitol mb-3">Información Legal y Corporativa
                    </h3>
                    <ul class="space-y-2 text-colorSubtitol text-xs">
                        <li><a href="#" class="hover:text-brand-burgundy transition-colors">Términos y condiciones</a>
                        </li>
                        <li><a href="#" class="hover:text-brand-burgundy transition-colors">Política de privacidad y
                                Aviso legal</a></li>
                        <li><a href="#" class="hover:text-brand-burgundy transition-colors">Configuración / Política de
                                cookies</a></li>
                        <li><a href="#" class="hover:text-brand-burgundy transition-colors">Sobre nosotros / Nuestra
                                historia</a></li>
                    </ul>
                </div>

                <!-- Column 4: Navegación y Localización -->
                <div class="space-y-3">
                    <h3 class="font-medium text-sm md:text-base text-colorTitol mb-3">Navegación y Localización</h3>
                    <ul class="space-y-2 text-colorSubtitol text-xs">
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Selector de idioma y
                                moneda</a></li>
                        <li><a href="#" class="hover:text-colorPrimary-hover transition-colors">Buscador de tiendas
                                físicas</a></li>
                    </ul>
                </div>

            </div>

            <!-- Footer Bottom Line -->
            <div
                class="pt-6 border-t border-colorBorderDark/40 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-brand-muted">
                <div class="text-colorTitol">
                    © 2024 Ciro. Todos los derechos reservados.
                </div>

                <!-- Social Media Icons -->
                <div class="flex items-center space-x-4 text-base text-colorTitol">
                    <a href="#" class="hover:text-colorPrimary-hover transition-colors" aria-label="X / Twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" class="hover:text-colorPrimary-hover transition-colors" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="hover:text-colorPrimary-hover transition-colors" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#" class="hover:text-colorPrimary-hover transition-colors" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                </div>
            </div>

        </div>
    </footer>

</body>

</html>