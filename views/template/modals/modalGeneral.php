<!-- ======= Modal ======= -->
<div class="modal fade show" id="modalFormGeneral" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="modalFormGeneralTitle">Nuevo menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formRegistro" name="formRegistro" autocomplete="off">
                            <input type="hidden" id="id_menu" name="id_menu" />
                            <p class="text-primary">Los campos marcados con (<span class="required">*</span>) son obligatorios.</p>
                            
                            <div class="form-group">
                                <label class="control-label"><span class="required">*</span>&nbsp;Nivel del registro</label>
                                <select class="form-control" id="id_raiz" name="id_raiz" required=""></select>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><span class="required">*</span>&nbsp;Menu</label>
                                <input class="form-control" id="menu" name="menu" onkeypress="return lettersonly(event);" type="text" placeholder="Nombre del menu" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descripcion</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Descripcion del menu"></textarea>
                            </div>                                                      
                            
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="btn_action">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                    <span id="txtBtnAction">Registrar</span>
                                </button>
                                &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-danger" type="button" data-dismiss="modal">
                                    <i class="fa fa-fw fa-lg fa-times-circle"></i>
                                    Cerrar
                                </button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ======= end Modal ======= -->