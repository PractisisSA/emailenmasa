<?php

//print_r($_POST);

 include('conect.php');
 
 $id_lista=$_POST['id_lista'];
$conexion = conectar_PostgreSQL( "postgres", "postgres", "localhost", "email_masivo" );

$id_lista=$_POST['id_lista'];
 
 $rs1=selectCorreo( $conexion, $id_lista);
 $file = fopen("data", "w");
 $totalCorreos=pg_num_rows($rs1);
 $i=1;
while( $objFila1 = pg_fetch_object($rs1) ){
if($i==1){

	fwrite($file, '{"data":[' . PHP_EOL);



}

//echo $objFila1->nombre." ".$objFila1->direccion."<br>";
 
fwrite($file, '["'.$objFila1->id.'","'.$objFila1->nombre.'","'.$objFila1->direccion.'"]' . PHP_EOL);


if($i<$totalCorreos){
fwrite($file, ',' . PHP_EOL);

}

$i++;


}

fwrite($file, ']}' . PHP_EOL);

fclose($file);


echo '
 <link rel="stylesheet" href="css/dataTables.checkboxes.css" >
 <script type="text/javascript" src="js/dataTables.checkboxes.js"></script>
 <script type="text/javascript" src="js/dataTables.checkboxes.min.js"></script>
 <div style="padding: 20px;">
<form id="frm-example" action="contactos.php" method="POST">

<table id="example1" class="display table table-striped table-bordered" cellspacing="0" width="80%" align="center" >
   <thead>
      <tr>
         <th></th>
         <th>Nombre</th>
         <th>Correo</th>
      </tr>
   </thead>
   <tfoot>
      <tr>
         <th></th>
         <th>Nombre</th>
         <th>Correo</th>         
      </tr>
   </tfoot>
</table>

<hr>

<p>Presione <b>Enviar</b> Para enviar a los correos seleccionados.</p>

<p><button class="btn btn-primary" >Enviar Correos</button></p>

<!--<p><b>Filas Seleccionadas:</b></p>-->
<input type="hidden" id="example-console-rows" value=""  name="envioseleccion">
<input type="hidden" id="idlistaenvioseleccion" value="'.$id_lista.'"  name="idlistaenvioseleccion">


</form>
</div>
';

echo "
<script>
$(document).ready(function() {
   var table = $('#example1').DataTable({
      'ajax': 'data',
      'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
   });
   
   // Handle form submission event 
   $('#frm-example').on('submit', function(e){
      var form = this;
      
      var rows_selected = table.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
         );
      });

      // FOR DEMONSTRATION ONLY
      // The code below is not needed in production
      // Output form data to a console     
     
       $('#example-console-rows').val(rows_selected.join(\",\"));
            
      // Remove added elements
      $('input[name=\"id\[\]\"]', form).remove();
       
      // Prevent actual form submission
      e.preventDefault();
      
      if($('#example-console-rows').val()==''){

      	alert('Debe seleccionar los correos a enviar');

      	return false;

      }else{


       if (confirm('Seguro que deseas guardar la lista?') == true) {
       var envioseleccion=$('#example-console-rows').val();
       var idlistaenvioseleccion=$('#idlistaenvioseleccion').val();

         $.ajax({
                    url: 'enviomail.php',
                    type: 'POST',
                    data: {envioseleccion: envioseleccion, id_lista: idlistaenvioseleccion},
                    success: function(respuesta) {
                         var html = '';
                        
                                                        
                         html = respuesta;
                         
                         alert('Correos enviados correctamente');                            
                            
                            
                        
                      /*  $('#resultado1').html(html);*/
                    }
                });

} else {
    return false;
}

      }
   });   
});
</script>
";

?>