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

    public function obtenerPorId($id) {
        $consulta = "SELECT * FROM usuarios WHERE id = :id";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':id' => $id]);
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarDatos($id, $nombre, $email) {
        $consulta = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $sentencia = $this->db->prepare($consulta);
        return $sentencia->execute([
            ':nombre' => $nombre, 
            ':email' => $email, 
            ':id' => $id
        ]);
    }

    public function actualizarPassword($id, $password_hash) {
        $consulta = "UPDATE usuarios SET password = :password WHERE id = :id";
        $sentencia = $this->db->prepare($consulta);
        return $sentencia->execute([
            ':password' => $password_hash, 
            ':id' => $id
        ]);
    }
}
?>