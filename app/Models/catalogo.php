<?php
    namespace App\Models;
    class Catalogo
    {
        //----- Atributos
        private $nombre_str;
        private $precio_int;
        private $imagen_str;


        //---- Set´s
        public function setPrecio($precio_int){
            $this->precio_int=$precio_int;
        }
        public function setNombre($nombre_str){
            $this->nombre_str= $nombre_str;
        }
        public function setImagen($imagen_str){
            $this->imagen_str= $imagen_str;
        }

        //-- Get´s

        public function getPrecio(){
            return $this->precio_int;
        }
        public function getNombre(){
            return $this->nombre_str;
        }
        public function getImagen(){
            return $this->imagen_str;
        }
    }

?>
