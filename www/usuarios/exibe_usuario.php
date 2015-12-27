<?php
try{
  $idn = $_POST['idn'];
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT rowid, * FROM usuario WHERE rowid = :idn;');
  $stmt->bindParam(':idn', $idn, PDO::PARAM_INT);
  $stmt->execute();

  $linha = $stmt->fetch(PDO::FETCH_ASSOC);

  if($linha['nome'] == "")
    $linha['nome'] = "Usuário Não Encontrado";


  echo '<h2>' . $linha['nome'];
  echo '<input type="button" value="Voltar" onclick="BIBLIOTECA.load(\'usuarios\', \'usuarios/index.htm\');"/>';
  echo '<input type="button" id="fecha" value="Apagar Usuário" onclick="BIBLIOTECA.confirma_apaga_usuario() && BIBLIOTECA.load(\'usuarios\', \'usuarios/remove.php?idn=' . $linha["rowid"] . '\');"/>';
  echo '</h2>';

  if($linha['rowid'] != ""){

    echo '<p>ID: <span id="usuario_exibido">' . $linha["rowid"] . '</span></p>';


    echo '<p>Livros que este usuário pegou emprestado:</p>';
    echo '<ul>';
    $stmt2 = $pdo->prepare('SELECT rowid, livro, dia FROM emprestimo WHERE usuario = :usuario;');
    $stmt2->bindParam(':usuario', $idn, PDO::PARAM_INT);
    $stmt2->execute();
    $count=0;
    while ($linha2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $count = $count + 1;
      $stmt3 = $pdo->prepare('SELECT titulo FROM livro WHERE rowid = :idn;');
      $stmt3->bindParam(':idn', $linha2['livro'], PDO::PARAM_INT);
      $stmt3->execute();
      $linha3=$stmt3->fetch(PDO::FETCH_ASSOC);
      $dias=(time() - $linha2['dia'])/86400;
      echo '<li>';
      echo '<a href="#" onclick="BIBLIOTECA.exibe_livro(' . $linha2['livro'] . ');">' . $linha3['titulo'] . "</a> (". floor($dias) ." dias atrás)";
      echo '<input type="button" value="Realizar Devolução" onclick="BIBLIOTECA.devolve('.$linha2['rowid'].');"/>';
      echo '</li>';
    }
    if($count == 0)
      echo 'Nenhum.';
    echo '</ul>';




    echo '<table><tr><td>Nome:</td><td> <input type="text" name="nome" class="medium_text" id="form_nome" value="' . $linha["nome"]  . '"/></td></tr>';
    echo '<tr><td>Telefone:</td><td> <input type="text" name="telefone" class="medium_text" id="form_telefone" value="' . $linha["telefone"]  . '"/></td></tr>';
    echo '<tr><td>Endereço:</td><td> <input type="text" name="endereco" class="medium_text" id="form_endereco" value="' . $linha["endereco"]  . '"/></td></tr></table>';
    echo '<p>Observações:<br/> <textarea name="observacoes" id="user_observacoes" class="long_text" id="form_observacoes">' . $linha['observacoes']  . '</textarea></p>';
    echo '<p"> <input type="button" value="Atualizar Dados" onclick="BIBLIOTECA.update_user(' . $linha['rowid']  .');"/></p>';
  } 
}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "?";
}

?>