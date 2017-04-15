<?php
  //iniciando session
  session_start();
  require_once('db.class.php');

  if (!isset($_SESSION['usuario'])) {
    # code...
    header('Location: index.php?erro=1');
  }//end if (!isset($_SESSION['usuario']))

  $id_usuario = $_SESSION['id'];
  $qtd_tweets = 0;
  $qtd_seguidores = 0;


  $objDb = new db();
  $link = $objDb->conecta_mysql();

  //qtde de tweets
  $sql = "select count(*) as qtd_tweets from tweet where id_usuario = $id_usuario";
  $resultado_id = mysqli_query($link, $sql);

  if ($resultado_id) {
    # code...
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtd_tweets = $registro['qtd_tweets'];
  }else {
    # code...
    echo "Erro ao executar query!";
  }//end //end if ($resultado_id)

  //qtde de seguidores
  $sql = "select count(*) as qtd_seguidores from usuarios_seguidores where seguindo_id_usuario = $id_usuario";
  $resultado_id = mysqli_query($link, $sql);

  if ($resultado_id) {
    # code...
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtd_seguidores = $registro['qtd_seguidores'];
  }else {
    # code...
    echo "Erro ao executar query!";
  }//end //end if ($resultado_id)


?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script type="text/javascript">
      //usando jquery
      $(document).ready( function(){

        $('#btn_tweet').click( function(){

          //possui conteúdo
          if ($('#texto_tweet').val().length > 0) {

            $.ajax({
              url: 'inclui_tweet.php',
              method: 'post',
              data: $('#form_tweet').serialize(),
              success: function(data){
                $('#texto_tweet').val('');
                atualizaTweet();//alert('Tweet incluído com sucesso!');
              }//end function(data)

            });//end $.ajax


          }//end if ($('#texto_tweet').val().length > 0)

        });//end $('#btn_tweet').click( function()

        function atualizaTweet(){
          //carrear os tweets
          $.ajax({
            url: 'get_tweet.php',
            success: function(data){
              $('#tweets').html(data);
            }//end success: function(data)

          });//end $.ajax

        }//end function atualizaTweet()

        atualizaTweet();

      });

    </script>

	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>

	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
              <li><a href="home.php">Home</a></li>
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>

	    <div class="container">

         <div class="col-md-3">
           <div class="panel panel-default">
             <div class="panel-body">

                <h4><?= $_SESSION['usuario']?></h4>
                <hr/>

                <div class="col-md-6">
                  TWEETS <br> <?=$qtd_tweets?>
                </div>

                <div class="col-md-6">
                  SEGUIDORES <br> <?=$qtd_seguidores?>
                </div>

             </div>
           </div>
         </div>

         <div class="col-md-6">

           <div class="panel panel-default">
             <div class="panel-body">

               <form id="form_tweet" class="input-group">

                 <input type="text" class="form-control" id="texto_tweet" name="texto_tweet" placeholder="O que está acontecendo agora?" maxlength="140">

                 <span class="input-group-btn">
                   <button type="button" class="btn btn-default" name="button" id="btn_tweet">Tweet</button>
                 </span>

               </form>

             </div>
           </div>

           <div id="tweets" class="list-group">

           </div>

         </div>

         <div class="col-md-3">
           <div class="panel panel-default">
             <div class="panel-body">

              <h4><a href="procurar_pessoas.php">Procurar pessoas</a></h4>

             </div>
           </div>
         </div>

		  </div>


		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>
