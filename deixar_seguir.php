<?php

  //iniciando session
  session_start();

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }

  require_once('db.class.php');

  $deixar_seguir_id_usuario = $_POST['deixar_seguir_id_usuario'];
  $id_usuario = $_SESSION['id'];

  if ($deixar_seguir_id_usuario != '' && $id_usuario != ''){
    # code...
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //inserindo TWEET no banco
    $sql = " delete from usuarios_seguidores where id_usuario = $id_usuario and seguindo_id_usuario = $deixar_seguir_id_usuario ";

    //executar a query
    mysqli_query($link, $sql);

  }//end if ($texto_tweet != '' && $id_usuario != '')

?>
