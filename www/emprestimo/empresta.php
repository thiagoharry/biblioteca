<?php

try{
  /* Descobrimos quantos exemplares temos. */
  $livro = $_POST["livro"];
  $usuario = $_POST["usuario"];
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT exemplares FROM livro WHERE rowid = :idn;');
  $stmt->bindParam(':idn', $livro, PDO::PARAM_INT);
  $stmt -> execute();
  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
  $exemplares = $resultado['exemplares'];
  if($exemplares == 0){
    echo 'Não há exemplares deste livro paa que possamos emprestar.';
  }
  else{
    /* Descobrimos quantos empréstimos deste livro temos. */
    $stmt2 = $pdo->prepare('SELECT count(*) FROM emprestimo WHERE livro = :livro;');
    $stmt2->bindParam(':livro', $livro, PDO::PARAM_INT);
    $stmt2->execute();
    $row = $stmt2->fetch(PDO::FETCH_NUM);
    $emprestimos = $row[0];
    if($emprestimos >= $exemplares){
      echo 'Todos os exemplares deste livro já foram emprestados.';
    }
    else{
      // Verificar se o empréstimo já foi feito.
      $stmt3 = $pdo->prepare('SELECT count(*) FROM emprestimo WHERE usuario = :usuario;');
      $stmt3->bindParam(':livro', $livro, PDO::PARAM_INT);
      $stmt3->bindParam(':usuario', $usuario, PDO::PARAM_INT);
      $stmt3->execute();
      $row = $stmt3->fetch(PDO::FETCH_NUM);
      if($row[0] > 0){
	echo 'Este empréstimo já foi feito.';
      }
      else{
	// Tudo certo. Realizar empréstimo.
	$stmt5 = $pdo->prepare('INSERT INTO emprestimo (livro, usuario, dia) VALUES (:livro, :usuario, :dia);');
	$stmt5->bindParam(':livro', $livro, PDO::PARAM_INT);
	$stmt5->bindParam(':usuario', $usuario, PDO::PARAM_INT);
	$stmt5->bindParam(':dia', time(), PDO::PARAM_INT);
	$stmt5->execute();
	echo 'Empréstimo realizado com sucesso!';
      }
    }   
    
  }
}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "Erro: " . $e - getMessage();
}

?>