<?php
  include('includes/nav.php');
?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10">
              <div class="contenedor-blog">
                <div class="post-preview">
                    <a class='post'>
                        <h2 class="post-title">
                        </h2>
                        <h3 class="post-subtitle">
                        </h3>
                        <input type="hidden" name="id" value="">
                    </a>
                    <p class="post-meta"></p>
                    <img src="img/prueba.jpg" alt="Prueba">
                </div>
              </div>
              <hr>

              <!-- Pager -->
                  <ul class="pager">
                    <li id='anterior' class="previous">
                      <a class='no-jump' href="#">&larr; Anteriores</a>
                    </li>
                    <li id='siguiente' class="next">
                      <a class='no-jump' href="#">Siguientes &rarr;</a>
                    </li>
                  </ul>
            </div>

            <div class="col-lg-3 col-lg-offset-1 col-md-10">
              <div class="mensaje">
                  <p>Mensaje de bienvenida y boton subscribir</p>
              </div>
              <div class="ultimos-posts">
                  <hr>
                  <h4>Ultimas Entradas</h4>
                  <ul id='recientes'></ul>
              </div>
              <div class="instagram">
                  <hr>
                  <span><h4>Instagram</h4></span>
                  <ul id='instafeed'></ul>
              </div>
            </div>

            <!-- End Pager -->
        </div>
    </div>
    <!-- End Main Content -->

<?php
   include('includes/footer.html');
?>

<script type="text/javascript">
$(document).ready(function(){
  jQuery.fn.spectragram.accessData ={
     accessToken: '2240419186.be2992f.dd0dfc3757a843c59bf81a829c803975',
     clientID: 'be2992f1f54b4891b8ba9ab3cbff4db0'
  };

  $('#instafeed').spectragram('getUserFeed',{
     query: 'jeanetteglx',
     max:6,
     size:'small',
     wrapEachWith: '<li></li>'
  });

  $.ajax({
    async:true,
    url:"php/servicios.php",
    data:{servicio:'mas-recientes'},
    cache:false,
    type:"POST",
    dataType:"json",
    success:function(resultado){
     if (resultado.recientes!='cero'){
       $.each(resultado.recientes,function(index,item) {
           $('#recientes').append(
            '<li>'+
              '<a id='+item.id+' class="titulo-reciente">'+item.titulo.toUpperCase()+'</a>'+
              '<label class="etiqueta">'+item.fecha+'</label>'+
            '</li>');
       });
     }
    }
  });

  var indiceblog = 0, totalblog;
  var dataBlog = {
     "servicio": "cargar-blog",
     "index": (indiceblog * 3)
  };

  $.ajax({
    async:true,
    url:"php/servicios.php",
    data:{servicio:'total-entradas'},
    cache:false,
    type:"POST",
    dataType:'json',
    success:function(resultado){
     if (resultado.cantidad!='cero'){
       totalblog=Math.ceil(resultado.cantidad/3)-1;
     }
    }
  });

  var ponerBlog=function(){
    $.ajax({
      async:true,
      url:"php/servicios.php",
      data:dataBlog,
      cache:false,
      type: "POST",
      dataType:'json',
      success:function(resultado){
        $(".contenedor-blog").empty();
        $.each(resultado.datos,function(index,item){
          $(".contenedor-blog").append(
            '<div class="post-preview">'+
                '<a class="post">'+
                    '<h2 class="post-title">'+
                        item.titulo.toUpperCase()+
                    '</h2>'+
                    '<h3 class="post-subtitle">'+
                        item.subtitulo+
                    '</h3>'+
                    '<input type="hidden" name="id" value="'+item.id+'">'+
                '</a>'+
                '<p class="post-meta">'+item.fecha+'</p>'+
                '<img src="img/prueba.jpg" height="350" width="600" alt="Prueba">'+
            '</div>'
          );
        })

          if(totalblog==0){ //Si totalblog ==0 quiere decir que solamente existen 3 posts.
            $("#anterior").addClass("disabled").hide();
            $("#siguiente").addClass("disabled").hide();
          }else{
            if(indiceblog == totalblog){ //Si indiceblog y totalblog son iguales, son los ultimos 3 posts.
                $("#anterior").addClass("disabled").hide();
                $("#siguiente").removeClass("disabled").show();
            }else if (indiceblog == 0){ // Si indiceblog es igual a 0, son los 3 primeros posts.
               $("#siguiente").addClass("disabled").hide();
               $("#anterior").removeClass("disabled").show();
            }else{// Aún hay anteriores posts que mostrar y siguientes posts que regresar.
               $("#anterior, #siguiente").removeClass("disabled").show();
            }
         }
        // alert("indiceblog"+indiceblog+",totalblog"+totalblog);
      }
    });
  }

  $(".contenedor-blog").on('click','a',function(){
    valor=$(this).children('input').val();
    window.location.href='post.php?num='+valor;
  });

  $(".ultimos-posts").on('click','a',function(){
    valor=$(this).attr('id');
    window.location.href='post.php?num='+valor;
  });

  var retroceder = function (){
     indiceblog++;
     dataBlog.index = (indiceblog * 3);
     ponerBlog();
  };

  var avanzar = function (){
     indiceblog--;
     dataBlog.index = (indiceblog * 3);
     ponerBlog();
  };

  $("#anterior").click(function (){
    if (!$(this).hasClass("disabled")){
      retroceder();
      $('body, html').animate({
  			scrollTop: '200px'
  		}, 1000);
    }
  });

  $("#siguiente").click(function (){
    if (!$(this).hasClass("disabled")){
      avanzar();
      $('body, html').animate({
  			scrollTop: '200px'
  		}, 1000);
    }
  });

  $(".no-jump").click(function (e){
      e.preventDefault();
  });

  ponerBlog();
});
</script>
