<?php
  //iniciando session
  session_start();

  //eliminando indices do array de sessão (encerrando sessão)
  unset($_SESSION['usuario']);
  unset($_SESSION['email']);

  //direcionando para a pagina inicial
  header('Location: index.php');

?>
