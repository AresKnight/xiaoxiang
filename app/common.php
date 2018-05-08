<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * Title: 发送邮件
 * Notes:send_email
 * @param $to
 * @param string $subject
 * @param string $content
 * @param $fromName
 * @return array
 */
function send_email($to,$subject='',$content='', $fromName){
    vendor('phpmailer.PHPMailerAutoload'); ////require_once vendor/phpmailer/PHPMailerAutoload.php';
    //判断openssl是否开启
    $openssl_funcs = get_extension_funcs('openssl');
    if(!$openssl_funcs){
        return array('status'=>-1 , 'msg'=>'请先开启openssl扩展');
    }
    $mail = new \PHPMailer\PHPMailer;
    $Cmail = config('mail');
    if($Cmail['unlock'] !== false) {
        $mail->IsSMTP();
        //smtp服务器
        $mail->Host = $Cmail['SMTP'];
        //邮件发送端口
        $mail->Port = $Cmail['port'];
        //是否验证
        $mail->SMTPAuth=true;
        //字符集
        $mail->CharSet='UTF-8';
        //用户名和密码
        $mail->Username=$Cmail['email'];
        $mail->Password=$Cmail['pwd'];
        //邮件标题
        $mail->Subject=$subject;
        //收件人地址
        $mail->From=$Cmail['email'];
        //发件人名称
        $mail->FromName = $fromName;

        // $mail->setFrom($Cmail['email']);

        $mail->AddAddress($to);
        $mail->IsHTML(true);
        $mail->Body = $content;

        if($mail->Send()) {
            return jsdata(200, '发送成功！', '');
        }else{
            return jsdata(0, '发送失败，'. $mail->ErrorInfo, 'javascript:;', 2);
        };
    }else{
        return jsdata(0, '邮箱未开启！', 'javascript:;');
    }
}
//登录ip地址
function Getiplookup($ip){
    if($ip == '127.0.0.1') return '本地';
    $api = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='. $ip;
    $json = @file_get_contents($api);//调用新浪IP地址库
    $arr = json_decode($json,true);
    $country = $arr['country']; //国家
    $province = $arr['province']; //省份
    $city = $arr['city']; //城市
    $lookup = $country. ' '.$province.' '.$city;
    return $lookup;

}