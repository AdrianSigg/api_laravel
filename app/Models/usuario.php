<?php
    namespace App\Models;
    class Usuario
    {
        //----- Atributos
        private $id_int;
        private $nombre_str;
        private $contrasena_str;
        private $email_str;

        //---- Set´s
        public function setId($id_int){
            $this->id_int=$id_int;
        }
        public function setUsername($nombre_str){
            $this->nombre_str= $nombre_str;
        }
        public function setContrasena($contrasena_str){
            $this->contrasena_str= $contrasena_str;
        }
        public function setEmail($email_str){
            $this->email_str=$email_str;
        }

        //-- Get´s

        public function getId(){
            return $this->id_int;
        }
        public function getUsername(){
            return $this->nombre_str;
        }
        public function getContrasena(){
            return $this->contrasena_str;
        }
        public function getEmail(){
            return $this->email_str;
        }
    }

?>
