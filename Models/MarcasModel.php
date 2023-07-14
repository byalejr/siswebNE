<?php
class MarcasModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMarcas(int $estado)
    {
        $sql = "SELECT * FROM marcas WHERE estado = $estado";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarMarca(string $marca)
    {
        $verficar = "SELECT * FROM marcas WHERE marca = '$marca'";
        $existe = $this->select($verficar);
        if (empty($existe)) {
            $sql = "INSERT INTO marcas(marca) VALUES (?)";
            $datos = array($marca);
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
    public function modificarMarca(string $marca, int $id)
    {
        $sql = "UPDATE marcas SET marca = ? WHERE id = ?";
        $datos = array($marca, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarMarca(int $id)
    {
        $sql = "SELECT * FROM marcas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionMarca(int $estado, int $id)
    {
        $sql = "UPDATE marcas SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $sql = "SELECT p.id, p.permiso, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$permiso'";
        $existe = $this->select($sql);
        return $existe;
    }
}
