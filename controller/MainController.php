<?php

// Carga la conexión PDO y las operaciones de acceso al modelo de artículos.
require_once(__DIR__ . '/../config/Database.php');
Database::inicialize();

require_once(__DIR__ . '/../model/Model.php');
require_once(__DIR__ . '/../view/shop/ArticlesPage.php');
// Carga las vistas y las funciones de presentación utilizadas por el controlador.


$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'shop':
        require __DIR__ . '/ShopController.php';
        break;
    case 'register':
        require __DIR__ . '/RegisterController.php';
        break;
    case 'login':
        require __DIR__ . '/LoginController.php';
        break;
    default:
        require __DIR__ . '/../view/main/index.php';
        break;
}