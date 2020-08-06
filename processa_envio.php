<?php
    //Classe Mensagem
    require_once "Mensagem.php";

    //Classes do PHPMailer
    require_once "./bibliotecas/PHPMailer/Exception.php";
    require_once "./bibliotecas/PHPMailer/OAuth.php";
    require_once "./bibliotecas/PHPMailer/PHPMailer.php";
    require_once "./bibliotecas/PHPMailer/POP3.php";
    require_once "./bibliotecas/PHPMailer/SMTP.php";

    //
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mensagem = new Mensagem();

    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    /*
    echo "<pre>";
        print_r($mensagem);
    echo "</pre>";
    */
    


   if(!$mensagem->mensagemValida()){
       echo "Mensagem é invalida";
       //die(); // Mata o processamento do script caso ele caia nesse if // descarta tudo quando chega aqui
       header('Location: index.php'); // caso tentem acessar o script direto essa instrução retorna para index.php
   }

    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = false;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '';                 // SMTP username
        $mail->Password = '';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('', '');
        $mail->addAddress($mensagem->__get('para'));     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'É necessário utilizar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem';

        $mail->send();

        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso';

    } catch (Exception $e) {

        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['descricao_status'] = 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro: ' . $mail->ErrorInfo;
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>App Mail Send</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
        
    <body>
        <div class="container">
            <div class="py-3 text-center">
                    <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
                    <h2>Send Mail</h2>
                    <p class="lead">Seu app de envio de e-mails particular!</p>
            </div>

            <div class="row">
                <div class="col-md-12">
                    
                    <?php if($mensagem->status['codigo_status'] == 1){ ?>
                            <div class="container">
                                <h1 class="display-4 text-success">Sucesso</h1>
                                <p><?php $mensagem->status['descricao_status'] ?></p>
                                <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                            </div>

                    <?php } ?>

                    <?php if($mensagem->status['codigo_status'] == 2){ ?>
                            <div class="container">
                                <h1 class="display-4 text-danger">Ops!</h1>
                                <p><?php $mensagem->status['descricao_status'] ?></p>
                                <a href="index.php" class="btn btn-sucess btn-lg mt-5 text-white">Voltar</a>
                            </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>