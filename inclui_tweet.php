<?php

  //iniciando session
  session_start();

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }

  require_once('db.class.php');

  $texto_tweet = $_POST['texto_tweet'];
  $id_usuario = $_SESSION['id'];

  if ($texto_tweet != '' && $id_usuario != ''){
    # code...
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //inserindo TWEET no banco
    $sql = " insert into tweet(id_usuario, tweet) values ('$id_usuario', '$texto_tweet') ";

    //executar a query
    mysqli_query($link, $sql);

  }//end if ($texto_tweet != '' && $id_usuario != '')

?>
