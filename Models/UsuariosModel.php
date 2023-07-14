<?php
class UsuariosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuario(string $usuario, string $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $data = $this->select($sql);
        return $data;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function getUsuarios(int $estado)
    {
        $sql = "SELECT id,usuario,nombre,correo,estado FROM usuarios WHERE estado = $estado";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarUsuario(string $usuario, string $nombre, string $correo, string $telefono, string $clave)
    {
        $vericar = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR correo = '$correo'";
        $existe = $this->select($vericar);
        if (empty($existe)) {
            # code...
            $sql = "INSERT INTO usuarios(usuario, nombre, correo,telefono, clave) VALUES (?,?,?,?,?)";
            $datos = array($usuario, $nombre, $correo, $telefono, $clave);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }
        return $res;
    }
    public function modificarUsuario(string $usuario, string $nombre, string $correo, string $tele, int $id)
    {
        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, correo= ?, telefono=? WHERE id = ?";
        $datos = array($usuario, $nombre, $correo, $tele, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarUser(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function getPass(string $clave, int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionUser(int $estado, int $id)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function modificarPass(string $clave, int $id)
    {
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = array($clave, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function getPermisos()
    {
        $sql = "SELECT * FROM permisos";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getDetallePermisos(int $id)
    {
        $sql = "SELECT * FROM detalle_permisos WHERE id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function deletePermisos(int $id)
    {
        $sql = "DELETE FROM detalle_permisos WHERE id_usuario = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function actualizarPermisos(int $usuario, int $permiso)
    {
        $sql = "INSERT INTO detalle_permisos(id_usuario, id_permiso) VALUES (?,?)";
        $datos = array($usuario, $permiso);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $sql = "SELECT p.id, p.permiso, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$permiso'";
        $existe = $this->select($sql);
        return $existe;
    }
    public function listarPermisos($id_user)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getCorreo(string $correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $data = $this->select($sql);
        return $data;
    }
    public function getToken(string $token)
    {
        $sql = "SELECT * FROM usuarios WHERE token = '$token'";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizarToken(string $token, string $correo)
    {
        $sql = "UPDATE usuarios SET token = ? WHERE correo = ?";
        $datos = array($token, $correo);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function resetearPass(string $clave, int $id, string $token)
    {
        $sql = "UPDATE usuarios SET clave = ?, token = ? WHERE id = ? AND token = ?";
        $datos = array($clave, '', $id, $token);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function modificarDato(string $usuario, string $nombre,string $apellido, string $correo, string $tel, string $dir, string $img, int $id)
    {
        $sql = "UPDATE usuarios SET usuario=?, nombre=?, apellido=?, correo=?, telefono=?, direccion=?, perfil=? WHERE id=?";
        $datos = array($usuario, $nombre, $apellido, $correo, $tel, $dir, $img, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = 1;
        }else{
            $res = 0;
        }
        return $res;
    }
}
?>