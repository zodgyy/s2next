        <!-- ======= Footer ======= -->
        <div id="preloader"></div>
        
        <!-- Vendor JS Files -->
        <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/dataTables/dataTables.bootstrap.min.js" type="text/javascript"></script>        
        <script src="<?php echo base_url();?>assets/vendor/sweetalert/sweetalert.min.js" type="text/javascript"></script>
        
        <!-- Main JS File -->
        <script src="<?php echo base_url();?>assets/js/public.js" type="text/javascript"></script>
        
        <?php
        // Se pueden agregar mas JS dependiendo de los controladores
        if (isset($data['page_function_js']) && trim($data['page_function_js']) !== '') {
            print('<script src="' . base_url() . 'assets/js/' . $data['page_function_js'] . '" type="text/javascript"></script>');
        }
        ?>
        <!-- ======= end Footer ======= -->
    </body>
</html>