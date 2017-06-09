<?php
/**
 * QQ登录 - 逻辑处理
 *
 * @Author Hardy
 */
class Oauth_qq
{
    private $app_id = '';
    private $app_key = '';
    private $callback_url = '';
    private $access_token = '';
    private $open_id = '';
    const GET_AUTH_CODE_URL = 'https://graph.qq.com/oauth2.0/authorize';
    const GET_ACCESS_TOKEN_URL = 'https://graph.qq.com/oauth2.0/token';
    const GET_OPENID_URL = 'https://graph.qq.com/oauth2.0/me';
    //初始化
    public function __construct()
    {
        $a = Sys::get_config_data('site_connect', 1);
        $this->app_id = $a['qq_appid'];
        $this->app_key = $a['qq_appkey'];
        $this->callback_url = urlencode(KO_DOMAIN_URL . '/connect/oauth_back/ko/qq');
        //回调地址
    }
    //登录
    public function login()
    {
        $state = $_SESSION['koqq_sign_state'] = md5(uniqid(rand(), TRUE));
        $login_url = self::GET_AUTH_CODE_URL . '?response_type=code' . '&client_id=' . $this->app_id . '&redirect_uri=' . $this->callback_url . '&state=' . $state . '&scope=get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_t,add_pic_t';
        @header('Location: ' . $login_url);
        exit;
    }
    //登录回调验证
    public function callback()
    {
        $state = isset($_GET['state']) ? $_GET['state'] : '';
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if ($state = '' || !isset($_SESSION['koqq_sign_state']) || $state != $_SESSION['koqq_sign_state']) {
            exit('The state does not match. You may be a victim of CSRF.');
        }
        //get access token
        $token_url = self::GET_ACCESS_TOKEN_URL . '?grant_type=authorization_code' . '&client_id=' . $this->app_id . '&redirect_uri=' . $this->callback_url . '&client_secret=' . $this->app_key . '&code=' . $code;
        $response = $this->get_url_data($token_url);
        $params = array();
        parse_str($this->show_error($response), $params);
        $this->access_token = $params['access_token'];
        //get open id
        $graph_url = self::GET_OPENID_URL . '?access_token=' . $this->access_token;
        $response = $this->get_url_data($graph_url);
        $user = json_decode($this->show_error($response));
        if (isset($user->error)) {
            echo '<h3>error:</h3>' . $msg->error;
            echo '<h3>msg  :</h3>' . $msg->error_description;
            exit;
        }
        $this->open_id = $user->openid;
        unset($_SESSION['koqq_sign_state']);
        //登录后 - 网站处理
        $a = $this->get_user_info();
        Dao_Site::ko_oauth_login_handle('qq', $this->open_id, $this->access_token, $a);
    }
    //获取登录用户的昵称、头像、性别，返回数组
    public function get_user_info()
    {
        $url = 'https://graph.qq.com/user/get_user_info?' . 'access_token=' . $this->access_token . '&oauth_consumer_key=' . $this->app_id . '&openid=' . $this->open_id . '&format=json';
        $info = $this->get_url_data($url);
        $a = json_decode($info, true);
        $b['avatar'] = $a['figureurl_qq_2'];
        $b['nickname'] = trim($a['nickname']);
        return $b;
    }
    //发送请求
    private function get_url_data($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $str = curl_exec($ch);
        curl_close($ch);
        return $str;
    }
    //判断是否有错误
    private function show_error($response)
    {
        if (strpos($response, 'callback') !== false) {
            $lpos = strpos($response, '(');
            $rpos = strrpos($response, ')');
            $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
            $msg = json_decode($response);
            if (isset($msg->error)) {
                echo '<h3>error:</h3>' . $msg->error;
                echo '<h3>msg  :</h3>' . $msg->error_description;
                exit;
            }
        }
        return $response;
    }
}
//end class