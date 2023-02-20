<?php

class RepositorioTarefas{
   private $connection;

   public function __construct($conexao){
      $this->connection = $conexao;
   }


   public function salvar(Tarefa $tarefa){

      $prazo = $tarefa->getPrazo();
      if(is_object($prazo)){
         $prazo = $prazo->format('Y-m-d');
      }

      $sqlGravar = "INSERT INTO `lista` VALUES (null, :nome, :descricao, :prazo, :prioridade, :concluido)";

      $query = $this->connection->prepare($sqlGravar);
      $query->execute([
         'nome' => strip_tags($tarefa->getTarefa()),
         'descricao' => strip_tags($tarefa->getDescricao()),
         'prazo' => $prazo,
         'prioridade' =>  $tarefa->getPrioridade(),
         'concluido' => $tarefa->getConcluido(),
      ]);

   }

   public function atualizar(Tarefa $tarefa){

      $prazo = $tarefa->getPrazo();
      if(is_object($prazo)){
         $prazo = $prazo->format('Y-m-d');
      }

      $sqlAtualizar = "UPDATE `lista` SET tarefa = :nome, descricao = :descricao, prazo = :prazo, prioridade = :prioridade, concluido = :concluido WHERE id = :id";

      $query = $this->connection->prepare($sqlAtualizar);
      $query->execute([
         'nome' => strip_tags($tarefa->getTarefa()),
         'descricao' => strip_tags($tarefa->getDescricao()),
         'prazo' => $prazo,
         'prioridade' =>  $tarefa->getPrioridade(),
         'concluido' => $tarefa->getConcluido(),
         'id' => $tarefa->getId()
      ]);
   }

   public function buscar($tarefa_id = 0){
      $tarefa_id = (int)$tarefa_id;
      if($tarefa_id > 0){
         return $this->buscar_tarefa($tarefa_id);
      } else {
         return $this->buscar_tarefas();
      }
   }

   private function buscar_tarefa($tarefa_id){
      $sqlBusca = "SELECT * FROM `lista` WHERE id=:tarefa_id";

      $query = $this->connection->prepare($sqlBusca);
      $query->execute(['tarefa_id' => $tarefa_id]);

      $tarefa = $query->fetchObject('Tarefa');
      $tarefa->setAnexos(
         $this->buscar_anexos($tarefa->getId())
      );

      return $tarefa;
   }

   private function buscar_tarefas(){
      $sqlBusca = "SELECT * FROM `lista`";

      $resultado = $this->connection->query($sqlBusca,PDO::FETCH_CLASS,'Tarefa');

      $tarefas = [];

      foreach($resultado as $tarefa){
         $tarefa->setAnexos(
            $this->buscar_anexos($tarefa->getId())
         );
         $tarefas[] = $tarefa;
      }

      return $tarefas;
   }
   public function remover($id){
      $sqlRemove ="DELETE FROM `lista` WHERE id=:id";
      $query = $this->connection->prepare($sqlRemove);
      $query->execute(['id' => $id]);

   }






   public function buscar_anexos($tarefa_id){
      $sqlBusca = "SELECT * FROM `anexos` WHERE tarefa_id=:tarefa_id";

      $resultado = $this->connection->prepare($sqlBusca);
      $resultado->execute(['tarefa_id' => $tarefa_id]);

      $anexos = [];

      while($anexo = $resultado->fetchObject('Anexo')){
         $anexos[] = $anexo;
      }

      return $anexos;

   }

   public function buscar_anexo($tarefa_id){
      $sqlBusca = "SELECT * FROM `anexos` WHERE id=:tarefa_id";
      $query = $this->connection->prepare($sqlBusca);
      $query->execute([
         'tarefa_id' => $tarefa_id
      ]);

      return $query->fetchObject('Anexo');

   }

   public function salvar_anexo(Anexo $anexo){

      $sqlSalvar = "INSERT INTO `anexos` VALUES (null, :tarefa_id, :nome, :arquivo)";

      $query = $this->connection->prepare($sqlSalvar);
      $query->execute([
         'tarefa_id' => $anexo->getTarefaId(),
         'nome' => strip_tags($anexo->getNome()),
         'arquivo' => strip_tags($anexo->getArquivo())
      ]);
   }

   public function remover_anexo($anexo_id){
      $sqlRemove = "DELETE FROM `anexos` WHERE id=:id";

      $query = $this->connection->prepare($sqlRemove);
      $query->execute([
         'id' => $anexo_id
      ]);
   }
}