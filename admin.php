<?php
include 'includes/nav.php';

if (isset($_SESSION['usuario'])=='') {
  echo "<script> window.location.href ='acceder.php'</script>";
}
?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-10">
            <h3>Panel</h3>
            <div class="list-group">
              <button id='btn-perfil' type="button" class="list-group-item">Perfil</button>
              <button id='btn-nueva' type="button" class="list-group-item">Nueva Entrada</button>
              <button id='btn-todas' type="button" class="list-group-item">Ultimas Entradas</button>
              <button id='btn-cerrar' type="button" class="list-group-item">Cerrar Sesión</button>
            </div>
          </div>
          <div id='secciones' class="col-lg-8 col-md-10">
            <section id='btn-perfil-sec'>
              <h2>¡Buen Día <?php echo $_SESSION['usuario'];?>!</h2>
            </section>

            <section id='btn-nueva-sec'>
              <h3>
               Nueva Entrada
              </h3>
              <form action='#' method="post" enctype="multipart/form-data">
                  <div class="row control-group">
                      <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label for="titulo">Titulo</label>
                          <input id='titulo' type="text" class="form-control" placeholder="Titulo" required>
                      </div>
                  </div>
                  <div class="row control-group">
                      <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label for='subtitulo'>Subtitulo</label>
                          <input id='subtitulo' type="text" class="form-control" placeholder="Subtitulo" required>
                      </div>
                  </div>
                  <div class="row control-group">
                      <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label for='portada'>Portada</label>
                          <input id='portada' type="text" class="form-control" placeholder="Portada" required>
                      </div>
                  </div>
                  <div class="row control-group">
                      <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label for='cuerpo'>Cuerpo</label>
                          <textarea id='cuerpo' rows="5" class="form-control" placeholder="Cuerpo" required></textarea>
                      </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="form-group col-xs-12">
                          <button type="submit" id="publicar" class="btn btn-default">Publicar</button>
                      </div>
                  </div>
              </form>
            </section>
            <section id='btn-todas-sec'>
              <h3>Ultimas Entradas del Mes</h3>
              <div class="panel panel-default">
                   <!-- Table -->
                   <table class="table">
                    <thead>
                      <th>Titulo</th>
                      <th>Subtitulo</th>
                      <th>Fecha</th>
                      <th></th>
                    </thead>
                    <tbody id='tb-entradas'>
                      <tr>
                        <td></td>
                      </tr>
                    </tbody>
                   </table>
               </div>
            </section>
            </div>
        </div>
    </div>

<?php
  include('includes/footer.html');
?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#secciones").children('section').hide();
    $("#btn-perfil-sec").show();

    $(".list-group-item").click(function(){
      id='#'+$(this).attr('id')+'-sec';
      $("#secciones").children('section').hide();
      $(id).show();
    });

    $("#btn-todas").click(function(){
      $.ajax({
        async:true,
        url:"php/servicios.php",
        data:{servicio:'todas-entradas'},
        cache:false,
        type: "POST",
        dataType:'json',
        success:function(resultado){
          $("#tb-entradas").empty();
          $.each(resultado.entradas,function(index,item) {
            if (resultado.entradas!='cero'){
              $("#tb-entradas").append(
                '<tr>'+
                  '<td>'+item.titulo+'</td>'+
                  '<td>'+item.subtitulo+'</td>'+
                  '<td>'+item.fecha+'</td>'+
                  '<td><input type="button" id="'+item.id+'" class="btn-eliminar" value="Eliminar"></td>'+
                '</tr>'
              );
            }else{
              $("#tb-entradas").append(
               "<h2>No se han encontrado entradas en el mes.</h2>"
              );
            }
          });
        }
      });
    });

    $("#tb-entradas").on('click','input',function(){
       id=$(this).attr('id');

       bootbox.confirm({
        message: "¿Seguro que deseas eliminar esta entrada?",
        buttons: {
            confirm: {
            label: 'Si',
            className: 'btn-success'
        },
            cancel: {
            label: 'No',
            className: 'btn-danger'
        }
        },
        callback: function (result) {
          if (result){
            $.ajax({
              async:true,
              type: "POST",
              url:"php/servicios.php",
              data:{id:id,
                    servicio:"elim-entrada"},
              cache:false,
              dataType:'json',
              success:function(resultado){
                if (resultado.status=='ok'){
                  bootbox.alert("Entrada eliminada satisfactoriamente ;)",function(){
                    window.location.reload();
                  });
                }
              }
            });
          }
        }
      });

    });

    $("#publicar").click(function(){
       var titulo=$("#titulo").val();
       var subtitulo=$("#subtitulo").val();
       var portada=$("#portada").val();
       var cuerpo=$("#cuerpo").val();

       if(titulo!="" && subtitulo!="" && portada!="" && cuerpo!=""){
         $.ajax({
           async:true,
           type: "POST",
           url:"php/servicios.php",
           data:{titulo:titulo,
                 subtitulo:subtitulo,
                 portada:portada,
                 cuerpo:cuerpo,
                 servicio:"nuevo-blog"},
           cache:false,
           dataType:'json',
           success:function(resultado){
            if (resultado.status=='registrado'){
              bootbox.alert("Registrado Correctamente :)",function(){
                window.location.reload();
              });
            }else{
              bootbox.alert("Error en el servidor :(",function(){
                window.location.reload();
              });
            }
           }
         });
       }else{
         bootbox.alert("LLena todo el formulario flojis :)");
       }
       return false;
    });

    $("#btn-cerrar").click(function(){
      bootbox.confirm({
       message: "¿Seguro que deseas cerrar sesión?",
       buttons: {
           confirm: {
           label: 'Si',
           className: 'btn-success'
       },
           cancel: {
           label: 'No',
           className: 'btn-danger'
       }
       },
       callback: function (result) {
         if (result) {
           window.location.href="salir.php";
         }
       }
     });
    });
  });
</script>
