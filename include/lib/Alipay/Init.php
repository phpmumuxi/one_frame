<?php
/**
 * 支付宝支付
 *
 * @Author Hardy
 */
class Alipay_Init
{
    //支付宝配置数组
    private $config = array('partner' => '2088211234859122', 'key' => 'fqmbi4okavfix6nk86tn24ytnk00lzkq', 'sign_type' => 'MD5', 'input_charset' => 'utf-8', 'cacert' => './lib/cacert.pem', 'transport' => 'http', 'seller_email' => '123@qq.com');
    function __construct()
    {
        $a = Dao_Site::ko_get_configs(3);
        $this->config['partner'] = $a['ko_alipay_partner'];
        $this->config['key'] = $a['ko_alipay_key'];
        $this->config['seller_email'] = $a['ko_alipay_seller_email'];
    }
    /**
     * 引导支付宝付款页面
     * @param $a  支付参数
     */
    public function pay($a = array())
    {
        if (empty($a)) {
            return;
        }
        //给一个数值设置默认值
        $default = array('tid' => '20131219369802366128', 'title' => '测试', 'total' => '0.01', 'body' => '购物付款', 'show_url' => '');
        foreach ($default as $k => $v) {
            $a[$k] = array_key_exists($k, $a) ? $a[$k] : $v;
        }
        include 'lib/alipay_submit.class.php';
        $alipaySubmit = new AlipaySubmit($this->config);
        $parameter = array('service' => 'create_direct_pay_by_user', 'payment_type' => '1', 'partner' => $this->config['partner'], 'seller_email' => $this->config['seller_email'], 'out_trade_no' => $a['tid'], 'subject' => $a['title'], 'total_fee' => $a['total'], 'body' => $a['body'], 'return_url' => KO_DOMAIN_URL . '/cart/ret', 'notify_url' => KO_DOMAIN_URL . '/cart/not', 'show_url' => $a['show_url'], 'anti_phishing_key' => $alipaySubmit->query_timestamp(), 'exter_invoke_ip' => Public_Http::get_client_ip(), '_input_charset' => strtolower($this->config['input_charset']));
        echo $alipaySubmit->buildRequestForm($parameter);
        exit;
    }
    /**
     * 同步和异步处理
     * @param  $t  1同步，2异步 
     * 异步通知：如果商户反馈给支付宝的字符不是success这7个字符，支付宝服务器会不断重发通知，直到超过24小时22分钟。
     *           一般情况下，25小时以内完成8次通知（异步通知的间隔频率一般是：2m,10m,10m,1h,2h,6h,15h）
     */
    public function handle($t = 0)
    {
        include 'lib/alipay_notify.class.php';
        $a = new AlipayNotify($this->config);
        $ret = false;
        if ($t == 1) {
            $ret = $a->verifyReturn();
        } elseif ($t == 2) {
            $ret = $a->verifyNotify();
        }
        if ($ret) {
            $tid = $_REQUEST['out_trade_no'];
            //商户订单号
            $no = $_REQUEST['trade_no'];
            //支付宝交易号
            $zt = $_REQUEST['trade_status'];
            //交易状态
            if ($zt == 'TRADE_FINISHED' || $zt == 'TRADE_SUCCESS') {
            }
            return 'success';
        }
        return 'fail';
    }
}
//end class