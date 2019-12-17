<?php include('header.php'); 

include('conect.php');
$conexion = conectar_PostgreSQL( "postgres", "postgres", "localhost", "email_masivo" );
$rs= selectLista($conexion);
$i=1;
while( $objFila = pg_fetch_object($rs) ){
   
   $correos=selectCorreo( $conexion, $objFila->id);
   $totalCorreos=pg_num_rows($correos);
  $listado.="<tr>
                <td>".$i."</td>
                <td>".$objFila->nombre."<br>Asunto: ".$objFila->titulo."</td>
                <td style='text-align:center;'>".$totalCorreos."</td>
                <td>".$objFila->fecha_creacion."</td>
                <td style='text-align:center;'><a href='' title='Enviar Correo' onclick='return enviarcorreo(".$objFila->id.");'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                <a href='#' title='Ver Plantilla' data-toggle='modal' data-target='.bd-example-modal-lg' onclick='return mostrarplantilla(".$objFila->id.");'><i class='fa fa-file-o' aria-hidden='true'></i></a>

                <a href='#' title='Ver Contactos' data-toggle='modal' data-target='.bd-example-modal-lg' onclick='return mostrarcontactos(".$objFila->id.");'><i class='fa fa-users' aria-hidden='true'></i></a>
                
                </td>
                
            </tr>";

            $i++;
}


?>

   

    <div id="content-wrapper">

      <div class="container-fluid">
         <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Email Masivo</a>
          </li>
          <li class="breadcrumb-item active">Listado</li>
        </ol>
<div class="content">
  <div style="text-align: right; margin-bottom: 20px;"><a class="btn btn-primary" href="index_listado.php" role="button">Crear Nueva Lista</a></div>
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
              <th style='text-align:center;'>#</th>
                <th style='text-align:center;'>Nombre de la Lista</th>
                <th style='text-align:center;'>Número de Contactos</th>
                <th style='text-align:center;'>Fecha de Creación</th>
                <th style='text-align:center;'>Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php echo $listado; ?>
           
        </tbody>
        <tfoot>
             <tr>
              <th style='text-align:center;'>#</th>
                <th style='text-align:center;'>Nombre de la Lista</th>
                <th style='text-align:center;'>Número de Contactos</th>
                <th style='text-align:center;'>Fecha de Creación</th>
                <th style='text-align:center;'>Acciones</th>
                
            </tr>
        </tfoot>
    </table>
    <script type="text/javascript">
      $(document).ready(function() {
    $('#example').DataTable();
} );


      function mostrarplantilla(id) {
   
   var id_lista=id;
   
                $.ajax({
                    url: 'leer_lista.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {id_lista: id_lista},
                    success: function(respuesta) {
                         var html = '';
                        
                                                        
                         html = respuesta;
                                                     
                            
                            
                        
                        $("#resultadoclick").html(html);
                    }
                });
            }


            function mostrarcontactos(id) {
   
   var id_lista=id;
   
                $.ajax({
                    url: 'contactos.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {id_lista: id_lista},
                    success: function(respuesta) {
                         var html = '';
                        
                                                        
                         html = respuesta;
                                                     
                            
                            
                        
                        $("#resultadoclick").html(html);
                    }
                });
            }

      function enviarcorreo(id){

        var id_lista=id;


        if (confirm("Seguro que deseas enviar el correo?") == true) {
    

        $.ajax({
                    url: 'enviomail.php',
                    type: 'POST',
                    
                    data: {id_lista: id_lista},
                    success: function(respuesta) {
                         var html = '';
                        
                                                        
                         html = respuesta;
                                                     
                            
                            
                        
                        alert(html);
                    }
                });


        } else {
          return false;
        }




      }
    </script>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <span id="resultadoclick"></span>
                        
                      </div>
                    </div>
                  </div>
        
        </div>

      </div>
      <!-- /.container-fluid -->

     <?php include('footer.php'); ?>
