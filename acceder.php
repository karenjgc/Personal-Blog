<?php
include 'includes/nav.php';

if (isset($_SESSION['usuario'])!=''){
  echo "<script> window.location.href ='admin.php'</script>";
}
?>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
          <div class="page-heading">
              <h1>Log In</h1>
          </div>
          <form action="#" method="post">
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label for="usuario">Usuario:</label>
                    <input id='usuario' type="text" class="form-control" placeholder="Usuario" required>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label for="contra">Contraseña:</label>
                    <input id='contra' type="password" class="form-control" placeholder="Contraseña" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <button type="submit" id="ingresar" class="btn btn-default">Ingresar</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php
include 'includes/footer.html';
?>

<script type="text/javascript">
 $("#ingresar").click(function(){
    usuario=$("#usuario").val();
    contra=$("#contra").val();
   $.ajax({
     async:true,
     type: "POST",
     url:"php/servicios.php",
     data:{usuario:usuario,
           contra:contra,
           servicio:"acceder"},
     cache:false,
     dataType:'json',
     success:function(resultado){
       if (resultado.status=='ingresa'){
         bootbox.alert("Bienvenido Admin :)",function(){
           window.location.reload();
         });
       }else{
         bootbox.alert("Acceso Denegado :(",function(){
           window.location.reload();
         });
       }
     }
   });
   return false;
 });
</script>
