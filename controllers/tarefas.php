<?php

$exibir_tabela = true;

$tem_erros = false;
$erros_validacao = [];

$tarefa = new Tarefa();
$tarefa->setPrioridade();

if (tem_post()) {

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
        $tarefa->setConcluido(1);
    } else {
        $tarefa->setConcluido(0);
    }

    if (! $tem_erros) {
        $repositorio_tarefas->salvar($tarefa);

        if (array_key_exists('lembrete', $_POST) && $_POST['lembrete'] == '1') {
            //enviar_email($tarefa);
        }

        header('Location: index.php?rota=tarefas');
        die();
    }
}

$tarefas = $repositorio_tarefas->buscar();

include __DIR__."/../views/template.php";