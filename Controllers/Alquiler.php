<?php

use Luecano\NumeroALetras\NumeroALetras;

class Alquiler extends Controller
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
        $alquiler = $this->model->verificarPermisos($id_user, "alquiler");
        $reporte = $this->model->verificarPermisos($id_user, "reportes_alquiler");
        if (!empty($alquiler) || $id_user == 1) {
            $data['existe'] = true;
        } else {
            $data['existe'] = false;
        }
        if (!empty($reporte) || $id_user == 1) {
            $data['reporte'] = true;
        } else {
            $data['reporte'] = false;
        }
        $data['vehiculos'] = $this->model->getVehiculos();
        $data['documentos'] = $this->model->getDoc();
        $this->views->getView($this, "index", $data);
    }
    public function registrar()
    {
        $id_cli = strClean($_POST['id_cli']);
        $id_veh = strClean($_POST['id_veh']);
        $select_cliente = strClean($_POST['select_cliente']);
        $select_vehiculo = strClean($_POST['select_vehiculo']);
        $numero = strClean($_POST['numero']);
        $precio = strClean($_POST['precio']);
        $abono = strClean($_POST['abono']);
        $fecha = strClean($_POST['fecha']);
        $hora = strClean($_POST['hora']);
        $documento = strClean($_POST['documento']);
        $observacion = strClean($_POST['observacion']);
        if (empty($id_cli) || empty($id_veh) || empty($select_cliente) ||empty($select_vehiculo)
        || empty($numero) || empty($precio) ||empty($abono) ||empty($fecha) ||empty($hora) || empty($documento)) {
            $msg = array('msg' => 'Todo los campos con * son requeridos', 'icono' => 'warning');
        } else {
            $fecha_devolucion = date("Y-m-d", strtotime($fecha . '+ ' . $numero . ' days'));
            $data = $this->model->registrarAlquiler($id_cli, $id_veh, $numero, $precio, $abono, $fecha, $hora, $fecha_devolucion, $documento, $observacion);
            if ($data > 0) {
                $vehiculo = $this->model->actualizarVehiculo(2, $id_veh);
                if ($vehiculo == 'ok') {
                    $msg = array('msg' => 'Alquiler registrado con éxito', 'icono' => 'success', 'id_alquiler' => $data);
                }else{
                    $msg = array('msg' => 'Error al actualizar el estado', 'icono' => 'error');
                }
            } else if ($data == "existe") {
                $msg = array('msg' => 'El alquiler ya esta registrado', 'icono' => 'warning');
            } else {
                $msg = array('msg' => 'Error al registrar el cliente', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar()
    {
        $data = $this->model->getAlquiler();
        $id_user = $_SESSION['id_usuario'];
        $recibir = $this->model->verificarPermisos($id_user, "recibir_prestamo");
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['f_prestamo'] = '<span class="badge bg-primary">' . $data[$i]['fecha_prestamo'] .'</span>';
            $data[$i]['f_devolucion'] = '<span class="badge bg-info">' . $data[$i]['fecha_devolucion'] . '</span>';
            $data[$i]['recibir'] = '';
            $data[$i]['accion'] = '';
            if ($data[$i]['estado'] == 1) {
                if (!empty($recibir) || $id_user == 1) {
                    $data[$i]['recibir'] = '<button class="btn btn-outline-primary" type="button" onclick="entrega(' . $data[$i]['id'] . ');"><i class="fas fa-sync-alt"></i></button>';
                    $data[$i]['accion'] = '<a class="btn btn-outline-danger" target="_blank" href="' . base_url . 'Alquiler/pdfPrestamo/' . $data[$i]['id'] . '"><i class="fas fa-file-pdf"></i></a>';
                }
                $data[$i]['estatus'] = '<span class="badge bg-warning">Ocupado</span>';
            } else {
                if (!empty($recibir) || $id_user == 1) {
                   $data[$i]['accion'] = '<a class="btn btn-outline-danger" target="_blank" href="' . base_url . 'Alquiler/pdfPrestamo/' . $data[$i]['id'] . '"><i class="fas fa-file-pdf"></i></a>';
                }
                $data[$i]['estatus'] = '<span class="badge bg-success">Libre</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ver(int $id)
    {
        $data = $this->model->verPrestamo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function procesar(int $id)
    {
        if (is_numeric($id)) {
            $data = $this->model->procesarEntrega(0, $id);
            if ($data == 'ok') {
                $id_veh = $this->model->verPrestamo($id);
                $accion = $this->model->actualizarVehiculo(1, $id_veh['id_veh']);
                if ($accion == 'ok') {
                    $msg = array('msg' => 'Procesado con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al recibir el prestamo', 'icono' => 'error');
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function pdfPrestamo($id)
    {
        $empresa = $this->model->getEmpresa();
        $data = $this->model->verPrestamo($id);
        require('Libraries/fpdf/html2pdf.php');

        $pdf = new PDF_HTML('P', 'mm', array(210, 148));
        $pdf->AddPage();
        $pdf->SetMargins(10, 0, 0);
        $pdf->SetTitle('Reporte Pago');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(135, 8, utf8_decode($empresa['nombre']), 0, 1, 'C');
        //$pdf->Image('Assets/img/logo.png', 50, 16, 20, 20);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, 'Nit: ', 0, 0, 'L');
        $pdf->Cell(50, 5, $empresa['ruc'], 0, 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->Cell(50, 5, $empresa['telefono'], 0, 1, 'L');
        $pdf->Cell(20, 5, utf8_decode('Correo: '), 0, 0, 'L');
        $pdf->Cell(50, 5, utf8_decode($empresa['correo']), 0, 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->Cell(50, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');
        $pdf->Cell(20, 5, 'Fecha: ', 0, 0, 'L');
        $pdf->Cell(50, 5, $data['fecha_prestamo'], 0, 0, 'L');
        if ($data['estado'] == 1) {
            $pdf->SetTextColor(255,0,0);
            $estado = 'Ocupado';
        }else{
            $pdf->SetTextColor(0, 0, 255);
            $estado = 'Libre';
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'Estado: ', 0, 0, 'L');
        $pdf->Cell(50, 5, $estado, 0, 1, 'L');
        //Encabezado
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(135, 10, 'Datos del Socio', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 5, 'DOC: ' . $data['dni'], 1, 0, 'L');
        $pdf->Cell(95, 5, 'NOMBRE: ' . utf8_decode($data['nombre']), 1, 1, 'L');
        $pdf->Cell(65, 5, utf8_decode('DIRECCIÓN: ' . $data['direccion']), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('TELÉFONO: ' . $data['telefono']), 1, 1, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(135, 10, utf8_decode('Datos del Vehículo'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(65, 5, utf8_decode('PLACA: ' . $data['placa']), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('VEHÍCULO: ' . $data['tipo']), 1, 1, 'L');
        $pdf->Cell(65, 5, utf8_decode('MÓDELO: ' . $data['modelo']), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('CANT. DIAS: ' . $data['num_dias']), 1, 1, 'L');
        $pdf->Cell(65, 5, utf8_decode('COSTO TOTAL: ' . $data['precio_dia']), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('ABONADO: ' . $data['abono']), 1, 1, 'L');
        $pdf->Cell(65, 5, utf8_decode('F. PRESTAMO: ' . $data['fecha_prestamo']), 1, 0, 'L');
        $pdf->Cell(70, 5, utf8_decode('F. DEVOLUCIÓN: ' . $data['fecha_devolucion']), 1, 1, 'L');
        $pdf->Ln();
        if ($data['estado'] == 0) {
            $total = 0;
        }else{
            $total = ($data['num_dias'] * $data['precio_dia']) - $data['abono'];
        }
        //$pdf->Cell(135, 5, utf8_decode('PENDIENTE: ' . $total), 0, 1, 'C');
        require 'vendor/autoload.php';
        $formatter = new NumeroALetras();
        //$pdf->MultiCell(135, 5, $formatter->toMoney($total, 2, '', ''), 0, 'R');
        $pdf->Ln();
        $pdf->Cell(65, 5, utf8_decode('_____________________________'), 0, 0, 'C');
        $pdf->Cell(65, 5, utf8_decode('_____________________________'), 0, 1, 'C');
        $pdf->Cell(65, 5, utf8_decode('Firma Administrativa'), 0, 0, 'C');
        $pdf->Cell(65, 5, utf8_decode('Firma socio'), 0, 1, 'C');
        $pdf->WriteHtml(utf8_decode($empresa['mensaje']));

        $pdf->Output();
    }
    public function pdfAlquiler($accion)
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "reportes_alquiler");
        if (!empty($perm) || $id_user == 1) {
            $empresa = $this->model->getEmpresa();
            if ($accion == 'all') {
                $alquiler = $this->model->getAlquiler();
            } else {
                $array = explode(',', $accion);
                $desde = $array[0];
                $hasta = $array[1];
                $alquiler = $this->model->filtroAlquiler($desde, $hasta);
            }
            if (empty($alquiler)) {
                echo 'No hay registro';
            } else {
                require('Libraries/fpdf/fpdf.php');
                include('Libraries/phpqrcode/qrlib.php');
                $pdf = new FPDF('L', 'mm', 'A4');
                $pdf->AddPage();
                $pdf->SetMargins(5, 0, 0);
                $pdf->SetTitle('Reporte Alquiler');
                $pdf->SetFont('Arial', '', 15);
                $pdf->Cell(280, 8, utf8_decode($empresa['nombre']), 0, 1, 'C');
                QRcode::png($empresa['ruc'], 'Assets/qr.png');
                $pdf->Image('Assets/qr.png', 140, 18, 25, 25);
                $pdf->Image('Assets/img/logo.png', 250, 10, 25, 25);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(25, 5, 'Ruc: ', 0, 0, 'L');
                $pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');
                $pdf->Cell(25, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
                $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');
                $pdf->Cell(25, 5, utf8_decode('Correo: '), 0, 0, 'L');
                $pdf->Cell(20, 5, utf8_decode($empresa['correo']), 0, 1, 'L');
                $pdf->Cell(25, 5, utf8_decode('Dirección: '), 0, 0, 'L');
                $pdf->Cell(20, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');
                $pdf->Ln(10);
                //Encabezado
                $pdf->SetFillColor(0, 0, 0);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(289, 5, 'Detalle de Servicio de Transporte', 1, 1, 'C', true);
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(155, 155, 155);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->Cell(30, 5, 'Doc. Garantia', 1, 0, 'L', true);
                $pdf->Cell(50, 5, 'Cliente', 1, 0, 'L', true);
                $pdf->Cell(30, 5, 'Placa', 1, 0, 'L', true);
                $pdf->Cell(40, 5, utf8_decode('Vehículo'), 1, 0, 'L', true);
                $pdf->Cell(25, 5, utf8_decode('Módelo'), 1, 0, 'L', true);
                $pdf->Cell(25, 5, 'F. Prestamo', 1, 0, 'L', true);
                $pdf->Cell(25, 5, 'F. Entrega', 1, 0, 'L', true);
                $pdf->Cell(22, 5, utf8_decode('Cant. Días'), 1, 0, 'L', true);
                $pdf->Cell(22, 5, utf8_decode('Costo de Servicio'), 1, 0, 'L', true);
                $pdf->Cell(20, 5, 'Estado', 1, 1, 'L', true);
                $pdf->SetTextColor(0, 0, 0);
                foreach ($alquiler as $row) {
                    $pdf->Cell(30, 5, utf8_decode($row['documento']), 1, 0, 'L');
                    $pdf->Cell(50, 5, utf8_decode($row['nombre']), 1, 0, 'L');
                    $pdf->Cell(30, 5, $row['placa'], 1, 0, 'L');
                    $pdf->Cell(40, 5, utf8_decode($row['tipo']), 1, 0, 'L');
                    $pdf->Cell(25, 5, utf8_decode($row['modelo']), 1, 0, 'L');
                    $pdf->Cell(25, 5, $row['fecha_prestamo'], 1, 0, 'L');
                    $pdf->Cell(25, 5, $row['fecha_devolucion'], 1, 0, 'L');
                    $pdf->Cell(22, 5, $row['num_dias'], 1, 0, 'L');
                    $pdf->Cell(22, 5, $row['precio_dia'], 1, 0, 'L');
                    if ($row['estado'] == 1) {
                        $pdf->SetTextColor(255, 0, 0);
                        $pdf->Cell(20, 5, 'Ocupado', 1, 1, 'L');
                    }else{
                        $pdf->SetTextColor(0, 255, 0);
                        $pdf->Cell(20, 5, 'Libre', 1, 1, 'L');
                    }
                    $pdf->SetTextColor(0, 0, 0);
                }
                $pdf->Output();
            }
        } else {
            header('Location: Administracion/permisos');
        }
    }
}
