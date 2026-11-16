<?php

// Incluye la clase utilizada para representar cada fila de artículos.
include_once('Article.php');

// Inserta un artículo nuevo mediante una consulta preparada.
function addArticle($titol, $cos)
{
   // Obtiene una conexión y detiene la operación si no está disponible.
   $connexio = Database::getConnection();

   if ($connexio === null) {
      return false;
   }

   // Usa parámetros enlazados para separar los datos del texto SQL.
   $stmt = $connexio->prepare(
      'INSERT INTO articles (titol, cos) VALUES (:titol, :cos)'
   );

   // Ejecuta la inserción con los valores proporcionados.
   $resultat = $stmt->execute([
      'titol' => $titol,
      'cos' => $cos
   ]);

   // Libera la conexión y devuelve el resultado de la ejecución.
   Database::close($connexio);

   return $resultat;
}

// Elimina un artículo existente después de validar su identificador.
function deleteArticleById($id)
{
   // Rechaza identificadores vacíos o que no correspondan a un artículo existente.
   if ($id == null || !verifyId($id)) {
      throw new Exception('Article inexistent');
   }

   // Abre la conexión necesaria para ejecutar el borrado.
   $connexio = Database::getConnection();

   if ($connexio === null) {
      return false;
   }

   // Prepara y ejecuta el borrado restringido al ID validado.
   $stmt = $connexio->prepare('DELETE FROM articles WHERE id = :id');
   $executat = $stmt->execute(['id' => $id]);

   // Si la consulta falla, informa del resultado sin continuar como éxito.
   if (!$executat) {
      return false;
   }

   // Libera la conexión y confirma que la operación terminó.
   Database::close($connexio);

   return true;
}

// Comprueba en la base de datos si existe una fila con el identificador dado.
function verifyId($id)
{
   // Si no se puede conectar, no es posible confirmar la existencia del artículo.
   $connexio = Database::getConnection();

   if ($connexio === null) {
      return false;
   }

   // La consulta preparada busca únicamente el ID proporcionado.
   $stmt = $connexio->prepare(
      'SELECT id FROM articles WHERE id = :id'
   );
   $stmt->execute(['id' => $id]);
   // fetchColumn devuelve false cuando la consulta no encuentra una fila.
   $existeix = $stmt->fetchColumn() !== false;

   // Libera la conexión antes de devolver el resultado de la comprobación.
   Database::close($connexio);

   return $existeix;
}

// Comprueba en la base de datos si existe una fila con el título dado.
function verifyTitol($title)
{
   // Si no se puede conectar, no es posible confirmar la existencia del artículo.
   $connexio = Database::getConnection();

   if ($connexio === null) {
      return false;
   }

   // La consulta preparada busca únicamente el título proporcionado.
   $stmt = $connexio->prepare(
      'SELECT id FROM articles WHERE titol = :titol'
   );
   $stmt->execute(['titol' => $title]);
   // fetchColumn devuelve false cuando la consulta no encuentra una fila.
   $existeix = $stmt->fetchColumn() !== false;

   // Libera la conexión antes de devolver el resultado de la comprobación.
   Database::close($connexio);

   return $existeix;
}

// Actualiza el título y el contenido del artículo identificado por su ID.
function modifyArticle($id, $title, $cos, $preu, $imatge)
{
   // Evita ejecutar la actualización si no existe el artículo solicitado.
   if (!verifyId($id)) {
      throw new Exception('Article inexistent');
   }

   // Abre la conexión para la actualización.
   $connexio = Database::getConnection();

   if ($connexio === null) {
      return false;
   }

   // Prepara la actualización y utiliza parámetros para los tres valores.
   $stmt = $connexio->prepare(
      'UPDATE articles 
      SET titol = :titol, 
      cos = :cos,
      preu = :preu,
      imatge = :imatge
      WHERE id = :id'
   );

   // Ejecuta la consulta con el ID y los nuevos valores del artículo.
   $resultat = $stmt->execute([
      'id' => $id,
      'titol' => $title,
      'cos' => $cos,
      'preu' => $preu,
      'imatge'=> $imatge
   ]);

   // Libera la conexión y devuelve si la ejecución tuvo éxito.
   Database::close($connexio);

   return $resultat;
}

// Recupera todos los artículos y los devuelve como una lista de objetos Article.
function getArticles()
{
   // Inicializa la lista vacía para poder devolverla incluso si no hay conexión.
   $connexio = Database::getConnection();
   $articles = [];

   // Solo consulta y transforma filas si se obtuvo una conexión válida.
   if ($connexio != null) {
      // Prepara la consulta que obtiene todas las filas de artículos.
      $stmt = $connexio->prepare('SELECT * FROM articles');

      // Ejecuta la consulta; no requiere parámetros porque no tiene filtros.
      $stmt->execute();

      // Recupera el conjunto de filas devueltas por la consulta.
      $resultats = $stmt->fetchAll();

      // Convierte cada fila asociativa en un objeto Article.
      foreach ($resultats as $fila) {
         // Añade el artículo convertido al arreglo de resultados.
         array_push($articles, new Article(
            $fila['id'],
            $fila['titol'],
            $fila['cos'],
            $fila['preu'],
            $fila['imatge']
         ));
      }
   }

   // Libera la conexión y entrega la lista de artículos.
   Database::close($connexio);

   return $articles;
}

// Recupera todos los artículos y los devuelve como una lista de objetos Article.
function getQtArticles($qt)
{
   // Inicializa la lista vacía para poder devolverla incluso si no hay conexión.
   $connexio = Database::getConnection();
   $articles = [];

   // Solo consulta y transforma filas si se obtuvo una conexión válida.
   if ($connexio != null) {
      // Prepara la consulta que obtiene todas las filas de artículos.
      $stmt = $connexio->prepare('SELECT * FROM articles LIMIT :qt');

      $stmt->bindValue(':qt', $qt, PDO::PARAM_INT);
      $stmt->execute();

      // Recupera el conjunto de filas devueltas por la consulta.
      $resultats = $stmt->fetchAll();

      // Convierte cada fila asociativa en un objeto Article.
      foreach ($resultats as $fila) {
         // Añade el artículo convertido al arreglo de resultados.
         array_push($articles, new Article(
            $fila['id'],
            $fila['titol'],
            $fila['cos'],
            $fila['preu'],
            $fila['imatge']
         ));
      }
   }

   // Libera la conexión y entrega la lista de artículos.
   Database::close($connexio);

   return $articles;
}

function getTotalArticles()
{
   // Inicializa el total en 0 por defecto si no hay conexión.
   $connexio = Database::getConnection();
   $total = 0;

   // Solo consulta si se obtuvo una conexión válida.
   if ($connexio != null) {
      // Prepara la consulta para contar los registros
      $stmt = $connexio->prepare('SELECT COUNT(*) FROM articles');
      $stmt->execute();

      // fetchColumn() obtiene directamente el valor numérico de la primera columna
      $total = (int) $stmt->fetchColumn();
   }

   // Libera la conexión y entrega el entero con el total.
   Database::close($connexio);

   return $total;
}

function getArticlesPaginados(int $limite, int $offset): array
{
   $db = Database::getConnection(); // O tu método para obtener la conexión PDO
   $stmt = $db->prepare("SELECT * FROM articles LIMIT :limite OFFSET :offset");
   $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
   $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
   $stmt->execute();
   return $stmt->fetchAll();
}