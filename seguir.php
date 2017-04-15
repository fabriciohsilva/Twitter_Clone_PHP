<?php

  //iniciando session
  session_start();

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }

  require_once('db.class.php');

  $seguir_id_usuario = $_POST['seguir_id_usuario'];
  $id_usuario = $_SESSION['id'];

  if ($seguir_id_usuario != '' && $id_usuario != ''){
    # code...
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //inserindo TWEET no banco
    $sql = " insert into usuarios_seguidores(id_usuario, seguindo_id_usuario) values ($id_usuario, $seguir_id_usuario) ";

    //executar a query
    mysqli_query($link, $sql);

  }//end if ($texto_tweet != '' && $id_usuario != '')

?>
