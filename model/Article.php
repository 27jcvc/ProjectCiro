<?php
// Representa un artículo recuperado o creado por las operaciones del modelo.
class Article {
    // Identificador de base de datos y valores textuales del artículo.
    private $id;
    private $title;
    private $cos;
    private $preu;
    private $imatge;

    // Inicializa el objeto con el identificador, el título y el contenido recibidos.
    public function __construct($id, $title, $cos, $preu, $imatge){
        $this->id = $id;
        $this->title = $title;
        $this->cos = $cos;
        $this->preu = $preu;
        $this->imatge = $imatge;
    }

    // Devuelve el identificador del artículo como texto.
    public function id(): string{
        return $this->id;
    }

    // Devuelve el título del artículo.
    public function title(): string{
        return $this->title;
    }

    // Devuelve el contenido del artículo.
    public function cos(): string{
        return $this->cos;
    }

    public function preu(): float{
        return (float) $this->preu;
    }

    public function imatge(): ?string{
        return $this->imatge;
    }
}