<?php
echo '<h2>Lista de Empréstimos po Usuário';
echo '<input type="button"  value="Voltar" onclick="BIBLIOTECA.load(\'usuarios\', \'usuarios/index.htm\');"></h2>';

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT * FROM emprestimo ORDER BY dia ASC;');
  $stmt->execute();
  echo '<table>';
  echo '<tr>';
  echo '<td><b>Nome</b></td>';
  echo '<td><b>Livro</b></td>';
  echo '<td><b>Dias de Empréstimo</b></td>';
  echo '</tr>';
  $total = 0;
  while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    $stmt2=$pdo->prepare('SELECT rowid, nome FROM usuario WHERE rowid = :usuario;');
    $stmt2->bindParam(':usuario', $linha['usuario'], PDO::PARAM_INT);
    $stmt2->execute();
    $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);
    $nome=$resultado['nome'];
    $user_id=$resultado['rowid'];

    $stmt3=$pdo->prepare('SELECT rowid, titulo FROM livro WHERE rowid = :livro;');
    $stmt3->bindParam(':livro', $linha['livro'], PDO::PARAM_INT);
    $stmt3->execute();
    $resultado = $stmt3->fetch(PDO::FETCH_ASSOC);
    $titulo=$resultado['titulo'];
    $book_id=$resultado['rowid'];


    echo '<td><a href="#" onclick="BIBLIOTECA.exibe_usuario(' . $user_id . ');">' . $nome . '</a></td>';
    echo '<td><a href="#" onclick="BIBLIOTECA.exibe_livro('. $book_id . ');">' . $titulo . '</a></td>';
    echo '<td>' . floor((time()-$linha['dia'])/86400) . '</td>';
    echo '</tr>';
    $total = $total + 1;
  }
  echo '</table>';
  echo '<p>Total: ' . $total . '</p>';
}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "?";
}

?>