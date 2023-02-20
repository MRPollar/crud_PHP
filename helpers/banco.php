<?php

//$conexao = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

try{
    $conexao = new PDO(BD_DSN ,BD_USUARIO,BD_SENHA);
}catch(PDOexception $e){
    echo "Falha na conexão com banco de dados: ".$e->getMessage();
    die();
}