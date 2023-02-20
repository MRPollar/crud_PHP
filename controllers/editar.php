<?php

$exibir_tabela = false;
$tem_erros = false;
$erros_validacao = array();

$tarefa = $repositorio_tarefas->buscar($_GET['id']);

if (tem_post()) {

    $tarefa->setId($_POST['id']);

    if (array_key_exists('nome', $_POST) && strlen($_POST['nome']) > 0) {
        $tarefa->setTarefa($_POST['nome']);
    } else {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    if (array_key_exists('descricao', $_POST)) {
        $tarefa->setDescricao($_POST['descricao']);
    } else {
        $tarefa->setDescricao('');
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo'])) {
            $tarefa->setPrazo(traduz_data_br_para_objeto($_POST['prazo']));
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
    } else {
        $tarefa->setPrazo('');
    }

    $tarefa->setPrioridade($_POST['prioridade']);

    if (array_key_exists('concluida', $_POST)) {
        $tarefa->setConcluido(true);
    } else {
        $tarefa->setConcluido(false);
    }

    if (! $tem_erros) {
        $repositorio_tarefas->atualizar($tarefa);

        if (array_key_exists('lembrete', $_POST) && $_POST['lembrete'] == '1') {
            $anexos = $repositorio_tarefas->buscar_anexos($tarefa['id']);

            //enviar_email($tarefa, $anexos);
        }

        header('Location: index.php?rota=tarefas');
        die();
    }
}


include __DIR__."/../views/template.php";
