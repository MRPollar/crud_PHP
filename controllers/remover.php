<?php

$anexos = $repositorio_tarefas->buscar_anexos($_GET['id']);

foreach($anexos as $anexo){
   unlink(__DIR__."/../anexos/".$anexo->getArquivo());
}


$repositorio_tarefas->remover($_GET['id']);

header('Location: index.php?rota=tarefas');
