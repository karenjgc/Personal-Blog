<?php
 if ($_GET['num']==''){
   header("Location:index.php");
 }else{
   include('includes/nav.php');
 }
?>

    <!-- Comienza Contenido del Post -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                  <div class="cuerpo-post">
                    <h1></h1>
                    <h2 class="subheading"></h2>
                    <span class="meta"></span>
                    <p></p>
                    <input id='id' type="hidden" name="" value="<?php echo $_GET['num']?>">
                  </div>
                </div>
            </div>
        </div>
    </article><br>
    <!--Termina Contenido del Post -->
    <div class="container">
     <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <section id='sec-coments'>
          <label></label>
          <label class='etiqueta'></label>
          <p></p>
          <hr>
        </section><br>
      <h4>
       ¡Deja un comentario, son gratis!
     </h4>
      <form action='#' method="post" enctype="multipart/form-data">
          <div class="row control-group">
              <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label for="titulo">Nombre</label>
                  <input id='nombre' type="text" class="form-control" placeholder="Nombre" required>
              </div>
          </div>
          <div class="row control-group">
              <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label for='subtitulo'>E-mail</label>
                  <input id='email' type="text" class="form-control" placeholder="E-mail" required>
              </div>
          </div>
          <div class="row control-group">
              <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label for='cuerpo'>Comentario</label>
                  <textarea id='comentario' rows="3" class="form-control" placeholder="Comentario" required></textarea>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="form-group col-xs-12">
                  <button type="button" id="publicar" class="btn btn-default">Enviar</button>
              </div>
          </div>
      </form>
    </div>
   </div>
  </div>

<?php
  include('includes/footer.html');
?>

<script type="text/javascript">
$(document).ready(function(){
  function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
 }

  id=$("#id").val();
  $.ajax({
    async:true,
    url:"php/servicios.php",
    data:{id:id,servicio:'comentarios'},
    cache:false,
    type: "POST",
    dataType:'json',
    success:function(resultado){
      $("#sec-coments").empty();
      if (resultado.comentarios!='cero'){
        $.each(resultado.comentarios,function(index,item){
            $('#sec-coments').append(
              '<label>'+item.nombre+'</label>'+
              '<label class="etiqueta">'+item.fecha+'</label>'+
              '<p>'+item.comentario+'</p>'+
              '<hr>'
            );
        });
      }
    }
  });

  $.ajax({
    async:true,
    url:"php/servicios.php",
    data:{id:id,servicio:'publicacion'},
    cache:false,
    type: "POST",
    dataType:'json',
    success:function(resultado){
      var datos=resultado.datos;
      $(".cuerpo-post").empty();
      $(".cuerpo-post").append(
        '<h1>'+datos.titulo+'</h1>'+
        '<h2 class="subheading">'+datos.subtitulo+'</h2>'+
        '<span class="meta">'+datos.fecha+'</span>'+
        '<p>'+datos.cuerpo+'</p>'
      );
    }
  });

 $("#publicar").click(function(){
   nombre=$("#nombre").val();
   email=$('#email').val();
   comentario=$('#comentario').val();

   if (nombre!='' && validateEmail(email) && comentario!=''){
     $.ajax({
       async:true,
       url:"php/servicios.php",
       data:{id:id,
             nombre:nombre,
             email:email,
             comentario:comentario,
             servicio:'nuevo-comentario'},
       cache:false,
       type: "POST",
       dataType:'json',
       success:function(resultado){
         if (resultado.status=='registrado'){
           $("#sec-coments").append(
             '<label>'+nombre+'</label>'+
             '<label class="etiqueta">'+resultado.fecha+'</label>'+
             '<p>'+comentario+'</p>'+
             '<hr>'
           );
           $(".form-control").val("").attr('placeholder','');
         }
       }
     });
   }else{
     bootbox.alert("¡Ups, ingresa tus datos correctamente para enviar tu comentario!");
   }
 });
});
</script>
