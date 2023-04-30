<?php
    namespace App\Modelo;
    class Usuario
    {
        //----- Atributos
        private $id_int;
        private $nombre_str;
        private $alias_str;
        private $contrasena_str;

        //---- Set´s
        public function setId($id_int){
            $this->id_int=$id_int;
        }
        public function setNombre($nombre_str){
            $this->nombre_str= $nombre_str;
        }
        public function setAlias($alias_str){
            $this->alias_str= $alias_str;
        }
        public function setContrasena($contrasena_str){
            $this->contrasena_str= $contrasena_str;
        }
        //-- Get´s

        public function getId(){
            return $this->id_int;
        }
        public function getNombre(){
            return $this->nombre_str;
        }
        public function getAlias(){
            return $this->alias_str;
        }
        public function getContrasena(){
            return $this->contrasena_str;
        }

    }

?>
