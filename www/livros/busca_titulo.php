<?php

function interpreta_aquisicao($n){ 
  if($n === "0")
    return "Doação";
  else return "Compra";
} 

echo '<h2>Lista de Livros';
echo '<input type="button" value="Voltar" onclick="BIBLIOTECA.load(\'livros\', \'livros/index.htm\');"/>';
echo '</h2>';


try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT rowid, * FROM livro WHERE titulo LIKE ?;');
  
  $stmt->execute(array("%$_POST[titulo]%"));

  
  echo '<table border="1">';
  echo '<tr>';
  echo '<td><b>ID</b></td>';
  echo '<td><b>Título</b></td>';
  echo '<td><b>Autor</b></td>';
  echo '<td><b>Editora</b></td>';
  echo '<td><b>Ed.</b></td>';
  echo '<td><b>Ex.</b></td>';
  echo '<td><b>Aquisição</b></td>';
  echo '<td><b>Observações</b></td>';
  echo '</tr>';
  $total = 0;
  while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $linha['rowid'] . '</td>';
    echo '<td><a href="#" onclick="BIBLIOTECA.exibe_livro(' . $linha['rowid'] . ');">' . $linha['titulo'] . '</a></td>';
    echo '<td>' . $linha['autor'] . '</td>';
    echo '<td>' . $linha['editora'] . '</td>';
    echo '<td>' . $linha['edicao'] . '</td>';
    echo '<td>' . $linha['exemplares'] . '</td>';
    echo '<td>' . interpreta_aquisicao($linha['aquisicao']) . '</td>';
    echo '<td>' . $linha['observacoes'] . '</td>';
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