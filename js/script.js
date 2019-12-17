//DOM elements
const DOMstrings = {
  //stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next' };


//remove class from a set of items
const removeClasses = (elemSet, className) => {

  elemSet.forEach(elem => {

    elem.classList.remove(className);

  });

};

//return exect parent node of the element
const findParent = (elem, parentClass) => {

  let currentNode = elem;

  while (!currentNode.classList.contains(parentClass)) {
    currentNode = currentNode.parentNode;
  }

  return currentNode;

};

//get active button step number
const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

//set all steps before clicked (and clicked too) to active
const setActiveStep = activeStepNum => {

  //remove active state from all the state
  removeClasses(DOMstrings.stepsBtns, 'js-active');

  //set picked items to active
  DOMstrings.stepsBtns.forEach((elem, index) => {

    if (index <= activeStepNum) {
      elem.classList.add('js-active');
    }

  });
};

//get active panel
const getActivePanel = () => {

  let activePanel;

  DOMstrings.stepFormPanels.forEach(elem => {

    if (elem.classList.contains('js-active')) {

      activePanel = elem;

    }

  });

  return activePanel;

};

//open active panel (and close unactive panels)
const setActivePanel = activePanelNum => {

  //remove active class from all the panels
  removeClasses(DOMstrings.stepFormPanels, 'js-active');

  //show active panel
  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === activePanelNum) {

      elem.classList.add('js-active');

      setFormHeight(elem);

    }
  });

};

//set form height equal to current panel height
const formHeight = activePanel => {

  const activePanelHeight = activePanel.offsetHeight;

  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
  const activePanel = getActivePanel();

  formHeight(activePanel);
};

//STEPS BAR CLICK FUNCTION
DOMstrings.stepsBar.addEventListener('click', e => {

  //check if click target is a step button
  const eventTarget = e.target;

  if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
    return;
  }

  //get active button step number
  const activeStep = getActiveStep(eventTarget);

  //set all steps before clicked (and clicked too) to active
  setActiveStep(activeStep);

  //open active panel
  setActivePanel(activeStep);
});

//PREV/NEXT BTNS CLICK
DOMstrings.stepsForm.addEventListener('click', e => {

  const eventTarget = e.target;

  //check if we clicked on `PREV` or NEXT` buttons
  if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
  {
    return;
  }

  //find active panel
  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

  //set active step and active panel onclick
  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
    activePanelNum--;

  } else {

    activePanelNum++;

  }
//alert(activePanelNum);
 if(activePanelNum<=1){
  var nombre=$("#nombre").val();
  var titulo=$("#titulo").val();
  if(nombre==""){
    alert('Registre el Nombre de la Lista'); 
    return false;


  }
  if(titulo==""){

  alert('Registre el Titulo de la Lista');    
    return false;


  }
  //alert('Aqui');
  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);
}

if(activePanelNum==2){
  var archivo=$("#archivo_up").val();
  
  if(archivo==0){
    alert('Debe subir una lista'); 
    return false;


  }
  
  //alert('Aqui');
  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);
}

if(activePanelNum==3){
  var dato=$('input:radio[name=opc]:checked').val();

   if(dato==1){

    codigo=$('.url').val();
   }
   if(dato==2){

    codigo=$('.codigo').val();
   }
   if(dato==3){
      var archivo = $('.eliminar_archivo2').parents('.row').eq(0).find('span').text();
      //alert(archivo);
      archivo = $.trim(archivo);
    codigo=archivo;

   }
  
  if(codigo==""){

alert("Debe Cargar una PLantilla");
return false;

  }
  
  //alert('Aqui');
  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);
}


if(activePanelNum==4){
  /*var archivo=$("#archivo_up").val();
  
  if(archivo==0){
    alert('Debe subir una lista'); 
    return false;


  }*/
  
  //alert('Aqui');
  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);
}


//alert(activePanelNum);

});

//SETTING PROPER FORM HEIGHT ONLOAD
window.addEventListener('load', setFormHeight, false);

