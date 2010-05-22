<?
	//must set the contenttype of response as text/xml
	header("Content-type: text/xml;charset=UTF-8;");
	header("Cache-Control: no-cache, must-revalidate");

	$url = str_replace("aaa", "(", $url);
	$url = str_replace("bbb", ")", $url);
	//$url = str_replace("ccc", "/", $url);
	//include($url);

	$remote_page = file_get_contents($url);
	$remote_page = str_replace("<html>", "", $remote_page);
	$remote_page = str_replace("</html>", "", $remote_page);
	//$remote_page = str_replace("<li>", "", $remote_page);
	$remote_page = str_replace("<li>", "|", $remote_page);

	echo $remote_page;
	$this->session->set_userdata('video_share', $remote_page);

?>
