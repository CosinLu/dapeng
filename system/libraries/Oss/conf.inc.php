<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Oss Server Config
 */

$_ci =& get_instance();
$_ci->load->config('oss');

$accessId = $_ci->config->item('oss_access_id');
if (!empty($accessId))
{
	// ACCESS_ID
	define('OSS_ACCESS_ID', $accessId);
}

$accessKey = $_ci->config->item('oss_access_key');
if (!empty($accessId))
{
	// ACCESS_KEY
	define('OSS_ACCESS_KEY', $accessKey);
}

$ossHost = $_ci->config->item('oss_bj_host');
if (!empty($ossHost))
{
	// OSS_HOSTNAME
	define('DEFAULT_OSS_HOST', $ossHost);
}

$aliLog = $_ci->config->item('ali_log');
if (!$aliLog)
{
	// 是否记录日志
	define('ALI_LOG', FALSE);
}

// 自定义日志路径，如果没有设置，则使用系统默认路径，在./logs/
// define('ALI_LOG_PATH','');

$aliDisplayLog = $_ci->config->item('ali_display_log');
if (!$aliDisplayLog)
{
	// 是否显示LOG输出
	define('ALI_DISPLAY_LOG', $aliDisplayLog);
}

$aliLang = $_ci->config->item('ali_lang');
if (!empty($aliLang))
{
	// 语言版本设置
	define('ALI_LANG', $aliLang);
}

// Oss Server Config End