//SETTING PROPER FORM HEIGHT ONRESIZE
window.addEventListener('resize', setFormHeight, false);

//changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

const setAnimationType = newType => {
  DOMstrings.stepFormPanels.forEach(elem => {
    elem.dataset.animation = newType;
  });
};

//selector onchange - changing animation
const animationSelect = document.querySelector('.pick-animation__select');

animationSelect.addEventListener('change', () => {
  const newAnimationType = animationSelect.value;

  setAnimationType(newAnimationType);
});


function subirArchivos() {
                $("#archivo").upload('subir_archivo.php',
                {
                    nombre_archivo: $("#nombre_archivo").val()
                },
                function(respuesta) {
                    //Subida finalizada.
                    $("#barra_de_progreso").val(0);
                    if (respuesta === 1) {
                        mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                        $("#nombre_archivo, #archivo").val('');
                    } else if (respuesta === 0){
                        mostrarRespuesta('El archivo NO se ha podido subir.', false);
                    } else{

                      mostrarRespuesta(respuesta, false);

                    }
                    mostrarArchivos();
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $("#barra_de_progreso").val(valor);
                });
            }
            function eliminarArchivos(archivo) {
                $.ajax({
                    url: 'eliminar_archivo.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {archivo: archivo},
                    error: function() {
                        mostrarRespuesta('Error al intentar eliminar el archivo.', false);
                    },
                    success: function(respuesta) {
                        if (respuesta == 1) {
                          $("#archivo_up").val('0');
                            mostrarRespuesta('El archivo ha sido eliminado.', true);
                        } else {
                            mostrarRespuesta('Error al intentar eliminar el archivo.', false);                            
                        }
                        mostrarArchivos();
                    }
                });
            }
            function mostrarArchivos() {
                $.ajax({
                    url: 'mostrar_archivos.php',
                    dataType: 'JSON',
                    success: function(respuesta) {
                        if (respuesta) {
                            var html = '';
                            for (var i = 0; i < respuesta.length; i++) {
                                if (respuesta[i] != undefined) {
                                    $("#archivo_up").val('1');
                                    html += '<div class="row"> <span class="col-6"> ' + respuesta[i] + ' </span> <div class="col-lg-6"> <a class="eliminar_archivo btn btn-danger" href="javascript:void(0);"> Eliminar </a> </div> </div> <hr />';
                                }
                            }
                            
                            $("#archivos_subidos").html(html);
                        }
                    }
                });
            }
            function mostrarRespuesta(mensaje, ok){
                $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
                if(ok){
                    $("#respuesta").addClass('alert-success');
                }else{
                    $("#respuesta").addClass('alert-danger');
                }
            }
            $(document).ready(function() {
                mostrarArchivos();
                $("#boton_subir").on('click', function() {
                    subirArchivos();
                });
                $("#archivos_subidos").on('click', '.eliminar_archivo', function() {
                    var archivo = $(this).parents('.row').eq(0).find('span').text();
                    archivo = $.trim(archivo);
                    eliminarArchivos(archivo);
                });
            });

           
 function fileValidation(){

    var fileInput = archivo;
    var filePath = fileInput.value;
    //var allowedExtensions = /(.xls|.xlsx|.csv|.txt)$/i;

    var allowedExtensions = /(.csv)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Solo se permiten archivos con las siguientes extensiones .csv   .');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        /*if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);*/
            return true;
        }
    }
