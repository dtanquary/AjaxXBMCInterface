<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();
		$this->load->model('now_playing');
	}
	
	function index()
	{

		$xbmc_url = $this->config->item('xbmc_url');

		$header['page_title'] = "XBMC Ajax Prototype Interface";
		$header['base_url'] = base_url();
		$header['extraHeaderInfo'] = "<script>var xbmc_url = '".$xbmc_url."';</script>";

		$data['header'] =  $this->load->view('templates/header', $header);
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('home/home', $data);
	}

	function nowPlaying()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$nowPlayingBlob =  $this->session->userdata('nowPlaying');
		$blocks = explode('|', $nowPlayingBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('nowPlaying/nowPlayingView', $data);
	}

	function currentPlaylist()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$currentPlaylistBlob =  $this->session->userdata('currentPlaylist');
		$blocks = explode('|', $currentPlaylistBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('home/currentPlaylist', $data);

	}

	function recentlyPlayed()
	{
		$limit = "10";
		$data['query'] = $this->now_playing->getNowPlayingData($limit);
		$this->load->view('home/recentlyPlayed', $data);
	}

	function getVideoShares()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$videoShareBlob =  $this->session->userdata('video_share');
		$blocks = explode('|', $videoShareBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('videoSharesView', $data);
	}

	function getMusicShares()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$nowPlayingBlob =  $this->session->userdata('music_share');
		$blocks = explode('|', $nowPlayingBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('musicSharesView', $data);
	}

	function getDirectory()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$nowPlayingBlob =  $this->session->userdata('remote_page');
		$blocks = explode('|', $nowPlayingBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('browseDirectoryView', $data);
	}

	function getVideoDirectory()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$nowPlayingBlob =  $this->session->userdata('remote_page');
		$blocks = explode('|', $nowPlayingBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('browseVideoDirectoryView', $data);
	}

	function getMusicDirectory()
	{
		$xbmc_url = $this->config->item('xbmc_url');
		$nowPlayingBlob =  $this->session->userdata('remote_page');
		$blocks = explode('|', $nowPlayingBlob);
		$length = count($blocks);

		$data['array'] = $blocks;
		$data['size'] = $length;
		$data['xbmc_url'] = $xbmc_url;

		$this->load->view('browseMusicDirectoryView', $data);
	}

	function ajaxTitle() {
		//echo "Now Playing: ";
		echo $this->session->userdata('NowPlayingTitle');
	}

}

?>
