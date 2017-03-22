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
         $msg .= "Corrija os erros abaixo.<br/>";
         $msg .= $error . "<br/>";
         response('error', array('msg' => $msg, 'campo' => $campo));
    }


    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'O endereço de e-mail que você digitou não parece ser válido.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $nome)) {
        $error_message .= 'O nome introduzido não parece ser válido.<br />';
    }

    if (!preg_match($string_exp, $assunto)) {
        $error_message .= 'O Assunto que você digitou não parece ser válido.<br />';
    }

    if (strlen($mensagem) < 2) {
        $error_message .= 'A Mensagem que você digitou não parecem ser válidos.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
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

?>

