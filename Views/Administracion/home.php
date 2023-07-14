<?php include "Views/Templates/header.php"; ?>
<div class="row">
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card text-primary mb-4">
            <div class="card-body">
                <i class="fas fa-user fa-2x"></i> Usuarios
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary">
                    <i class="fas fa-user"></i>
                    <?php echo $data['usuarios']['total']; ?>
                    <span class="visually-hidden"></span>
                </span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between bg-primary">
                <a class="small text-white stretched-link" href="<?php echo base_url; ?>Usuarios">Ver detalle</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card text-success mb-4">
            <div class="card-body">
                <i class="fas fa-users fa-2x"></i> Socios
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success">
                    <i class="fas fa-users"></i>
                    <?php echo $data['clientes']['total']; ?>
                    <span class="visually-hidden"></span>
                </span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between bg-success">
                <a class="small text-white stretched-link" href="<?php echo base_url; ?>Clientes">Ver detalle</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card text-danger mb-4">
            <div class="card-body">
                <i class="fas fa-taxi fa-2x"></i> Vehiculos
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger">
                    <i class="fab fa-product-hunt"></i>
                    <?php echo $data['vehiculos']['total']; ?>
                    <span class="visually-hidden"></span>
                </span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between bg-danger">
                <a class="small text-white stretched-link" href="<?php echo base_url; ?>Vehiculos">Ver detalle</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-6">
        <div class="card text-warning mb-4">
            <div class="card-body"><i class="fas fa-tags fa-2x"></i> Tipos
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-warning">
                    <i class="fas fa-tag"></i>
                    <?php echo $data['tipos']['total']; ?>
                    <span class="visually-hidden"></span>
                </span>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between bg-warning">
                <a class="small text-white stretched-link" href="<?php echo base_url; ?>Tipos">Ver detalle</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                Reporte Grafico de Prestamos de Servicio por mes
                <select id="year" class="float-end" onchange="actualizarGrafico()">
                    <?php
                    $fecha = date('Y');
                    for ($i = 2023; $i <= $fecha; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i == $fecha) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="card-body">
                <canvas id="reporte_alquiler"></canvas>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>