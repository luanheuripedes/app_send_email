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
       die(); // Mata o processamento do script caso ele caia nesse if // descarta tudo quando chega aqui
   }

    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user@example.com';                 // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde';
        echo 'Detalhes do erro: ' . $mail->ErrorInfo;
    }

?>