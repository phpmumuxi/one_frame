<?php
/**
 * 新浪微博登录 - 逻辑处理
 *
 * @Author Hardy
 */
class Oauth_sina
{
    private $sina_wappkey = '';
    private $sina_wappsecret = '';
    private $callback_url = '';
    private $access_token = '';
    private $open_id = '';
    //初始化
    public function __construct()
    {
        $a = Sys::get_config_data('site_connect', 1);
        $this->sina_wappkey = $a['sina_wappkey'];
        $this->sina_wappsecret = $a['sina_wappsecret'];
        $this->callback_url = KO_DOMAIN_URL . '/connect/oauth_back/ko/sina';
        //回调地址
    }
    //登录
    public function login()
    {
        include_once 'sina.saetv2.ex.class.php';
        $ko = new SaeTOAuthV2($this->sina_wappkey, $this->sina_wappsecret);
        $login_url = $ko->getAuthorizeURL($this->callback_url);
        @header('Location: ' . $login_url);
        exit;
    }
    //登录回调验证
    public function callback()
    {
        include_once 'sina.saetv2.ex.class.php';
        $ko = new SaeTOAuthV2($this->sina_wappkey, $this->sina_wappsecret);
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = $this->callback_url;
            try {
                $this->access_token = $ko->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
            }
        }
        if ($this->access_token) {
            $this->open_id = $this->access_token['uid'];
            setcookie('weibojs_' . $this->client_id, http_build_query($this->access_token));
            //登录后 - 网站处理
            $a = $this->get_user_info();
            $_SESSION['kosina_access_token'] = $this->access_token['access_token'];
            Dao_Site::ko_oauth_login_handle('sina', $this->open_id, $this->access_token['access_token'], $a);
        } else {
            exit('授权失败');
        }
    }
    //获取登录用户的昵称、头像、性别，返回数组
    public function get_user_info()
    {
        include_once 'sina.saetv2.ex.class.php';
        $ko = new SaeTClientV2($this->sina_wappkey, $this->sina_wappsecret, $this->access_token['access_token']);
        $uid_get = $ko->get_uid();
        $a = $ko->show_user_by_id($uid_get['uid']);
        $b['avatar'] = $a['avatar_large'];
        $b['nickname'] = trim($a['screen_name']);
        return $b;
    }
    //取消授权
    public function ko_revoke()
    {
        if (isset($_SESSION['kosina_access_token']) && $_SESSION['kosina_access_token'] != '') {
            $url = 'https://api.weibo.com/oauth2/revokeoauth2?access_token=' . $_SESSION['kosina_access_token'];
            $ko = $this->get_url_data($url);
            if ($ko) {
                unset($_SESSION['kosina_access_token']);
            }
        }
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
}
//end class