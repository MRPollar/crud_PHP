<?php

$anexo = $repositorio_tarefas->buscar_anexo($_GET['id']);
$arquivo = $anexo->getArquivo();
$id = $anexo->getTarefaId();

unlink(__DIR__."/../anexos/{$arquivo}");

$repositorio_tarefas->remover_anexo($_GET['id']);

header("Location: index.php?rota=tarefa&id={$id}");