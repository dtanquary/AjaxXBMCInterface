<?
	//must set the contenttype of response as text/xml
	header("Content-type: text/xml;charset=UTF-8;");
	header("Cache-Control: no-cache, must-revalidate");

	$url = str_replace("aaa", "(", $url);
	$url = str_replace("bbb", ")", $url);
	//include($url);

	$remote_page = file_get_contents($url);
	$remote_page = str_replace("<html>", "", $remote_page);
	$remote_page = str_replace("</html>", "", $remote_page);
	//$remote_page = str_replace("<li>", "", $remote_page);
	$remote_page = str_replace("<li>", "|", $remote_page);

	echo $remote_page;
	$this->session->set_userdata('nowPlaying', $remote_page);

	$currenPlaylist = file_get_contents($playlistURL);
	$this->session->set_userdata('currentPlaylist', $currentPlaylist);

?>
