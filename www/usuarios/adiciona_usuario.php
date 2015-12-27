<?php

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('INSERT INTO usuario (nome, telefone, endereco, observacoes) VALUES (:nome, :telefone, :endereco, :observacoes);');

  $stmt->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);
  $stmt->bindParam(':telefone', $_POST['telefone'], PDO::PARAM_STR);
  $stmt->bindParam(':endereco', $_POST['endereco'], PDO::PARAM_STR);
  $stmt->bindParam(':observacoes', $_POST['observacoes'], PDO::PARAM_STR);

  $stmt->execute();

  header("Location: index.htm");

}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "Erro desconhecido: " . $e -> getMessage();
}

?>