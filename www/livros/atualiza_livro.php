<?php

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('UPDATE livro SET titulo = :titulo, autor = :autor, editora = :editora, edicao = :edicao, exemplares = :exemplares, aquisicao = :aquisicao, observacoes = :observacoes WHERE rowid = :idn;');

  $stmt->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
  $stmt->bindParam(':autor', $_POST['autor'], PDO::PARAM_STR);
  $stmt->bindParam(':editora', $_POST['editora'], PDO::PARAM_STR);
  $stmt->bindParam(':edicao', $_POST['edicao'], PDO::PARAM_INT);
  $stmt->bindParam(':exemplares', $_POST['exemplares'], PDO::PARAM_INT);
  $stmt->bindParam(':aquisicao', $_POST['aquisicao'], PDO::PARAM_INT);
  $stmt->bindParam(':observacoes', $_POST['observacoes'], PDO::PARAM_STR);
  $stmt->bindParam(':idn', $_POST['idn'], PDO::PARAM_INT);
  $stmt->execute();

  header("Location: index.htm");

}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "Erro desconhecido: " . $e -> getMessage();
}


/* 
$_POST["titulo"]
$_POST["autor"]
$_POST["editora"]
$_POST["edicao"]
$_POST["exemplares"]
$_POST["observacoes"]
$_POST["aquisicao"]
 */

?>