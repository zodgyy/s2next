<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#009688">
        <title>Pagina Error - <?php echo $data['page_name'];?></title>
              
        <!-- Main CSS-->
        <link href="<?php echo base_url();?>assets/css/public.css" rel="stylesheet" type="text/css"/>
        <!-- Font-icon css-->
        <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="text-align: center;" class="app sidebar-mini">    
        
        <div class="page-error">
            <img src="<?php echo base_url();?>assets/img/logo.jpg" height="180" alt=""/>
            <h1><i class="fa fa-exclamation-circle"></i> Error 404: Pagina no encontrada</h1>
            <p>La pagina que solicito no se encontro.</p>
            <p><a href="javascript:window.history.back();">Go Back</a></p>
        </div>
        
        <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </body>
</html>