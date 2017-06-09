<?php
require_once('PHPMailerAutoload.php');
/**
 * 邮件处理类
 *
 * @Author Hardy
 */
class PHPMailer_Email {
    
    /**
     * 发送邮件
     * @param  $subject  邮件标题
     * @param  $body     邮件内容
     * @return  发送成功返回 true 否则 false
     */    
	public static function send($to_email='',$to_email2='', $output_name='' ,$to_name='朋友', $subject='问题列表', $body='任务更进问题完成') {
        $mail = new PHPMailer();
        $mail->IsSMTP(); //设定使用SMTP服务
        $mail->CharSet    = 'UTF-8'; //设置编码

        $mail->SMTPAuth   = true; //启用 SMTP 验证功能
        //$mail->SMTPSecure = 'ssl'; //安全协议，可以注释掉
        $mail->Host       = 'smtp.qq.com'; //SMTP 服务器
        $mail->Port       = 25; //SMTP服务器的端口号
        $mail->Username   = 'gandeyun@bestqikan.com.cn'; //SMTP服务器用户名
        $mail->Password   = 'konjjt1234'; //SMTP服务器密码

        
        $mail->SetFrom($mail->Username, '南京骥腾订单系统'); //发件信息地址和发件人名称
        //$mail->AddReplyTo('123456@qq.com', '邮件回复人的名称'); //回复信息地址和邮件回复人的名称
        $mail->AddAddress($to_email, $to_name); //发送至邮件信息
		$mail->AddAddress($to_email2, $to_name); //发送至邮件信息
        $mail->AddAttachment($output_name,'附件详情.xls'); // 添加附件,并指定名称 
        $mail->Subject = $subject; //邮件标题
        $mail->isHTML( true ); //设置邮件格式为HTML
        $mail->Body = self::get_html( $to_name, $body ); //HTML邮件
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; //纯文本的非HTML
        //echo $mail->Body;exit;
        if (!$mail->send()) {
			//print_r($mail->ErrorInfo);
            return false; //发送失败
        } else {
            return true; //发送成功
        }
    }

	//获取发邮件的模板
	public static function get_html($to_name='', $str='') {
		$s = '<div style="line-height:160%;padding:8px 10px;margin:0;overflow:auto;">
			  <div style="font-size:18px;font-weight:bold;margin-bottom:15px;">尊敬的 <span style="color:blue;">'.$to_name.'</span> :</div>
			  <div style="font-size:15px;word-wrap:break-word;">
			  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$str.'</p>
			  </div><div style="font-size:12px;border-top:1px solid #CCCCCC;color:#A6A6A6;">
			  <p>注：这是一封系统自动生成的邮件，请勿直接回复本邮件。</p>
			  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果此邮件在您的垃圾邮箱中，请移入收件箱以方便后续查收。</p>
			</div></div>';
		return $s;
	}
    
    //给系统用户发送邮件
    public static function user_send($id=0, $subject='', $body='') {
        $a = Dao_Base::get_user_row( $id );
        PHPMailer_Email::send($a['email'], $a['realname'], $subject, $body);
    }
} //end class