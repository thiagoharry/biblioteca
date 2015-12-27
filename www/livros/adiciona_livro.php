<?php

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('INSERT INTO livro (titulo, autor, editora, edicao, exemplares, aquisicao, observacoes) VALUES (:titulo, :autor, :editora, :edicao, :exemplares, :aquisicao, :observacoes);');

  $stmt->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
  $stmt->bindParam(':autor', $_POST['autor'], PDO::PARAM_STR);
  $stmt->bindParam(':editora', $_POST['editora'], PDO::PARAM_STR);
  $stmt->bindParam(':edicao', $_POST['edicao'], PDO::PARAM_INT);
  $stmt->bindParam(':exemplares', $_POST['exemplares'], PDO::PARAM_INT);
  $stmt->bindParam(':aquisicao', $_POST['aquisicao'], PDO::PARAM_INT);
  $stmt->bindParam(':observacoes', $_POST['observacoes'], PDO::PARAM_STR);

  $result=$stmt->execute();
  if($result == false){
    print_r($stmt->errorInfo());
  }
  else{
    echo '<h2>Livro Adicionado';
    echo '<input type="button" value="Voltar" onclick="BIBLIOTECA.load(\'livros\', \'livros/index.htm\');"></h2>';

    echo 'Novo livro registrado com código: ' . $pdo->lastInsertId();
  }
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