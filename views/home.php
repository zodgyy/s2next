<?php 
// Incluimos cabecera
head($data); 
// Incluimos modal general
getModal('modalGeneral', $data);
?>    
<!-- ======= Body ======= -->    
<main class="app-content">
    
    <div class="app-title">
        <div>                 
            <h1 class="text-center">Administración de menus</h1>
            <h3 class="text-right">
                <button class="btn btn-primary" type="button" onclick="nuevoRegistro();"><i class="fa fa-plus-circle"></i> Nuevo menu</button>
            </h3> 
        </div>
    </div>
    
    <div class="row">

        <div class="col-md-3" style="background-color: white;">
            <h1>Menu (ARBOL)</h1>
            <ul class="vertical-menu">
                <?php echo printMenu(json_decode($data['parametros']['menus'], true)); ?>                
            </ul>            
        </div>

        <div class="col-md-9">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive" style="background-color: #fff;">
                        <table id="tableRegistros" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">MENU</th>
                                    <th class="text-center">NIVEL</th>
                                    <th class="text-center">MENU PADRE</th>
                                    <th class="text-center">DESCRIPCION</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ======= end Body ======= -->
<?php foot($data);