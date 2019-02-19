<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="<?php print base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?php print base_url("assets/css/mdb.min.css"); ?>" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="<?php print base_url("assets/css/style.css"); ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    
</head>
<body>
    <div class="container">
        <div class="card first-card col-sm-8">
            <div class="card-body col-sm-12">
                <div class="row">
                    <form  id= "Reg" name = "Reg" class="well span8" method="post" action="">
                        <label>Nombre de dominio</label>
                        <input id="dominio" name="dominio" class="span3" placeholder= "Ejemplo: instagram, facebook, twitter" type="text"> 
                        <button class="btn btn-primary pull-right" type="submit">Guardar.</button>
                    </form>
                </div>

                <div class="row col-sm-12">
                    <table id="tableDominios" class="table table-striped table-bordered table-sm" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre de dominio</th>
                                <th>Estado</th>
                                <th>   </th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDominios">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Editar elemento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="Edit" name ="Edit" class="well span8" method="post" action="">
                <div class="modal-body">
                    <input  type="hidden" id="itemid" name="itemid">

                    <div class="form-group">
                        <label for="edit-name">Nombre del sitio:</label>
                        <input  class="form-control" id="edit-name" name="edit-name">
                        <small id="errname" class="small-error" hidden>El nombre del sitio no puede ir vacío.</small>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="edit-status" name="edit-status">
                            <option value="2" disabled selected>Elegir estado</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <small id="errstatus" class="small-error" hidden>Debe elegir un status válido para éste sitio.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <div><button id="BtnUpdate" type="submit" class="btn btn-primary" >Guardar</button>
                        <button id="BtnHideModal" type="button" class="btn btn-secondary" >Cerrar</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Modal Edit -->

    <!-- Modal Delete -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Eliminar elemento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form  id="Delete" name ="Delete" class="well span8" method="post" action="">
            <div class="modal-body">

                <input  id="itemidDelete" name="itemidDelete" hidden>
                <div class="form-group">
                <p>¿Desea eliminar el sitio: <label id="siteToDelete" class="msg-delete"></label> de su lista?</p>
                </div>
            </div>
            <div class="modal-footer">
                 <button id="BtnDelete" type="submit" class="btn btn-primary">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- Close Modal Delete -->

<!-- SCRIPTS -->
<!-- JQuery -->

<script type="text/javascript" src="<?php print base_url("assets/js/jquery-3.3.1.min.js"); ?>"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php print base_url("assets/js/popper.min.js"); ?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php print base_url("assets/js/bootstrap.min.js"); ?>"></script>



<script type="text/javascript">

function alreadyExist(name) {
    
}

    function getData() {
        $.get( "http://localhost:8080/Squid-proxy/index.php/Proxy/get", function( data ) {

            $('#tableDominios tbody').empty();
            console.log(data);
            data.map(function(row){
                var valor = '<tr>' +
                '<td >' + row.site + '</td>' +
                '<td >' + (row.status>0?'HABILITADO':'DESHABILITADO') + '</td>' +
                '<td style="width: 200px"><button onClick="getById(\'' + row.itemid + '\')"  class="btn btn-info btn-sm my-0 editbtn"><i class=" fa-2x fas fa-pen-square"></i></button>'+
                '<button onClick="getByIdDelete(\'' + row.itemid + '\')" class="btn btn-danger btn-sm my-0"><i class="fa-2x far fa-window-close" data-toggle="modal" data-target="#ModalDelete"></i></button></td>' +
                '</tr>';
                $("#tbodyDominios").append(valor);

            });

        }, "json" );
    }



    function getById(id)
    {   
        $.get( "http://localhost:8080/Squid-proxy/index.php/Proxy/getById/"+id, function( data ) {

            console.log(data);
            data.map(function(row){

                let site =  row.site;
                $('#ModalEdit').modal('show');
                document.getElementById('edit-name').value = site;
                document.getElementById('itemid').value = id;

            });

        }, "json" );
    }

    function getByIdDelete(id) {
        
         $.get( "http://localhost:8080/Squid-proxy/index.php/Proxy/getById/"+id, function( data ) {

            console.log(data);
            data.map(function(row){

                let site =  row.site;
                $('#ModalDelete').modal('show');
                 $('#siteToDelete').text(site);
                document.getElementById('itemidDelete').value = id;
              

            });

        }, "json" );

    }


    $(document).ready(function() {

        var errstatus = document.getElementById('errstatus');
        var errname = document.getElementById('errname');

        $("#BtnHideModal").click(function() {

           $('#ModalEdit').modal('hide');
          $("#errstatus").attr("hidden", true);
           $("#errname").attr("hidden", true);
       });

        $( "#edit-status" ).change(function() {
            $("#errstatus").attr("hidden", true);
        }); 

//EDIT - UPDATE SITE FUNCTION 
    $('#Edit').submit(function(event) { //Trigger on form submit
            let site = document.getElementById('edit-name').value;
            let status = document.getElementById('edit-status').value;
            if(status=='2'){
               errstatus.removeAttribute('hidden');
                event.preventDefault();
            }
            else if(site=="") {
                errname.removeAttribute('hidden');
                event.preventDefault();
            }
        
        else {

      var frm=$("#Edit"); //Identify form by id 
      var datos = frm.serialize();  //Serialize data 
        //AJAX PETITION 
        $.ajax({
            url: "http://localhost:8080/Squid-proxy/index.php/Proxy/updateSite",
            method: 'POST',
            data: datos,
            dataType: "json",
            success: function(data) {
               //Clean table
                $('#tableDominios tbody').empty();
                //hide error status message
                $("#errstatus").attr("hidden", true);
                //hide error name message
                $("#errname").attr("hidden", true);
                //hide Modal 
                $('#ModalEdit').modal('hide');
                //Refresh table 
                getData(); 
            }

        });
        event.preventDefault(); 
    }
});
//DELETE SITE FUNCTION

    $('#Delete').submit(function(event) { //Trigger on form submit
       

      var frm=$("#Delete"); //Identify form by Id 
      var datos = frm.serialize();  //Serialize data
     
        //Ajax petition 
       $.ajax({
            url: "http://localhost:8080/Squid-proxy/index.php/Proxy/deleteSite",
            method: 'POST',
            data: datos,
            dataType: "json",
            success: function(data) {
               $('#ModalDelete').modal('hide');
               getData(); 
            }

        });
        event.preventDefault(); 
   
});

// CALL GET DATA FUNCTION TO INITIALIZE WITH THE PAGE 

         getData();

// POST - SAVE NEW SITE AND REFRESH TABLE 

    $('#Reg').submit(function(event) { //Trigger on form submit

      var frm=$( "#Reg" ); //Identificamos el formulario por su id
      var datos = frm.serialize();  //Serializamos sus datos

        //Preparamos la petición Ajax
        $.ajax({
            url: "http://localhost:8080/Squid-proxy/index.php/Proxy/post",
            method: 'POST',
            data: datos,
            dataType: "json",
            success: function(data) {
              //Clean table
                $('#tableDominios tbody').empty();
              //Refresh table
                getData(); 
            }
        });
        event.preventDefault(); 
    });
});

</script>

</body>
</html>