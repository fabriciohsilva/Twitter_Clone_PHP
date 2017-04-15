<?php
  //iniciando session
  session_start();

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }//end if (!isset($_SESSION['usuario']))

  require_once('db.class.php');

  $id_usuario = $_SESSION['id'];

  $objDb = new db();
  $link = $objDb->conecta_mysql();

  //buscando tweets no banco
  $sql = "select t.tweet, date_format(t.data_inclusao, '%d %b %Y %T') as data_inclusao, u.usuario";
  $sql.= " from tweet as t inner join usuarios as u on (t.id_usuario = u.id)";
  $sql.= " where t.id_usuario = $id_usuario";
  $sql.= " or t.id_usuario in (select us.seguindo_id_usuario from usuarios_seguidores us where us.id_usuario = $id_usuario)";
  $sql.= " order by t.data_inclusao desc";


  //executar a query
  $resultado_id = mysqli_query($link, $sql);

  if ($resultado_id) {
    # code...
    while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
      # code...
      echo '<a href="#" class="list-group-item">';
        echo '<h4 class="list-group-item-heading">'.$registro['usuario'].' <small> - '.$registro['data_inclusao'].'</small></h4>';
        echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
      echo "</a>";
    }//end while ($registro = mysqli_fetch_array($resultado_id))

  }else {
    # code...
    echo "Erro na consulta de tweets!<br>";
    echo $sql;
  }//end if ($resultado_id)

?>