function mostrar(dato){
        if(dato=="1"){
            document.getElementById("url").style.display = "block";
            document.getElementById("codigo").style.display = "none";
            document.getElementById("archivo2").style.display = "none";
            
            
        }
        if(dato=="2"){
            document.getElementById("url").style.display = "none";
            document.getElementById("codigo").style.display = "block";
            document.getElementById("archivo2").style.display = "none";
        }
        if(dato=="3"){
            document.getElementById("url").style.display = "none";
            document.getElementById("codigo").style.display = "none";
            document.getElementById("archivo2").style.display = "block";
        }
    }

   function mostrarhtml() {
    var codigo;

   var dato=$('input:radio[name=opc]:checked').val();

   if(dato==1){

    codigo=$('.url').val();
   }
   if(dato==2){

    codigo=$('.codigo').val();
   }
   if(dato==3){
      var archivo = $('.eliminar_archivo2').parents('.row').eq(0).find('span').text();
      //alert(archivo);
      archivo = $.trim(archivo);
    codigo=archivo;

   }
//alert(codigo);
                $.ajax({
                    url: 'mostrar_html.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {codigo: codigo, dato: dato},
                    success: function(respuesta) {
                         var html = '';
                        
                                                        
                         html = respuesta;
                                                     
                            
                            
                        
                        $("#resultado1").html(html);
                    }
                });
            }


            


function subirArchivos2() {
                $(".archivo2").upload('subir_archivo2.php',
                {
                    nombre_archivo: $("#nombre").val()
                },
                function(respuesta) {
                    //Subida finalizada.
                    $("#barra_de_progreso2").val(0);
                    if (respuesta === 1) {
                        mostrarRespuesta2('El archivo ha sido subido correctamente.', true);
                        $(".archivo2").val('');
                    } else if (respuesta === 0){
                        mostrarRespuesta2('El archivo NO se ha podido subir.', false);
                    } else{

                      mostrarRespuesta2(respuesta, false);

                    }
                    mostrarArchivos2();
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $("#barra_de_progreso2").val(valor);
                });
            }
            function eliminarArchivos2(archivo) {
                $.ajax({
                    url: 'eliminar_archivo2.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {archivo: archivo},
                    error: function() {
                        mostrarRespuesta('Error al intentar eliminar el archivo.', false);
                    },
                    success: function(respuesta) {
                        if (respuesta == 1) {
                          $("#archivo_up2").val('0');
                            mostrarRespuesta2('El archivo ha sido eliminado.', true);
                        } else {
                            mostrarRespuesta2('Error al intentar eliminar el archivo.', false);                            
                        }
                        mostrarArchivos2();
                    }
                });
            }
            function mostrarArchivos2() {
                $.ajax({
                    url: 'mostrar_archivos2.php',
                    dataType: 'JSON',
                    success: function(respuesta) {
                        if (respuesta) {
                            var html = '';
                            for (var i = 0; i < respuesta.length; i++) {
                                if (respuesta[i] != undefined) {
                                    $("#archivo_up2").val('1');
                                    html += '<div class="row"> <span> ' + respuesta[i] + ' </span> <div> <a class="eliminar_archivo2 btn btn-danger" href="javascript:void(0);"> Eliminar </a> </div> </div> <hr />';
                                }
                            }
                            
                            $("#archivos_subidos2").html(html);
                        }
                    }
                });
            }
            function mostrarRespuesta2(mensaje, ok){
                $("#respuesta2").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
                if(ok){
                    $("#respuesta2").addClass('alert-success');
                }else{
                    $("#respuesta2").addClass('alert-danger');
                }
            }
            $(document).ready(function() {
                mostrarArchivos2();
                $("#boton_subir2").on('click', function() {
                    subirArchivos2();
                });
                $("#archivos_subidos2").on('click', '.eliminar_archivo2', function() {
                    var archivo = $(this).parents('.row').eq(0).find('span').text();
                    //alert(archivo);
                    archivo = $.trim(archivo);
                    eliminarArchivos2(archivo);
                });
            });

           
 function fileValidation2(){

    var fileInput = $('.archivo2');
    var filePath = $('.archivo2').val();
    var allowedExtensions = /(.html)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Solo se permiten archivos con las siguientes extensiones .html  .');
        $('.archivo2').val('');
        return false;
    }else{
        //Image preview
        /*if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);*/
            return true;
        }
    }

    function enviarformulario(){

      if (confirm("Seguro que deseas guardar la lista?") == true) {
    $('#listacorreo').submit();
} else {
    return false;
}
      //alert("enviando.....");
      

    }



     