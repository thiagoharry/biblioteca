<?php

echo '<h2>Lista de Usuários';
echo '<input type="button"  value="Voltar" onclick="BIBLIOTECA.load(\'usuarios\', \'usuarios/index.htm\');"></h2>';

try{
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT rowid, * FROM usuario;');
  $stmt->execute();
  echo '<table border="1">';
  echo '<tr>';
  echo '<td><b>ID</b></td>';
  echo '<td><b>Nome</b></td>';
  echo '<td><b>Telefone</b></td>';
  echo '<td><b>Endereço</b></td>';
  echo '<td><b>Observações</b></td>';
  echo '</tr>';
  $total = 0;
  while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $linha['rowid'] . '</td>';
    echo '<td><a href="#" onclick="BIBLIOTECA.exibe_usuario(' . $linha['rowid'] . ');">' . $linha['nome'] . '</a></td>';
    echo '<td>' . $linha['telefone'] . '</td>';
    echo '<td>' . $linha['endereco'] . '</td>';
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