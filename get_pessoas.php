<?php
  //iniciando session
  session_start();

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }//end if (!isset($_SESSION['usuario']))

  require_once('db.class.php');

  $id_usuario = $_SESSION['id'];
  $nome_pessoa = $_POST['nome_pessoa'];

  $objDb = new db();
  $link = $objDb->conecta_mysql();

  //buscando tweets no banco
  $sql = "select u.*, us.* from usuarios u left join usuarios_seguidores us on ( us.id_usuario = $id_usuario and u.id = us.seguindo_id_usuario) where usuario like '%$nome_pessoa%' and id <> $id_usuario";

  //executar a query
  $resultado_id = mysqli_query($link, $sql);

  if ($resultado_id) {
    # code...
    while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
      # code...
      echo '<a href="#" class="list-group-item">';
        echo '<strong>'.$registro['usuario'].'</strong> - <small>'.$registro['email'].'</small>';
        echo "<p class='list-group-item-text pull-right'>";
          //btn

          $esta_seguindo_usuario_sn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';
          $btn_seguir_display = 'block';
          $btn_deixarseguir_display = 'block';

          if ($esta_seguindo_usuario_sn == 'S') {
            # code...
            $btn_seguir_display = 'none';
          }else {
            # code...
            $btn_deixarseguir_display = 'none';
          }//end if ($esta_seguindo_usuario_sn == 'S')

          echo '<button type="button" style="display: '.$btn_seguir_display.'"class="btn btn-default btn_seguir" id="btn_seguir_'.$registro['id'].'" data-id_usuario="'.$registro['id'].'">Seguir</button>';
          echo '<button type="button" style="display: '.$btn_deixarseguir_display.'" class="btn btn-primary btn_deixar_seguir" id="btn_deixar_seguir_'.$registro['id'].'" data-id_usuario="'.$registro['id'].'">Deixar de Seguir</button>';
        echo "</p>";
        echo "<div class='clearfix'></div>";
      echo "</a>";

    }//end while ($registro = mysqli_fetch_array($resultado_id))

  }else {
    # code...
    echo "Erro na consulta de usuarios!";
  }//end if ($resultado_id)

?>
