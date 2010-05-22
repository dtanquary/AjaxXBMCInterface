<?php

class now_playing extends Model {

	function now_playing()
	{
		parent::Model();	
	}

	function writeNowPlayingData($thumb) {
		$nowPlayingData = $this->session->userdata('nowPlaying');
		$data = array(
               'blob' => $nowPlayingData,
               'thumb' => $thumb
            );

		$this->db->insert('now_playing', $data);

	}

	function getNowPlayingData($limit = '', $offset = '', $timeframe = '') {
		$this->db->select('*, UNIX_TIMESTAMP(timestamp) as unix_timestamp');
		$this->db->from('now_playing');

		if ($limit != "") {
			$this->db->limit($limit);
		}

		$this->db->orderby('timestamp', 'DESC');


		$query = $this->db->get();
		return $query;
	}
	

}

?>
