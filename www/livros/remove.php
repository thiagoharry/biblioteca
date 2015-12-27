<?php

try{
  $idn = $_GET['idn'];
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  
  $stmt=$pdo->prepare('SELECT count(*) FROM emprestimo WHERE livro = :livro;');
  $stmt->bindParam(':livro', $idn, PDO::PARAM_INT);
  $stmt->execute();
  $resultado=$stmt->fetch(PDO::FETCH_NUM);

  if($resultado[0]  > 0){
    echo 'Impossível apagar livro emprestado à usuário.<br/>';
    echo "Realize a devolução antes de apagar.";
  }
  else{

    $stmt2 = $pdo->prepare('DELETE FROM livro WHERE rowid = :idn;');
    
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
