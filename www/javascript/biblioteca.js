var BIBLIOTECA = {};

BIBLIOTECA.ahah = function (url){
};

BIBLIOTECA.ahahDone = function (req, target, url) {
    if (req.readyState == 4) { // only if req is "loaded"
	if (req.status == 200) { // only if "OK"
	    document.getElementById(target).innerHTML = req.responseText;
	} else {
	    document.getElementById(target).innerHTML=" Desculpe, não foi " +
		"possível obter a página. Por favor, nos ajude" +
		"entrando em contato conosco, informando o que você tentou " +
		"fazer e avisando da ocorrência de um erro " + 
		req.status + " - " +req.statusText + ".";
	}
    }
};

BIBLIOTECA.load = function (target, url) {
    document.getElementById(target).innerHTML = 'Carregando...';
    if (window.XMLHttpRequest) {
	var req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
	var req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (req != undefined) {

	req.onreadystatechange = function() {BIBLIOTECA.ahahDone(req, target, url);};
	req.open("GET", url, true);
	req.send("");
    }
    return false;
};

BIBLIOTECA.add_book = function (){
    BIBLIOTECA.livro = 0;
    BIBLIOTECA.titulo = "";
    
    BIBLIOTECA.usuario = 0;
    BIBLIOTECA.nome = "";

    var req = new XMLHttpRequest();
    var url = "livros/adiciona_livro.php";
    var params = "";

    if(! BIBLIOTECA.valida_novo_livro())
	return false;

    params = params + "titulo=" +
	BIBLIOTECA.escape(document.getElementById("form_titulo").value) + "&";
    params = params + "autor=" +
	BIBLIOTECA.escape(document.getElementById("form_autor").value) + "&";
    params = params + "editora=" +
	BIBLIOTECA.escape(document.getElementById("form_editora").value) + "&";
    params = params + "edicao=" +
	BIBLIOTECA.escape(document.getElementById("form_edicao").value) + "&";
    params = params + "exemplares=" +
	BIBLIOTECA.escape(document.getElementById("form_exemplares").value) + "&";
    params = params + "observacoes=" +
	BIBLIOTECA.escape(document.getElementById("observacoes").value) + "&";
    if(document.getElementById("form_aquisicao").checked === true){
	params = params + "aquisicao=1";
    }
    else
	params = params + "aquisicao=0";
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("livros").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;
};

BIBLIOTECA.valida_novo_livro = function (){
    var tag = document.getElementById("form_titulo").value;
    if(tag === "" || tag === null || tag === undefined){
	alert("Digite o nome de um título.");
	return false;
    }
    tag = document.getElementById("form_autor").value;
    if(tag === "" || tag === null || tag === undefined){
	alert("Digite o nome de um autor.");
	return false;
    }
    return true;
};

BIBLIOTECA.escape = function (string){
    return encodeURIComponent(string);
};

BIBLIOTECA.exibe_livro = function (idn){
    BIBLIOTECA.livro = idn;


    var req = new XMLHttpRequest();
    var url = "livros/exibe_livro.php";
    var params = "";

    params = params + "idn=" + idn;
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("livros").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;

};

BIBLIOTECA.update_book = function (idn){
    BIBLIOTECA.livro = 0;
    BIBLIOTECA.titulo = "";
    
    BIBLIOTECA.usuario = 0;
    BIBLIOTECA.nome = "";

    var req = new XMLHttpRequest();
    var url = "livros/atualiza_livro.php";
    var params = "idn=" + idn + "&";

    if(! BIBLIOTECA.valida_novo_livro())
	return false;

    params = params + "titulo=" +
	BIBLIOTECA.escape(document.getElementById("form_titulo").value) + "&";
    params = params + "autor=" +
	BIBLIOTECA.escape(document.getElementById("form_autor").value) + "&";
    params = params + "editora=" +
	BIBLIOTECA.escape(document.getElementById("form_editora").value) + "&";
    params = params + "edicao=" +
	BIBLIOTECA.escape(document.getElementById("form_edicao").value) + "&";
    params = params + "exemplares=" +
	BIBLIOTECA.escape(document.getElementById("form_exemplares").value) + "&";
    params = params + "observacoes=" +
	BIBLIOTECA.escape(document.getElementById("observacoes").value) + "&";
    if(document.getElementById("form_aquisicao").checked === true){
	params = params + "aquisicao=1";
    }
    else
	params = params + "aquisicao=0";
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("livros").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;
};


BIBLIOTECA.confirma_apaga_livro = function (){
    return confirm("Tem certeza que deseja remover o livro? A operação não poderá ser desfeita.");
}

BIBLIOTECA.confirma_apaga_usuario = function (){
    return confirm("Tem certeza que deseja remover o usuário? A operação não poderá ser desfeita.");
}

BIBLIOTECA.busca_titulo = function (padrao){
    if(padrao === "" || padrao === null || padrao === undefined){
	alert("Nenhuma palavra buscada");
	return false;
    }
    BIBLIOTECA.livro = 0;
    BIBLIOTECA.titulo = "";
    
    BIBLIOTECA.usuario = 0;
    BIBLIOTECA.nome = "";

    var req = new XMLHttpRequest();
    var url = "livros/busca_titulo.php";
    var params = "";
    params = params + "titulo=" + BIBLIOTECA.escape(padrao);
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("livros").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;


};

BIBLIOTECA.busca_autor = function (padrao){
    if(padrao === "" || padrao === null || padrao === undefined){
	alert("Nenhuma palavra buscada");
	return false;
    }
    BIBLIOTECA.livro = 0;
    BIBLIOTECA.titulo = "";
    
    BIBLIOTECA.usuario = 0;
    BIBLIOTECA.nome = "";

    var req = new XMLHttpRequest();
    var url = "livros/busca_autor.php";
    var params = "";
    params = params + "autor=" + BIBLIOTECA.escape(padrao);
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("livros").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;
};

BIBLIOTECA.add_user = function (){
    var req = new XMLHttpRequest();
    var url = "usuarios/adiciona_usuario.php";
    var params = "";

    if(! BIBLIOTECA.valida_novo_usuario())
	return false;

    params = params + "nome=" +
	BIBLIOTECA.escape(document.getElementById("form_nome").value) + "&";
    params = params + "telefone=" +
	BIBLIOTECA.escape(document.getElementById("form_telefone").value) + "&";
    params = params + "endereco=" +
	BIBLIOTECA.escape(document.getElementById("form_endereco").value) + "&";
    params = params + "observacoes=" +
	BIBLIOTECA.escape(document.getElementById("user_observacoes").value) + "&";
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("usuarios").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;
};

BIBLIOTECA.valida_novo_usuario = function (){
    var tag = document.getElementById("form_nome").value;
    if(tag === "" || tag === null || tag === undefined){
	alert("Digite o nome do novo usuário.");
	return false;
    }
    tag = document.getElementById("form_telefone").value;
    if(tag === "" || tag === null || tag === undefined){
	alert("Digite o telefone do novo usuário.");
	return false;
    }
    tag = document.getElementById("form_endereco").value;
    if(tag === "" || tag === null || tag === undefined){
	alert("Digite o endereço do novo usuário.");
	return false;
    }
    return true;
};


BIBLIOTECA.exibe_usuario = function (idn){
    BIBLIOTECA.livro = idn;


    var req = new XMLHttpRequest();
    var url = "usuarios/exibe_usuario.php";
    var params = "";

    params = params + "idn=" + idn;
    
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("usuarios").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;

};

BIBLIOTECA.update_user = function (idn){
    var req = new XMLHttpRequest();
    var url = "usuarios/atualiza_usuario.php";
    var params = "idn=" + idn + "&";

    if(! BIBLIOTECA.valida_novo_usuario())
	return false;

    params = params + "nome=" +
	BIBLIOTECA.escape(document.getElementById("form_nome").value) + "&";
    params = params + "telefone=" +
	BIBLIOTECA.escape(document.getElementById("form_telefone").value) + "&";
    params = params + "endereco=" +
	BIBLIOTECA.escape(document.getElementById("form_endereco").value) + "&";
    params = params + "observacoes=" +
	BIBLIOTECA.escape(document.getElementById("user_observacoes").value) + "&";
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		document.getElementById("usuarios").innerHTML = req.responseText;
	    }
	};
	req.send(params);
    }
    return false;
};


