<?php
    require_once 'php_function/general.php'; //general php function
    require_once 'php_function/function_report.php';
    
    /*get user information*/
    $user_name = $_SESSION["sess_uname"];
    $user_id = $_SESSION["sess_uid"];
    $user_grroup = $_SESSION["sess_ugroup"];


    /*2 level user cannnot visit this page*/
    if($user_grroup == 2)
    {
        header("Location: index.php");
    }
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function send_mail($content,$subscriber)
{

    require_once './PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
    require_once './PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once './PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    //服务器配置
    $mail->CharSet ="UTF-8";                     //设定邮件编码
    $mail->SMTPDebug = 0;                        // 调试模式输出
    $mail->isSMTP();                             // 使用SMTP
    $mail->Host = '';                // SMTP服务器
    $mail->SMTPAuth = true;                      // 允许 SMTP 认证
    $mail->Username = '';                // SMTP 用户名  即邮箱的用户名
    $mail->Password = '';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
    $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

    $mail->setFrom('', 'Inventory Management System');  //发件人
    $mail->addAddress($subscriber, 'Dear User');  // 收件人
    //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
    $mail->addReplyTo('', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
    //$mail->addCC('cc@example.com');                    //抄送
    //$mail->addBCC('bcc@example.com');                    //密送

    //发送附件
    // $mail->addAttachment('../xy.zip');         // 添加附件
    // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名

    //Content
    $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
    $mail->Subject = '物资动态';
    //$mail->Body    = '<h1>这里是邮件内容</h1>' . date('Y-m-d H:i:s');
    $mail->Body = $content;
    $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

    $mail->send();
    echo ' 邮件发送成功';
}