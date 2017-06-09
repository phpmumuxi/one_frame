<?php
/**
 * 支付宝支付
 *
 * @Author Hardy
 */
class KO_Alipay extends CComponent
{
    //支付宝配置数组
    private $config = array('partner' => '2088211234859122', 'key' => 'fqmbi4okavfix6nk86tn24ytnk00lzkq', 'sign_type' => 'MD5', 'input_charset' => 'utf-8', 'cacert' => './lib/cacert.pem', 'transport' => 'http');
    /**
     * 引导支付宝付款页面
     * @param $a  支付参数
     * @param $tt 支付类型：0非合并，1合并
     */
    public function pay($a = array(), $tt = 0)
    {
        if (empty($a)) {
            return;
        }
        Yii::import('ext.alipay.lib.AlipaySubmit');
        //给一个数值设置默认值
        $default = array('tid' => '20131219369802366128', 'title' => '测试', 'total' => '0.01', 'body' => '购物付款', 'show_url' => '');
        foreach ($default as $k => $v) {
            $a[$k] = array_key_exists($k, $a) ? $a[$k] : $v;
        }
        $alipaySubmit = new AlipaySubmit($this->config);
        $parameter = array('service' => 'create_direct_pay_by_user', 'partner' => trim($this->config['partner']), 'payment_type' => '1', 'seller_email' => '13270572515@163.com', 'out_trade_no' => $a['tid'], 'subject' => $a['title'], 'total_fee' => $a['total'], 'body' => $a['body'], 'notify_url' => Yii::app()->controller->createAbsoluteUrl('/alipay/not/tt/' . $tt), 'return_url' => Yii::app()->controller->createAbsoluteUrl('alipay/ret/tt/' . $tt), 'show_url' => $a['show_url'], 'anti_phishing_key' => $alipaySubmit->query_timestamp(), 'exter_invoke_ip' => KO_Fun::get_client_ip(), '_input_charset' => trim(strtolower($this->config['input_charset'])));
        echo $alipaySubmit->buildRequestForm($parameter);
        exit;
    }
    /**
     * 同步和异步处理
     *  
     * 异步通知：如果商户反馈给支付宝的字符不是success这7个字符，支付宝服务器会不断重发通知，直到超过24小时22分钟。
     *           一般情况下，25小时以内完成8次通知（异步通知的间隔频率一般是：2m,10m,10m,1h,2h,6h,15h）
     */
    public function handle()
    {
        Yii::import('ext.alipay.lib.AlipayNotify');
        $an = new AlipayNotify($this->config);
        if ($an->verifyReturn()) {
            $tt = $_REQUEST['tt'];
            //支付类型：0非合并，1合并
            $tid = $_REQUEST['out_trade_no'];
            //商户订单号
            $no = $_REQUEST['trade_no'];
            //支付宝交易号
            $zt = $_REQUEST['trade_status'];
            //交易状态
            if ($zt == 'TRADE_FINISHED' || $zt == 'TRADE_SUCCESS') {
                $trans = Yii::app()->db->beginTransaction();
                try {
                    $b = array(':tid' => $tid);
                    $r = array();
                    $tn = '{{trade1}}';
                    $s1 = 'select tid from ' . $tn . ' where ';
                    $s2 = 'tid';
                    $s3 = '=:tid and status=1 and pay_status=1';
                    //等待买家付款
                    if ($tt == 1) {
                        //合并支付
                        $s2 = 'pay_id';
                        $r = Yii::app()->db->createCommand($s1 . $s2 . $s3)->queryAll(true, $b);
                    } else {
                        $r = Yii::app()->db->createCommand($s1 . $s2 . $s3)->queryRow(true, $b);
                    }
                    if (!empty($r)) {
                        $a = array('status' => 2, 'pay_status' => 2, 'trade_no' => $no, 'pay_at' => time());
                        foreach ($r as $v) {
                            $ko = Yii::app()->db->createCommand()->update($tn, $a, 'tid=:tid', array(':tid' => $v['tid']));
                            if ($ko > 0) {
                            }
                        }
                    }
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollBack();
                }
            }
            return 'success';
        }
        return 'fail';
    }
}
//end class