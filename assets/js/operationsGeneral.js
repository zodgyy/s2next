var tableRegistros;
var formRegistro = document.querySelector("#formRegistro");
// Creamos objeto AJAX
var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

window.addEventListener('load', function() {
    // Cargador de menus pre registrados para el SELECT del modal y llenar el SELECTBOX
    getMenus();
}, false);

document.addEventListener('DOMContentLoaded', function() {
    // Utilizamos el plugin DataTable https://datatables.net/ para la presentación de la tabla
    tableRegistros = $('#tableRegistros').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "responsive": true,
        "bDestroy": true,
        "paging": true,
        "searching": false,
        "ordering": false,
        "iDisplayLength": 25,
        "language": {
            "url": "" + base_url + "assets/js/langs/es.json"
        },
        "ajax": {
            "url": "" + base_url + "home/getRegistrosMenu",
            "dataSrc" : ""
        },
        "columns": [
            {"data": "id_menu", sClass: "text-center"},
            {"data": "menu"},
            {"data": "nivel", sClass: "text-center"},
            {"data": "menu_padre"},
            {"data": "descripcion"},
            {"data": "options"}
        ]        
    });
    
    //Nuevo registro 
    if(typeof(formRegistro) !== 'undefined' && formRegistro !== null) {
        
        formRegistro.onsubmit = function(e) {
            e.preventDefault(); 

            var id_raiz = document.querySelector("#id_raiz").value;
            var menu = document.querySelector("#menu").value;

            // validamos que esten llenos los campos importantes
            if (id_raiz == '' || menu == '') {
                swal("Atencion", "los campos marcados (*) son requeridos", "error");
                return false;
            }
            
            var ajaxURL = base_url + 'home/setRegistro';
            var formData = new FormData(formRegistro);
            // Enviamos los datos del formulario via AJAX al controlador
            request.open("POST", ajaxURL, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState === 4 && request.status === 200) {
                    console.log(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        formRegistro.reset();
                        reloadTable();                         
                        swal("Registro", objData.msg, "success");                    
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }         
            };
        };
    }        
});

function editarRegistro(id_menu) {
    
    if (id_menu !== "") { 
        
        document.querySelector('#modalFormGeneralTitle').innerHTML = "Actualizar menu";
        document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');
        document.querySelector('#btn_action').classList.replace('btn-primary', 'btn-info');
        document.querySelector("#txtBtnAction").innerHTML = "Actualizar";
        
        var ajaxURL = base_url + 'home/getRegistro/' + id_menu;
        // obtenemos datos
        request.open("GET", ajaxURL, true);
        request.send();
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status === 200) {
                console.log(request.responseText);
                var objData = JSON.parse(request.responseText);
                if (objData.status) {  
                    
                    console.log(objData.data);
                    document.querySelector("#id_menu").value = objData.data.id_menu;
                    document.querySelector("#id_raiz").value = objData.data.id_raiz;
                    document.querySelector("#menu").value = objData.data.menu;
                    document.querySelector("#descripcion").value = objData.data.descripcion;
                                        
                } else {
                    swal("Error", objData.msg, "error");
                }
            }            
        };

        $('#modalFormGeneral').modal('show');

    }
}

function borrarRegistro(id_menu) {
    
    if (id_menu !== "") { 
        
        swal({
            closeOnClickOutside: false,
            title: "Eliminar menu",
            text: "Si elimina un menu padre, se eliminaran los menus hijos.\n¿Realmente quiere eliminar este menu?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnConfirm: false,
        })
        .then((willDelete) => {
            if (willDelete) {
                var ajaxURL = base_url + 'home/delRegistro/' + id_menu;
                // obtenemos datos
                request.open("POST", ajaxURL, true);
                request.send();
                request.onreadystatechange = function() {
                    if(request.readyState === 4 && request.status === 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) { 
                            reloadTable();
                            swal("¡Eliminar!", objData.msg, "success");
                            //tableRegistros.ajax.reload( null, false );
                            
                        } else {
                            swal("Error", objData.msg, "error");
                        }
                    }            
                };
            } 
        });        
    }
}

function nuevoRegistro() {
    
    document.querySelector("#id_menu").value = "";
    document.querySelector('#modalFormGeneralTitle').innerHTML = "Nuevo menu";
    document.querySelector('.modal-header').classList.replace('headerUpdate', 'headerRegister');
    document.querySelector('#btn_action').classList.replace('btn-info', 'btn-primary');
    document.querySelector("#txtBtnAction").innerHTML = "Registrar";
    
    formRegistro.reset();
    
    $('#modalFormGeneral').modal('show');
}

function closeModal() {
    formRegistro.reset();
    $('#modalFormGeneral').modal('hide');
}

function reloadTable() {
    closeModal();
    tableRegistros.ajax.reload( null, false );
    // Recargador de la pagina para refrescar el menu arbol
    setTimeout(function(){
        window.location.href = window.location.href;
    }, 1000);
}

function getMenus() {
    
    var ajaxURL = base_url + 'home/getSelectRegistros';
    // obtenemos datos
    request.open("GET", ajaxURL, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState === 4 && request.status === 200) {
            document.querySelector("#id_raiz").innerHTML = request.responseText;
        }
    };
}