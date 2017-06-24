<?php
  include('includes/nav.php');
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
        <section>
          <label>Usuario</label>
          <label class='etiqueta'>dd/mm/yyyy</label>
          <p>Este es un comentario</p>
          <hr>
          <label>Usuario 2</label>
          <label class='etiqueta'>dd/mm/yyyy</label>
          <p>Este es otro comentario</p>
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
                  <button type="submit" id="publicar" class="btn btn-default">Enviar</button>
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
  id=$("#id").val();
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


});
</script>
