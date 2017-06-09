<div class="page">
  <div class="item-title">
    <h3>您好，<?php echo $_SESSION['ko_htuser_info']['users']; ?>，欢迎使用。<?php echo $_SESSION['ko_htuser_info']['last_at']>0 ? '您上次登录的时间是：'.date('Y-m-d H:i:s', $_SESSION['ko_htuser_info']['last_at']) : ''; ?></h3>
  </div>
  <table class="table tb-type2">
    <thead class="thead">
      <tr class="space">
        <th colspan="10">系统信息</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="w12"></td>
        <td class="w108"><strong>服务器操作系统:</strong></td>
        <td class="w25pre"><?php echo PHP_OS; ?></td>
        <td class="w120"><strong>服务器系统时间:</strong></td>
        <td><?php echo date('Y-m-d H:i:s'); ?></td>
      </tr>
      <tr>
        <td></td>
        <td><strong>PHP 版本:</strong></td>
        <td><?php echo PHP_VERSION; ?></td>
        <td><strong>MYSQL 版本:</strong></td>
        <td><?php echo $sql_version; ?></td>
      </tr>
      <tr>
        <td></td>
        <td><strong>PHP运行模式:</strong></td>
        <td><?php echo strtoupper(php_sapi_name()); ?></td>
        <td><strong>WEB 服务器:</strong></td>
        <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
      </tr>
    </tbody>
	<tfoot>
      <tr class="tfoot">
        <td colspan="10"></td>
      </tr>
    </tfoot>
  </table>
</div>