BIBLIOTECA.testa_emprestimo = function (){
    var livro = document.getElementById("livro_exibido");
    var usuario = document.getElementById("usuario_exibido");
    if(livro === null || livro === "" || livro === undefined){
	alert("Nenhum livro selecionado.");
	return false;
    }
    if(usuario === null || usuario === "" || usuario === undefined){
	alert("Nenhum usuário selecionado.");
	return false;
    }
    return BIBLIOTECA.empresta(livro.innerText, usuario.innerText);
};

BIBLIOTECA.empresta = function (livro, usuario){
    var req = new XMLHttpRequest();
    var url = "emprestimo/empresta.php";
    var params = "livro=" + livro + "&usuario=" + usuario;
    if(req!== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		alert(req.responseText);
		BIBLIOTECA.exibe_livro(livro);
		BIBLIOTECA.exibe_usuario(usuario);
	    }
	};
	req.send(params);
    }
    return false;
};

BIBLIOTECA.devolve = function (idn){
    var req = new XMLHttpRequest();
    var url = "emprestimo/devolve.php";
    var params = "idn=" + idn;
    if(req !== undefined){
	req.open("POST", url, true);

	//Send the proper header information along with the request
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	req.onreadystatechange = function(){
	    if(req.readyState == 4 && req.status == 200) {
		alert(req.responseText);
	    }
	};
	req.send(params);
    }
    var livro =   document.getElementById("livro_exibido");
    var usuario = document.getElementById("usuario_exibido");
    if(livro != null && livro != "" && livro != undefined){
	BIBLIOTECA.exibe_livro(livro.innerText);
    }
    if(usuario != null && usuario != "" && usuario != undefined){
	BIBLIOTECA.exibe_usuario(usuario.innerText);
    }
    return false;
};