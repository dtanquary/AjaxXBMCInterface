<?php

class xbmc extends Controller {

	function xbmc()
	{
		parent::Controller();	
	}
	
	function index()
	{
	}

	function getNowPlaying() {
		$xbmc_url = $this->config->item('xbmc_url');
		$thumb_code = time();
		$new_image = $xbmc_url . "thumb" . $thumb_code . ".jpg";
		if (@fclose(@fopen($new_image, "r"))) {
			$this->session->set_userdata('thumb_code', $thumb_code);
		}
		$this->session->set_userdata('new_code', $thumb_code);
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=getcurrentlyplaying(/usr/share/xbmc/web/thumb".$thumb_code.".jpg)";
		$data['url'] = $url;
		//$data['xbmc_url'] = $xbmc_url;
		$this->load->view('nowPlaying', $data);
	}

	function getVideoShares()  {
		$xbmc_url = $this->config->item('xbmc_url');
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=GetShares(video)";
		$data['url'] = $url;
		//$data['xbmc_url'] = $xbmc_url;
		$this->load->view('proxy', $data);
	}

	function getMusicShares()  {
		$xbmc_url = $this->config->item('xbmc_url');
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=GetShares(music)";
		$data['url'] = $url;
		//$data['xbmc_url'] = $xbmc_url;
		$this->load->view('proxy', $data);
	}

	function getDirectory()  {
		$xbmc_url = $this->config->item('xbmc_url');
		$path = $this->input->post('path');
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=GetDirectory(".$path.")";
		$data['url'] = $url;
		//$data['xbmc_url'] = $xbmc_url;
		$this->load->view('proxy', $data);
	}

	function sendCommand() {
		$command = $this->uri->segment(3);
		$xbmc_url = $this->config->item('xbmc_url');
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=" . $command;

		$data['url'] = $url;
		$this->load->view('proxy', $data);
	}
/*

	function playFile() {
		$path = $this->input->post('path');
		$xbmc_url = $this->config->item('xbmc_url');
		$url = $xbmc_url . "xbmcCmds/xbmcHttp?command=playFile(" . $path . ");

		$data['url'] = $url;
		$this->load->view('proxy', $data);
	}
*/
}
?>
