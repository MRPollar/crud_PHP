<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" href="assets/css/tarefas.css"/>
    </head>
    <body>
        <h1>Gerenciador de Tarefas</h1>

        <?php require 'formulario.php'; ?>

        <?php if ($exibir_tabela) : ?>
            <?php include('tabela.php'); ?>
        <?php endif; ?>
    </body>
</html>
