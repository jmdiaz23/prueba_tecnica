<?php

namespace App;

class Producto{
    private $config;
    private $cn =null;

    public function __construct(){
        $this->config=parse_ini_file (__DIR__.'/../config.ini');

        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(\PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8'));
            
    }


    public function registrar($params){
        $sql= "INSERT INTO `producto`( `titulo`, `descripcion`, `foto`, `precio`, `categoria_id`, `fecha`) VALUES (:titulo,:descripcion,:foto,:precio,:categoria_id,:fecha)";

        $resultado =$this->cn->prepare($sql);

        $_array=array(

            ":titulo"=>$params['titulo'],
            ":descripcion"=>$params['descripcion'],
            ":foto"=>$params['foto'],
            ":precio"=>$params['precio'],
            ":categoria_id"=>$params['categoria_id'],
            ":fecha"=>$params['fecha']

        );
        if($resultado->execute($_array)){
            return true;
        }else{
            return false;
        }
            


    }

    public function actualizar($params){

        $sql= "UPDATE `producto` SET `titulo`=:titulo,`descripcion`=:descripcion,`foto`=:foto,`precio`=:precio,`categoria_id`=:categoria_id,`fecha`=:fecha WHERE `id`=:id ";

        $resultado =$this->cn->prepare($sql);

        $_array=array(

            ":titulo"=>$params['titulo'],
            ":descripcion"=>$params['descripcion'],
            ":foto"=>$params['foto'],
            ":precio"=>$params['precio'],
            ":categoria_id"=>$params['categoria_id'],
            ":fecha"=>$params['fecha'],
            ":id"=>$params['id']

        );
        if($resultado->execute($_array)){
            return true;
        }else{
            return false;
        }

    }

    public function eliminar($id){
        $sql = "DELETE FROM `producto` WHERE `id`=:id ";

        $resultado = $this->cn->prepare($sql);
        
        $_array = array(
            ":id" =>  $id
        );

        if($resultado->execute($_array))
            return true;

        return false;
    }

    public function mostrar(){

        $sql="SELECT producto.id, titulo,descripcion,foto,nombre,precio,fecha,estado FROM `producto` 
        
        INNER JOIN categorias
        ON producto.categoria_id = categorias.id ORDER BY producto.id DESC
        ";
        $resultado =$this->cn->prepare($sql);

       
        if($resultado->execute()){
            return $resultado->fetchAll();
        }else{
            return false;
        }

    }

    public function mostrarPorId($id){

        $sql="SELECT * FROM `producto` WHERE `id`=:id ";
        
        $resultado =$this->cn->prepare($sql);

        $_array=array(

          
            ":id"=> $id

        );

       
        if($resultado->execute($_array)){
            return $resultado->fetch();
        }else{
            return false;
        }


    }

}