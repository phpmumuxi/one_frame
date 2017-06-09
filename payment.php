<?php
/** 
 * 支付 - 控制器
 *
 * @Author  Hardy
 */
class paymentController extends FrontController {

	//支付宝
	function alipay() {
        $param = array();
        if ($_POST) {
            $alimoney = isset($_POST['alimoney']) ? floatval($_POST['alimoney']) : 0;
            $alibody = isset($_POST['alibody']) ? trim($_POST['alibody']) : '';
            if ($alimoney == '') {
                showMsg('请输入付款金额');
            }
            if (!preg_match('/^\d*\.?\d{0,2}$/', $alimoney)) {
                showMsg('请正确输入付款金额，最小值0.01');
            }
            $pay_arr = array(
                'tid' => date('Ymdhms'), 'title' => '订单支付',
                'total' => $alimoney, 'body' => $alibody,
            );
            $ko = new Alipay_Init(); $ko->pay( $pay_arr );
        }
		$this->render('alipay', $param, 'main');
	}
    
    //付款同步页面
    function ret() {
        $ko = new Alipay_Init(); $s = $ko->handle( 1 );
        if ($s == 'success') {
            showMsg('恭喜你付款成功', '/', 1);
        } else {
            showMsg('付款失败，可以联系客服说明', '/');
        }
    }
    
    //付款异步页面
    function not() {
        $ko = new Alipay_Init(); echo $ko->handle( 2 );
    }

} //end class