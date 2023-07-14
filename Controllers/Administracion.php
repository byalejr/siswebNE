<?php

class Administracion extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $data['permisos'] = $this->model->verificarPermisos($id_user, "configuracion");
        $data['empresa'] = $this->model->getEmpresa();
        $data['monedas'] = $this->model->getMonedas(1);
        if (!empty($data['permisos']) || $id_user == 1) {
            $data['existe'] = true;
        } else {
            $data['existe'] = false;
        }
        $this->views->getView($this, "index", $data);
        
    }
    public function home()
    {
        $data['usuarios'] = $this->model->getDatos('usuarios');
        $data['clientes'] = $this->model->getDatos('clientes');
        $data['vehiculos'] = $this->model->getDatos('vehiculos');
        $data['tipos'] = $this->model->getDatos('tipos');
        $data['marcas'] = $this->model->getDatos('marcas');
        $data['empresa'] = $this->model->getEmpresaMoneda();
        $this->views->getView($this, "home", $data);
    }
    function is_valid_email($str)
    {
        return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
    }
    public function modificar()
    {
        if ($this->is_valid_email($_POST['correo'])) {
            $ruc = intval(strClean($_POST['ruc']));
            $nombre = strClean($_POST['nombre']);
            $tel = strClean($_POST['telefono']);
            $dir = strClean($_POST['direccion']);
            $correo = strClean($_POST['correo']);
            $mensaje = strClean($_POST['mensaje']);
            $moneda = strClean($_POST['moneda']);
            $id = intval(strClean($_POST['id']));
            $img = $_FILES['imagen'];
            $tmpName = $img['tmp_name'];
            if (empty($id) || empty($nombre) || empty($tel) || empty($correo) || empty($dir) || empty($moneda)) {
                $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $name = "logo.png";
                $destino = 'Assets/img/logo.png';
                $data = $this->model->modificar($ruc, $nombre, $tel, $correo, $dir, $mensaje, $name, $moneda,$id);
                if ($data == 'ok') {
                    if (!empty($img['name'])) {
                        $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
                        $formatos_permitidos =  array('png');
                        $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
                        if (!in_array($extension, $formatos_permitidos)) {
                            $msg = array('msg' => 'Imagen no permitido', 'icono' => 'warning');
                        } else {
                            move_uploaded_file($tmpName, $destino);
                            $msg = array('msg' => 'Datos modificado con éxito', 'icono' => 'success');
                        }
                    } else {
                        $msg = array('msg' => 'Datos modificado con éxito', 'icono' => 'success');
                    }
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }else{
            $msg = array('msg' => 'Ingrese un correo valido', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function permisos()
    {
        $this->views->getView($this, "permisos");
    }
    //Monedas
    public function moneda()
    {
        $id_user = $_SESSION['id_usuario'];
        $data['permisos'] = $this->model->verificarPermisos($id_user, "crear_moneda");
        if (!empty($data['permisos']) || $id_user == 1) {
            $data['existe'] = true;
        } else {
            $data['existe'] = false;
        }
        $this->views->getView($this, 'moneda', $data);
    }
    public function listarMonedas()
    {
        $id_user = $_SESSION['id_usuario'];
        $data = $this->model->getMonedas(1);
        $modificarMoneda = $this->model->verificarPermisos($id_user, "editar_moneda");
        $eliminar_moneda = $this->model->verificarPermisos($id_user, "eliminar_moneda");
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['editar'] = '';
            $data[$i]['eliminar'] = '';
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            if (!empty($modificarMoneda) || $id_user == 1) {
                $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarMoneda(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            }
            if (!empty($eliminar_moneda) || $id_user == 1) {
                $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarMoneda(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrarMoneda()
    {
        $simbolo = strClean($_POST['simbolo']);
        $nombre = strClean($_POST['nombre']);
        $id = strClean($_POST['id']);
        if ($id == '') {
            $data = $this->model->registrarMoneda($simbolo, $nombre);
            if ($data == 'ok') {
                $msg = array('msg' => 'Moneda registrado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
            }
        } else {
            $data = $this->model->modificarMoneda($simbolo, $nombre, $id);
            if ($data == "modificado") {
                $msg = array('msg' => 'Moneda modificado con éxito', 'icono' => 'success');
            } else {
                $msg = "Error al modificar la moneda";
                $msg = array('msg' => 'Error al modificar la moneda', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editarMoneda(int $id)
    {
        $data = $this->model->editarMoneda($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminarMoneda(int $id)
    {
        $data = $this->model->accionMoneda(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Moneda dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el cliente', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresarMoneda(int $id)
    {
        $data = $this->model->accionMoneda(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Moneda reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar la moneda', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactivos()
    {
        $id_user = $_SESSION['id_usuario'];
        $data['permisos'] = $this->model->verificarPermisos($id_user, "restaurar_moneda");
        if (!empty($data['permisos']) || $id_user == 1) {
            $data['existe'] = true;
        } else {
            $data['existe'] = false;
        }
        $data['monedas'] = $this->model->getMonedas(0);
        $this->views->getView($this, "inactivos", $data);
    }
    public function actualizarGrafico($anio)
    {
        $desde = $anio . '-01-01';
        $hasta = $anio . '-12-31';
        $data = $this->model->getalquiler($desde, $hasta);
        echo json_encode($data);
        die();
    }
}