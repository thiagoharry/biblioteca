<?php

try{
  $idn = $_GET['idn'];
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');

  $stmt=$pdo->prepare('SELECT count(*) FROM emprestimo WHERE usuario = :usuario;');
  $stmt->bindParam(':usuario', $idn, PDO::PARAM_INT);
  $stmt->execute();
  $resultado=$stmt->fetch(PDO::FETCH_NUM);

  if($resultado[0]  > 0){
    echo 'Impossível apagar usuário com livros em sua posse.<br/>';
    echo "Realize a devolução antes de apagar.";
  }
  else{


    $stmt2 = $pdo->prepare('DELETE FROM usuario WHERE rowid = :idn;');

    $stmt2->bindParam(':idn', $idn, PDO::PARAM_INT);
    $stmt2->execute();

    header("Location: index.htm");
  }
}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "Erro desconhecido: " . $e -> getMessage();
}
