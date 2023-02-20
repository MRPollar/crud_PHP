<?php

$tem_erros = false;
$erros_validacao = array();


$anexo = new Anexo();

if (tem_post()) {
    // upload dos anexos
    $tarefa_id = $_POST['tarefa_id'];

    if (! isset($_FILES['anexo'])) {
        $tem_erros = true;
        $erros_validacao['anexo'] = 'Você deve selecionar um arquivo para anexar';
    } else {
        if (tratar_anexo($_FILES['anexo'])) {
            $anexo->setTarefaId($tarefa_id);
            $anexo->setNome(substr($_FILES['anexo']['name'], 0, -4));
            $anexo->setArquivo($_FILES['anexo']['name']);
        } else {
            $tem_erros = true;
            $erros_validacao['anexo'] = 'Envie apenas anexos nos formatos zip ou pdf';
        }
    }

    if (! $tem_erros) {
        $repositorio_tarefas->salvar_anexo($anexo);
        header("Location: index.php?rota=tarefa&id={$tarefa_id}");
        die();
    }
}

$tarefa = $repositorio_tarefas->buscar($_GET['id']);

include __DIR__."/../views/template_tarefa.php";
