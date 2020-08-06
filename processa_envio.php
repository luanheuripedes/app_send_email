<?php
    require_once "Mensagem.php";

    $mensagem = new Mensagem();

    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    /*
    echo "<pre>";
        print_r($mensagem);
    echo "</pre>";
    */

   if($mensagem->mensagemValida()){
       echo "Valida";
   }else{
       echo "invalida";
   }
   
?>