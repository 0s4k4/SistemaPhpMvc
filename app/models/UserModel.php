<?php
Class UserModel {

    private $db;

    public function __construct()
    {
        
        //establecemos la base de datos
        $host = 'localhost';
        $dbname = 'ejemplo';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username,$password);
        } catch (PDOException $e) {
            exit('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function registrarUsuario($nombre,$email,$contrasena) {
        ///verificamos si el email ya esta regidtrado

        $query = "SELECT id FROM usuario where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$email);
        $stmt->execute();


        if($stmt->rowCount() > 0 ) {
            return false;   //el email ya se encuentra en uso
        }

        ///se inserta el  nuevo usuario en la base de datos

        $query = "INSERT INTO usuarios (nombre,email,contraseña) VALUES (:nombre,:email,:contrasena)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nombre',$nombre);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':contrasena',$contrasena);


        return  $stmt->execute();
    }


    public function verificarCredenciales($email,$contrasena)
    {
        //verificamos las credenciales del usuario

        $query = "SELECT id FROM usuarios where email = :email AND contraseña = :contrasena";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':contrasena',$contrasena);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return true; ///las credenciales son correctas
        }

        return false; //las credenciales no son validas
    }
}



?>