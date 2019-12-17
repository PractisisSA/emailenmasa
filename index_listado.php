<?php include('header.php'); 




?>
  
  <link rel="stylesheet" href="css/style.css">
 
   <script src="js/upload.js"></script>  

    <div id="content-wrapper">

      <div class="container-fluid">
         <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Email Masivo</a>
          </li>
          <li class="breadcrumb-item active">Nueva Lista</li>
        </ol>

        <div class="content__inner">

    <div class="container">
      <div style="text-align: right; margin-bottom: 20px;"><a class="btn btn-primary" href="principal.php" role="button">Regresar</a></div>
      <!--content title-->
     <!-- <h2 class="content__title content__title--m-sm">Pick animation type</h2>-->
      <!--animations form-->
      <form class="pick-animation my-4">
        <div class="form-row">
          <div class="col-5 m-auto">
            <select class="pick-animation__select form-control" hidden="">
              <option value="scaleIn" selected="selected">ScaleIn</option>
              <option value="scaleOut">ScaleOut</option>
              <option value="slideHorz">SlideHorz</option>
              <option value="slideVert">SlideVert</option>
              <option value="fadeIn">FadeIn</option>
            </select>
          </div>
        </div>
      </form>
      <!--content title-->
      <h2 class="content__title">Haga clic en los pasos o en los botones 'Anterior' y 'Siguiente'</h2>
    </div>
    <div class="container overflow-hidden">
      <!--multisteps-form-->
      <div class="multisteps-form" style="height: 700px;">
        <!--progress bar-->
        <div class="row">
          <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
            <div class="multisteps-form__progress">
              <button class="multisteps-form__progress-btn js-active" type="button" title="Información de la Lista">Lista</button>
              <button class="multisteps-form__progress-btn" type="button" title="Listado de Direcciones">Direcciones</button>
              <button class="multisteps-form__progress-btn" type="button" title="Seleccione Plantilla">Plantilla</button>
              <button class="multisteps-form__progress-btn" type="button" title="Finalizar">Finalizar        </button>
            </div>
          </div>
        </div>
        <!--form panels-->
        <div class="row">
          <div class="col-12 col-lg-8 m-auto">
            <form class="multisteps-form__form" id="listacorreo" method="post" action="guardar_lista.php">
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="scaleIn">
                <h3 class="multisteps-form__title">Datos de la Lista</h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <div class="col-12 col-sm-6 form-group">
                      <input class="multisteps-form__input form-control" type="text" id="nombre" name="nombre" placeholder="Nombre de la Lista"  required />
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                      <input class="multisteps-form__input form-control" type="text" id="titulo" name="titulo" placeholder="Asunto del Correo" required />
                    </div>
                  </div>
                  
                  
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Siguiente</button>
                  </div>
                </div>
              </div>
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title">Cargar Archivo de Direcciones</h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <div class="col-12">
                      
            <div id="respuesta" class="alert"></div>
            
                <div class="form-row mt-4">
                    
                    <div class="col-4 mt-4 mt-sm-0">
                        <input type="hidden" name="nombre_archivo" id="nombre_archivo" value="correo" />
                    </div>
                    <div class="col-12">
                        <input type="file" name="archivo" id="archivo" onchange="return fileValidation();"/>
                    </div>                    
                </div>
                <hr />
                <div class="form-row mt-4">
                    <div class="col-6">
                        <input type="button" id="boton_subir" value="Subir" class="btn btn-success" />
                    </div>
                    <div class="col-6">
                        <progress id="barra_de_progreso" value="0" max="100"></progress>
                    </div>
                </div>
            
            <hr />
            <div class="form-row mt-4">
            <div class="col-12" id="archivos_subidos"></div>
             <input type="hidden" name="archivo_up" id="archivo_up" value="0" />

             </div>     
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Anterior</button>
                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Siguiente</button>
                  </div>
                  </div>
                </div>
              </div>
            </div>
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title">Cargar Plantilla</h3>
                <div class="multisteps-form__content">
                  <div class="row">
                    
                    
                 <div class="col-4 mt-4">
                  <div class="form-group" id="opciones" >
                    <label for=""><b>Opciones:</b></label><br>
                    <input type="radio" name="opc" value="1" onchange="mostrar(this.value);"><b>Importar desde URL</b><br>
                    <input type="radio" name="opc" value="2"  onchange="mostrar(this.value);"><b>Pegar Codigo</b><br>
                    <input type="radio" name="opc" value="3"  onchange="mostrar(this.value);"><b>Cargar Archivo</b>
                </div>
              </div>
              <div class="col-8 mt-4"><br>
                <div class="form-group" id="url" style="display:none;">
                    <label for="">Importar desde URL:</label>
                    <input type="text" class="form-control url" name="url"  >
                </div>
                <div class="form-group" id="codigo" style="display:none;">
                    <label for="">Pegar Codigo:</label>
                    <textarea class="form-control codigo" name="codigo"></textarea>
                </div>
               <div class="form-group" id="archivo2" style="display:none;"> 
                <div id="respuesta2" class="alert"></div>
            
                
                    <label for="">Cargar Archivo:</label>
                    <div>
                        <input type="file" class="form-control archivo2" name="archivo2" onchange="return fileValidation2();"/><br>
                    
                        <input type="button" id="boton_subir2" value="Subir" class="btn btn-success" /><br>
                        <progress id="barra_de_progreso2" value="0" max="100"></progress>
                    </div>
                
             
              <hr />
            <div class="form-row mt-4">
              <div id="archivos_subidos2"></div>
            </div>
            </div>
             <input type="hidden" name="archivo_up2" id="archivo_up2" value="0" />
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="return mostrarhtml();">Vista Previa</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="button-row d-flex mt-4 col-12">
                      <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Anterior</button>
                      <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Siguiente</button>
                    </div>
                  </div>
                </div>
              </div>
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                <h3 class="multisteps-form__title">Comentarios</h3>
                <div class="multisteps-form__content">
                  <div class="form-row mt-4">
                    <textarea class="multisteps-form__textarea form-control" name="comentario" id="comentario" placeholder="Comentarios"></textarea>
                  </div>
                  <div class="button-row d-flex mt-4">
                    <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Anterior</button>
                    <button class="btn btn-success ml-auto" type="button" title="Send" onclick="return enviarformulario();">Guardar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <span id="resultado1"></span>
                        
                      </div>
                    </div>
                  </div>
        </div>

      </div>
      <!-- /.container-fluid -->
<script  src="js/script.js"></script>
     <?php include('footer.php'); ?>
