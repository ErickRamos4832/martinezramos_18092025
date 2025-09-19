<?php
require("classes/conn.class.php");
require("classes/validaciones.inc.php");

class Estudiantes{
    public $idestudiante;
    public $fechanacimiento;
    public $estadoregistroestudiante;
    public $idgenero;
    public $conexion;
    public $validacion;

    public function __construct(){
        $this->conexion = new DB();
        $this->validacion = new Validaciones();
    }

    public function setIdEstudiante($idestudiante){
        $this->idestudiante = $idestudiante;
    }
    public function getIdEstudiante(){
        return $this->idestudiante;
    }

    public function setFechaNacimieto($fechanacimiento){
        $this->fechanacimiento = $fechanacimiento;
    }
    public function getFechaNacimieto(){
        return $this->fechanacimiento;
    }

    public function setEstadoRegistroEstudiante($estadoregistroestudiante){
        $this->estadoregistroestudiante = $estadoregistroestudiante;
    }
    public function getEstadoRegistroEstudiante(){
        return $this->estadoregistroestudiante;
    }

    public function setIdGenero($idgenero){
        $this->idgenero = $idgenero;
    }
    public function getIdGenero(){
        return $this->idgenero;
    }

    public function obtenerEstudiantes(){
        $resultado = $this->conexion->run('SELECT * FROM estudiante');
        $array = array("mensaje"=>"Registros econtrados","data"=>$resultado->fetchAll());
        return $array;
    }

    public function obtenerEstudiante(int $idestudiante){
        if($idestudiante > 0){
            $resultado = $this->conexion->run('SELECT * FROM estudiante WHERE id_estudiante='.$idestudiante);
            $array = array("mensaje"=>"Registros econtrados","data"=>$resultado->fetch());
            return $array;
        } else{
            $array = array("mensaje"=>"Registros NO encontrados, identificador incorrecto", "data"=>"");
            return $array;
        }
    }    
    public function nuevoEstudiante($fechanacimiento,$idgenero){
        if(!empty($idgenero) && !empty($fechanacimiento)){
            $parametros = array(
                "fecha_nac" => $fechanacimiento,
                "id_genero" => $idgenero
            );

            $resultado = $this->conexion->run('INSERT INTO estudiante(fecha_nacimiento_estudiante,id_genero)VALUES(:fecha_nac,:id_genero);',$parametros);
            if($this->conexion->n > 0 and $this->conexion->id > 0){
                $resultado = $this->obtenerEstudiante($this->conexion->id);
                $array = array("mensaje"=>"Registros encontrados","data"=>$resultado["data"]);
                return $array;
            }else{
                $array = array("mensaje"=>"Hubo un problema al registrar al estudiante","data"=>"");
                return $array;
            }
        }else{
            $array = array("mensaje"=>"Parametros enviados vacios","data"=>"");
            return $array;
        }
    }
}

?>