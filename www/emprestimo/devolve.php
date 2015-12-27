<?php

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('DELETE FROM emprestimo WHERE rowid = :idn;');

  $stmt->bindParam(':idn', $_POST['idn'], PDO::PARAM_INT);
  $stmt->execute();

  echo "Devolução realizada com sucesso.";

}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "Erro desconhecido: " . $e -> getMessage();
}
?>