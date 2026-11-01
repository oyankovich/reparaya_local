<?php
class Usuario {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodosLosUsuarios() {
        $consulta = "SELECT * FROM usuarios";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarUsuario($nombre, $email, $passwordHash, $telefono) {
        try {

            $consulta = "INSERT INTO usuarios (nombre, email, password, telefono) 
                         VALUES (:nombre, :email, :password, :telefono)";
            
            $sentencia = $this->db->prepare($consulta);
            
            $resultado = $sentencia->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':password' => $passwordHash,
                ':telefono' => $telefono
            ]);

            return $resultado; 

        } catch (PDOException $e) {
            return false;
        }
    }

    public function buscarPorEmail($email) {
        
        $consulta = "SELECT * FROM usuarios WHERE email = :email";
        
        $sentencia = $this->db->prepare($consulta);
        
        $sentencia->execute([':email' => $email]);
        
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}
?>