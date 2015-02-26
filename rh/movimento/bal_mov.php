<?php

$conexao = pg_connect("host=localhost dbname=internos port=5432 user=postgres password=aporedux");

$sql = "
	select teste()
";
$result = pg_exec($conexao, $sql);

print_r(pg_fetch_all($result));

?>