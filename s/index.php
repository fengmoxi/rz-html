<?php
//不顯示任何錯誤
error_reporting(0);

//搜索頁面URL
$url = $_GET['url'];

//取得存有域名資料的PHP內容
$site_file = file_get_contents("site.php");

//將「site.php」內的数据由「|」分開
$site = explode("|", $site_file);


//網站完整URL
$url_long = $url;

function str_cut($str, $pre, $end) {
	$pos_pre = strpos($str, $pre) + strlen($pre);
	$str_end = substr($str, $pos_pre);
	$pos_end = strpos($str_end, $end);
	return substr($str, $pos_pre, $pos_end);
}

//將網站首頁及內頁使用「/」分開
$site_url_array = explode("/", $url);

if (!empty($site_url_array['1'])){				//如果是搜索網頁
	$site_url_name = "页面";
}else{
	$site_url_name = "站点";
}

/*************************************主程序********************************/

function check_domain($vaild_url, $from_url){
	$from_url_dot = explode($vaild_url, $from_url);
	if(empty($from_url_dot[1])){
		$from_url_dot_explode = explode(".", $from_url_dot[0]);
		if(isset($from_url_dot_explode[1])){
			$from_host = $from_url_dot_explode[1];
		}else{
			$from_host = $from_url_dot_explode[0];
		}
		if(!empty($from_host)){
			return FALSE;
		}else{
			return TRUE;
		}
	}
}

foreach ($site as $ssite) {
if(check_domain($ssite, $url)){
	//將可信認證設定為TRUE
	$url_rz = TRUE;
	$header = @get_headers($url_long);
	if(preg_match('/200/', $header[0])){
		//讀取網頁源始碼
		$url_fp = file_get_contents($url_long);
		//轉換UTF-8代碼
		iconv("UTF-8", "GB2312//IGNORE", $url_fp);
		//獲取網頁標題
		$title = str_cut($url_fp,'<title>','</title>');
		//獲取網站Description及Keywords
		$metatag = get_meta_tags($url_long);
		$description = $metatag["description"];
		$keywords = $metatag["keywords"];
	}else if(preg_match('/301/', $header[0])){
		$title = "亲～您的确是一个认证成员，但你输入的网址是一个301跳转页面";
		$description = "所以我们无法提取您网站的信息哦！";
		$keywords = "如有不便，尽情谅解！";
	}else{
		$title = "亲～您虽然是认证成员，但是您的网站无法访问啊！";
		$description = "请快快检查您的网站有没有问题吧！";
		$keywords = "等您的网站恢复正常以后，这里会自动提取您网站的信息哦！";
	}
}
}

//錯誤信息（包括彩蛋）
include("./err_message.php");
?>
<?php include '../function.php'; ?>
<?php get_header(); ?>
<?php if (empty($_GET['url'])){ ?>
	<div class="alert alert-danger">亲~系统酱提醒您，你=您还没输入任何内容哦~</div>
<?php }else if (!empty($url_rz)){ ?>
	<div class="alert alert-success">恭喜~这是已授权的<?php echo NAME; ?>的正式成员~</div>
	<h2>可信认证</h2>
	<hr/>
	查询信息：<?php echo $url_long; ?><br />
<?php }else{ ?>
	<div class="alert alert-danger"><?php echo $err_message; ?></div>
	查询信息：<?php echo $url_long; ?><br />
<?php } ?>
<?php get_footer(); ?>