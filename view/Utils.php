<?php

// Convierte el mensaje en texto HTML seguro para evitar interpretar etiquetas recibidas.
function mostrarMensaje(string $mensaje): void
{
    echo '<p>' . htmlspecialchars($mensaje) . '</p>';
}