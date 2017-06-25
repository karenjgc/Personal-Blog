<?php
 session_start();
 require_once("../php/pdo.php");

 $servicio = isset($_POST['servicio']) ? $_POST['servicio'] : $_GET['servicio'];
 switch ($servicio) {
   case 'nuevo-blog':
        $dt = new DateTime();
        $fecha= $dt->format('Y-m-d');

        try{
          $query=$conexion->prepare("INSERT into entradas(titulo,subtitulo,fecha,portada,cuerpo)
                                         values(:titulo,:subtitulo,:fecha,:portada,:cuerpo)");
          $query->bindParam(":titulo",trim($_POST['titulo']));
          $query->bindParam(":subtitulo",trim($_POST['subtitulo']));
          $query->bindParam(":fecha",$fecha);
          $query->bindParam(":portada",trim($_POST['portada']));
          $query->bindParam(":cuerpo",trim($_POST['cuerpo']));
          $query->execute();
          echo json_encode(array("status"=>"registrado"));
        }catch (PDOException $e){
          echo json_encode(array("status"=>$e->getMessage()));
        }
    break;
   case 'cargar-blog':
        try{
          $query=$conexion->prepare("SELECT * FROM entradas ORDER BY fecha DESC
                                     LIMIT :index,3");
          $query->bindValue(':index', (int)$_POST['index'], PDO::PARAM_INT);
          $query->execute();
          $result=$query->fetchAll(PDO::FETCH_ASSOC);
          if (!empty($result)){
            echo json_encode(array("datos"=>$result));
          }
        }catch (Exception $e){
            echo json_encode(array("datos"=>$e->getMessage()));
        }
    break;
   case 'acceder':
    try {
      $query=$conexion->prepare("SELECT * from usuarios where usuario=:usuario
                                                        and contra=:contra");
      $query->bindParam(":usuario",$_POST['usuario']);
      $query->bindParam(":contra",$_POST['contra']);
      $query->execute();
      $result=$query->fetch(PDO::FETCH_ASSOC);
      if (!empty($result)){
        $_SESSION['usuario']=$result['usuario'];
        echo json_encode(array("status"=>"ingresa"));
      }else{
        echo json_encode(array("status"=>"denegado"));
      }
    }catch (Exception $e){
      echo json_encode(array("status"=>$e->getMessage()));
    }
    break;
   case 'publicacion':
     $query=$conexion->prepare("SELECT * from entradas where id=:id");
     $query->bindParam(":id",$_POST['id']);
     $query->execute();
     $result=$query->fetch(PDO::FETCH_ASSOC);
     if (!empty($result)){
       echo json_encode(array("datos"=>$result));
     }
    break;
   case 'todas-entradas':
     $hoy = new DateTime();
     $fecha= $hoy->format('Y-m-d');

     try {
       $query=$conexion->prepare("SELECT * from entradas where MONTH(fecha)=MONTH(:fecha)");
       $query->bindParam(":fecha",$fecha);
       $query->execute();
       $result=$query->fetchAll(PDO::FETCH_ASSOC);
       if (!empty($result)){
         echo json_encode(array('entradas'=>$result));
       }else{
         echo json_encode(array('entradas'=>"cero"));
       }
     }catch (Exception $e){
       echo json_encode(array("entradas"=>$e->getMessage()));
     }
    break;
   case 'elim-entrada':
     $query=$conexion->prepare("DELETE from entradas where id=:id");
     $query->bindParam(":id",$_POST['id']);
     $query->execute();
     echo json_encode(array('status'=>'ok'));
    break;
   case 'total-entradas':
     $query=$conexion->prepare("SELECT COUNT(*) from entradas");
     $query->execute();
     $result=$query->fetchColumn();
     if ($result>=1) {
      echo json_encode(array('cantidad'=>$result));
    }else{
      echo json_encode(array('cantidad'=>'cero'));
    }
    break;
   case 'mas-recientes':
     $query=$conexion->prepare("SELECT * from entradas ORDER BY fecha DESC LIMIT 5");
     $query->execute();
     $result=$query->fetchAll(PDO::FETCH_ASSOC);
     if (!empty($result)){
       echo json_encode(array('recientes'=>$result));
     }else {
       echo json_encode(array('recientes'=>'cero'));
     }
    break;
   case 'comentarios':
     $query=$conexion->prepare("SELECT * from comentarios where id_entrada=:id_entrada");
     $query->bindParam(':id_entrada', $_POST['id']);
     $query->execute();
     $result=$query->fetchAll(PDO::FETCH_ASSOC);
     if (!empty($result)){
       echo json_encode(array('comentarios'=>$result));
     }else{
       echo json_encode(array('comentarios'=>'cero'));
     }
     break;
   case 'nuevo-comentario':
    $dt = new DateTime();
    $fecha= $dt->format('Y-m-d');

    try {
     $query=$conexion->prepare("INSERT into comentarios(nombre,email,comentario,fecha,id_entrada)
                             values(:nombre,:email,:comentario,:fecha,:id_entrada)");
     $query->bindParam(':nombre',trim($_POST['nombre']));
     $query->bindParam(':email',trim($_POST['email']));
     $query->bindParam(':comentario',trim($_POST['comentario']));
     $query->bindParam(':fecha',$fecha);
     $query->bindParam(':id_entrada',$_POST['id']);
     $query->execute();
     echo json_encode(array('status'=>'registrado','fecha'=>$fecha));
    } catch (Exception $e) {
     echo json_encode(array('status'=>$e->getMessage()));
    }
     break;
 }
?>
