<?php


// Limpia espacios periféricos y requiere título y contenido para un artículo nuevo.
function validarDatosArticulo(string $titol, string $cos): array
{
    $titol = trim($titol);
    $cos = trim($cos);

    if ($titol === '' || $cos === '') {
        throw new InvalidArgumentException('Has d\'indicar un titol i un cos.');
    }

    return ['titol' => $titol, 'cos' => $cos];
}

function articleExistent(string $titol): bool
{
    return verifyTitol($titol);
}

// Valida el identificador y los campos editables recibidos para modificar un artículo.
function validarDatosModificacion(array $data): array
{
    // FILTER_VALIDATE_INT evita aceptar identificadores que no sean enteros válidos.
    $id = filter_var($data['id_modificar'] ?? '', FILTER_VALIDATE_INT);
    $titol = trim($data['titol_modificar'] ?? '');
    $cos = trim($data['cos_modificar'] ?? '');

    // Exige un ID positivo y valores no vacíos para ambos campos.
    if ($id === false || $id < 1 || $titol === '' || $cos === '') {
        throw new InvalidArgumentException('Indica un ID, un titol i un cos');
    }

    // Devuelve un conjunto normalizado de datos listo para pasarse al modelo.
    return [
        'id' => $id,
        'titol' => $titol,
        'cos' => $cos
    ];
}

// Valida el identificador positivo del artículo que se quiere eliminar.
function validarDatosEliminar(array $data): array
{
    $id = filter_var($data['id_esborrar'] ?? '', FILTER_VALIDATE_INT);

    // Un ID ausente, inválido o menor que uno no es válido para esta operación.
    if ($id === false || $id < 1 ) {
        throw new InvalidArgumentException('Has d\'indicar un id valid');
    }

    // Devuelve el ID validado en el formato esperado por el modelo.
    return [
        'id' => $id
    ];
}
