BANCO=banco_de_dados/banco.db
BD=banco_de_dados

clean:
	find . -name "*~" -exec rm -rf {} \;
reset_database:
	rm -rf ${BANCO}
	sqlite3 ${BANCO} < ${BD}/00-criar.sql
