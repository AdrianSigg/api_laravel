<?php
    namespace App\Models;
    class Catalogo
    {
        //----- Atributos
        private $id_str;
        private $id_producto_str;
        private $nombre_str;
        private $precio_int;
        private $imagen_str;
        private $descripcion_str;
        private $cantidad_str;
        private $talla_str;
        private $color_str;

        //---- Set´s
        public function setId($id_str){
            $this->id_str=$id_str;
        }
        public function setIdProducto($id_producto_str){
            $this->id_producto_str=$id_producto_str;
        }
        public function setPrecio($precio_int){
            $this->precio_int=$precio_int;
        }
        public function setNombre($nombre_str){
            $this->nombre_str= $nombre_str;
        }
        public function setImagen($imagen_str){
            $this->imagen_str= $imagen_str;
        }
        public function setDescripcion($descripcion_str){
            $this->descripcion_str= $descripcion_str;
        }
        public function setCantidad($cantidad_str){
            $this->cantidad_str= $cantidad_str;
        }
        public function setTalla($talla_str){
            $this->talla_str= $talla_str;
        }
        public function setColor($color_str){
            $this->color_str= $color_str;
        }

        //-- Get´s
        public function getId(){
            return $this->id_str;
        }
        public function getProducto(){
            return $this->id_producto_str;
        }
        public function getPrecio(){
            return $this->precio_int;
        }
        public function getNombre(){
            return $this->nombre_str;
        }
        public function getImagen(){
            return $this->imagen_str;
        }
        public function getDescripcion(){
            return $this->descripcion_str;
        }
        public function getCantidad(){
            return $this->cantidad_str;
        }
        public function getTalla(){
            return $this->talla_str;
        }
        public function getColor(){
            return $this->color_str;
        }
    }

?>
