<?php

function interpreta_aquisicao($n){ 
  if($n === "0")
    return "Doação";
  else return "Compra";
} 

try{
  $idn = $_POST['idn'];
  $pdo = new PDO('sqlite:../banco_de_dados/banco.db');
  $stmt = $pdo->prepare('SELECT rowid, * FROM livro WHERE rowid = :idn;');
  $stmt->bindParam(':idn', $idn, PDO::PARAM_INT);
  $stmt->execute();

  $linha = $stmt->fetch(PDO::FETCH_ASSOC);

  if($linha['titulo'] == "")
    $linha['titulo'] = "Livro Não Encontrado";


  echo '<h2>' . $linha['titulo'];
  echo '<input type="button" value="Voltar" onclick="BIBLIOTECA.load(\'livros\', \'livros/index.htm\');"/>';
  echo '<input id="fecha" value="Apagar Livro" type="button" onclick="BIBLIOTECA.confirma_apaga_livro() && BIBLIOTECA.load(\'livros\', \'livros/remove.php?idn=' . $linha["rowid"] . '\');"></h2>';

  if($linha['rowid'] != ""){

    echo '<p>ID: <span id="livro_exibido">' . $linha["rowid"] . '</span></p>';

    echo '<p>Usuários que pegaram o livro emprestado:</p>';
    echo '<ul>';
    $stmt2 = $pdo->prepare('SELECT rowid, usuario, dia FROM emprestimo WHERE livro = :livro;');
    $stmt2->bindParam(':livro', $idn, PDO::PARAM_INT);
    $stmt2->execute();
    $count=0;
    while ($linha2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $count = $count + 1;
      $stmt3 = $pdo->prepare('SELECT nome FROM usuario WHERE rowid = :idn;');
      $stmt3->bindParam(':idn', $linha2['usuario'], PDO::PARAM_INT);
      $stmt3->execute();
      $linha3=$stmt3->fetch(PDO::FETCH_ASSOC);
      $dias=(time() - $linha2['dia'])/86400;
      echo '<li>';
      echo '<a href="#" onclick="BIBLIOTECA.exibe_usuario(' . $linha2['usuario'] . ');">' . $linha3['nome'] . "</a> (". floor($dias) ." dias atrás)";
      echo '<input type="button" value="Realizar Devolução" onclick="BIBLIOTECA.devolve('.$linha2['rowid'].');"/>';
      echo '</li>';
    }
    if($count == 0)
      echo 'Nenhum.';
    echo '</ul>';

    echo '<table><tr><td>Título:</td><td> <input type="text" name="titulo" class="medium_text" id="form_titulo" value="' . $linha["titulo"]  . '"/></td></tr>';
    echo '<tr><td>Autor:</td><td> <input type="text" name="autor" class="medium_text" id="form_autor" value="' . $linha["autor"]  . '"/></td></tr>';
    echo '<tr><td>Editora:</td><td> <input type="text" name="editora" class="medium_text" id="form_editora" value="' . $linha["editora"]  . '"/></td></tr></table>';
    echo '<p>Edição: <input type="number" name="edicao" min="1" class="small_text" id="form_edicao" value="' . $linha["edicao"]  . '"/>';
    echo 'Exemplares: <input type="number" name="exemplares" class="small_text" id="form_exemplares" min="0" value="' . $linha["exemplares"]  . '"/></p>';
    if($linha["aquisicao"] == 1){
      echo '<p>Aquisição: <input type="radio" name="aquisicao" value="0" id="form_doacao"/> Doação <input type="radio" name="aquisicao" value="1" id="form_aquisicao" checked="checked"/> Compra </p>';
    }
    else{
      echo '<p>Aquisição: <input type="radio" name="aquisicao" value="0" id="form_doacao" checked="checked"/> Doação <input type="radio" name="aquisicao" value="1" id="form_aquisicao"/> Compra </p>';
    }  
    echo '<p>Observações:<br/> <textarea name="observacoes" id="observacoes" class="long_text" id="form_observacoes">' . $linha['observacoes']  . '</textarea></p>';
    echo '<p"> <input type="button" value="Atualizar Dados" onclick="BIBLIOTECA.update_book(' . $linha['rowid']  .');"/></p>';
  } 
}
catch(PDOException $e){
  echo "Conexão fracassada: " . $e -> getMessage();
}
catch(Exception $e){
  echo "?";
}

?>