<?php

class Tarefa {
   private $id;
   private $tarefa;
   private $descricao;
   private $prazo;
   private $prioridade;
   private $concluido;
   private $anexos =[];




   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
      return $this->id;
   }




   public function setTarefa(string $name){
      $this->tarefa = $name;
   }

   public function getTarefa(){
      return $this->tarefa;
   }




   public function setDescricao(string $descricao){
      $this->descricao = $descricao;
   }

   public function getDescricao(){
      return $this->descricao;
   }




   public function setPrazo($prazo){
      $this->prazo = $prazo;
   }

   public function getPrazo(){
      return $this->prazo;
   }




   public function setPrioridade(int $prioridade = 1){
      $this->prioridade = $prioridade;
   }

   public function getPrioridade(){
      return $this->prioridade;
   }




   public function setConcluido(bool $concluido){
      $this->concluido = $concluido;
   }

   public function getConcluido(){
      return $this->concluido;
   }




   public function setAnexos(array $anexos){
      $this->anexos = [];

      foreach($anexos as $anexo){
         $this->adicionarAnexo($anexo);
      }
   }

   public function adicionarAnexo(Anexo $anexo){
      return array_push($this->anexos,$anexo);
   }

   public function getAnexos(){
      return $this->anexos;
   }

}