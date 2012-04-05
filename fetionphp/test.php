<<<<<<< HEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>飞信短信发送测试 --- PHP 版</title>
</head>

<body>
<?php
/*
	$phone_num 发信人的电话号码，需要开通了飞信
	$password 发信人飞信密码
	$tophone 要发送的目的电话号码，需要在飞信中添加为好友
	$msg 要发送的文本内容
    $sms->sendSMS_toPhone($tophone,$message);//$_CFG['sms_shop_mobile']

*/

require_once('includes/class.fetion.php');
$tophone=trim($_POST['tophone']);
$message=trim($_POST['message']);
$sms = new Fetion;
$sms->phone_num = trim($_POST['phone']);//$_CFG['sms_shop_mobile']
$sms->password = trim($_POST['fetion_password']) ;//$_CFG['sms_fetion_password']
$sms->sip_login();
$sms->sendSMS_toPhone($tophone,iconv('UTF-8', 'gb2312', $message));//$_CFG['sms_shop_mobile']
$sms->sip_logout();
unset($Fetion);
echo $message;
?>
测试:w
</body>
</html>
=======
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>飞信短信发送测试 --- PHP 版</title>
</head>

<body>
<?php
/*
	$phone_num 发信人的电话号码，需要开通了飞信
	$password 发信人飞信密码
	$tophone 要发送的目的电话号码，需要在飞信中添加为好友
	$msg 要发送的文本内容
    $sms->sendSMS_toPhone($tophone,$message);//$_CFG['sms_shop_mobile']

*/

require_once('includes/class.fetion.php');
$tophone=trim($_POST['tophone']);
$message=trim($_POST['message']);
$sms = new Fetion;
$sms->phone_num = trim($_POST['phone']);//$_CFG['sms_shop_mobile']
$sms->password = trim($_POST['fetion_password']) ;//$_CFG['sms_fetion_password']
$sms->sip_login();
$sms->sendSMS_toPhone($tophone,iconv('UTF-8', 'gb2312', $message));//$_CFG['sms_shop_mobile']
$sms->sip_logout();
unset($Fetion);
echo $message;
?>
测试:w
</body>
</html>
>>>>>>> e79fba4c37b2c02476590015a5952175b7fd5b25
