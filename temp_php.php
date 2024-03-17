<?
include './auth_vk/config.php';
?>
<!-- https://dev.vk.com/api/access-token/authcode-flow-user -->
<a href="https://oauth.vk.com/authorize?client_id=<?=ID?>&display=page&redirect_uri=<?=URL?>&scope=photos&response_type=code&v=5.131" target="_blank">VK AUTHORIZE</a>