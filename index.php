<?php

require "config.php";
require "helpers/banco.php";
require "helpers/ajudantes.php";
require "models/Anexo.php";
require "models/Tarefa.php";
require "models/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($conexao);

$rota = "tarefas";

if(array_key_exists('rota', $_GET)){
   $rota = (string)$_GET['rota'];
}

if(is_file("controllers/{$rota}.php")){
   require "controllers/{$rota}.php";
} else {
   echo "rota não encontrada";
}

?>