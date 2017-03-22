<?php

include_once './funcoes.php';
$email = $_POST['email'];
$nome = $_POST['nome'];
$assunto = $_POST['assunto'];
$mensagem = $_POST['mensagem'];
$fone = $_POST['fone'];

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "haut@clinicahaut.com.br";
    $email_subject = "Perguntas a Clínica Haut";

    // validation expected data exists
    if (!isset($nome) || $nome == "" ||
            !isset($assunto) || $assunto == "" ||
            !isset($email) || $email == "" ||
            !isset($fone) || $fone == "" ||
            !isset($mensagem) || $mensagem == "") {
        $error = "";
        $campo ="";
        if (!isset($nome) || $nome == "") {
           $error .= 'O campo nome é Obrigatório.<br/>';
           $campo .= '#nome,';
        }
        if (!isset($email) || $email == "") {
           $error .= 'O campo email é Obrigatório.<br/>'; 
           $campo .= '#email,';
        }
        if (!isset($fone) || $fone == "") {
           $error .= 'O campo telefone é Obrigatório.<br/>'; 
           $campo .= '#fone,';
        }
        if (!isset($assunto) || $assunto == "") {
           $error .= 'O campo assunto é Obrigatório.<br/>';
           $campo .= '#assunto,';
        }
        if (!isset($mensagem) || $mensagem == "") {
           $error .= 'O campo mensagem é Obrigatório.<br/>'; 
           $campo .= '#mensagem,';
        }
        
         $msg = "Lamentamos, mas houve erros encontrados com o formulário enviado.<br/> ";
         $msg .= "Corrija os erros abaixo:<br/>";
         $msg .= $error . "<br/>";
         $campo = substr($campo, 0, -1);
         $campo = explode(',', $campo);
         response('error', array('msg' => $msg, 'campo' => $campo));
    }


    $error_message = "Lamentamos, mas houve erros encontrados com o formulário enviado.<br/> Corrija os erros abaixo:<br/>";
    
    $campo = "";
    $string_exp = "/^[A-Za-z .'-]+$/";
    
    if (!preg_match($string_exp, $nome) || strlen($nome) < 2) {
        $error_message .= 'O nome introduzido não parece ser válido.<br />';
        $campo .= '#nome,';
    }
    
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if (!preg_match($email_exp, $email)) {
        $error_message .= 'O endereço de e-mail que você digitou não parece ser válido.<br />';
        $campo .= '#email,';
    }
    if (strlen($fone) < 5) {
        $error_message .= 'O telefone que você digitou não parece ser válido.<br />';
        $campo .= '#fone,';
    }

    if (!preg_match($string_exp, $assunto) && strlen($assunto)> 2) {
        $error_message .= 'O Assunto que você digitou não parece ser válido.<br />';
        $campo .= '#assunto,';
    }
    
    if (strlen($mensagem) < 2) {
        $error_message .= 'A Mensagem que você digitou não parece ser válidos.<br />';
        $campo .= '#mensagem,';
    }
    $msg_erro = strlen($error_message);
    if ($msg_erro > 101) {
        $campo = substr($campo, 0, -1);
        $campo = explode(',', $campo);
        response('error', array('msg' => $error_message, 'campo' => $campo));
    }
    
    $email_message = "Detalhes do email.\n\n";

    function clean_string($string) {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Nome: " . clean_string($nome) . "\n";
    $email_message .= "Assunto: " . clean_string($assunto) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Fone: " . clean_string($fone) . "\n";
    $email_message .= "Mensagem: " . clean_string($mensagem) . "\n";

// create email headers
    $headers = 'From: ' . $email . "\r\n" .
            'Reply-To: ' . $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    $email_ok = mail($email_to, $email_subject, $email_message, $headers);
    if($email_ok){
        response('success', array('msg' => 'Seu email foi enviado com sucesso!'));
    }

?>

