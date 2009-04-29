<?php if ($size <= 2) { ?>
	Nothing Playing
	<?php $this->session->set_userdata('NowPlayingTitle', "Nothing Playing"); ?>
<?php } else { ?>

<?php

	$x = 1;
	while ($x < $size) {
		$item_row = $array[$x];
		$items = explode(':', $item_row);
		$key = trim($items[0]);
		if (($key == "Time") || ($key == "Duration")) {
			$value  = trim($items[1]);
			$value .= ":";
			$value .= trim($items[2]);
			if (isset($items[3])) {
				$value .= ":";
				$value .= trim($items[3]);
			}
		} else {
			$value = trim($items[1]);
		}
		$nowPlayingData[$key] = $value;
		$x++;
	}


?>
<?php
$new_code = $this->session->userdata('new_code');
$new_image = $xbmc_url . "thumb" . $new_code . ".jpg";
if (@fclose(@fopen($new_image, "r"))) {
	$this->session->set_userdata('thumb_code', $new_code);
}
?>
<div style="font-family:'Trebuchet MS';font-size:18px;margin-bottom:15px;">
	Now Playing
	<?php if ($nowPlayingData['Type'] == "Video") { ?>
		<img src="public/img/icons/film.png">
	<?php } else if ($nowPlayingData['Type'] == "Audio") { ?>
		<img src="public/img/icons/music.png">
	<?php } else { ?>
		<img src="public/img/icons/images.png">
	<?php } ?>
</div>
<?php if(isset($nowPlayingData['PlayStatus'])) { ?>
	<?php echo $nowPlayingData['PlayStatus']; ?>
	&nbsp;
	<?php if ($nowPlayingData['PlayStatus'] == "Paused") { ?><blink><?php } ?>
	<?php echo $nowPlayingData['Time']; ?>
	<?php if ($nowPlayingData['PlayStatus'] == "Paused") { ?></blink><?php } ?>
	&nbsp;/&nbsp;<?php echo $nowPlayingData['Duration']; ?>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $nowPlayingData['Percentage'];?>% 
	<div id="progress">
		<div id="progress_fill" style="width:<?php echo $nowPlayingData['Percentage']; ?>%;"></div>
	</div>
	<a href="javascript:sendCommand('action(23)');nowPlaying();"><img src="public/img/icons/control-skip-180.png" style="border:0;"></a>
	<a href="javascript:sendCommand('action(21)');nowPlaying();"><img src="public/img/icons/control-double-180.png" style="border:0;"></a>

	<?php if ($nowPlayingData['PlayStatus'] == "Playing") { ?>
		<a href="javascript:sendCommand('action(12)');nowPlaying();"><img src="public/img/icons/control-pause.png" style="border:0;"></a>
	<?php } else { ?>
		<a href="javascript:sendCommand('action(12)');nowPlaying();"><img src="public/img/icons/control.png" style="border:0;"></a>
	<?php } ?>
	<a href="javascript:sendCommand('action(13)');nowPlaying();"><img src="public/img/icons/control-stop-square.png" style="border:0;"></a>

	<a href="javascript:sendCommand('action(20)');nowPlaying();"><img src="public/img/icons/control-double.png" style="border:0;"></a>
	<a href="javascript:sendCommand('action(22)');nowPlaying();"><img src="public/img/icons/control-skip.png" style="border:0;"></a>

	<br><br>
<?php } ?>
<?php if (isset($nowPlayingData['Artist'])) { ?>
	<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Artist'] . " - " . $nowPlayingData['Title']); ?>
	<?php echo $nowPlayingData['Artist']; ?>
	<br>
	<?php echo $nowPlayingData['Album']; ?>
	<br>
	<?php echo $nowPlayingData['Title']; ?>
<?php } else { ?>
	<?php if (isset($nowPlayingData['Title'])) { ?>
		<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Title']); ?>
	<?php }  ?>

	<?php if (isset($nowPlayingData['Show Title'])) { ?>
		<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Show Title'] . " - " . $nowPlayingData['Title']); ?>
		<?php echo $nowPlayingData['Show Title']; ?>
		<br>
		Season <?php echo $nowPlayingData['Season']; ?>
		<br>
		<?php echo $nowPlayingData['Title']; ?>
	<?php } else { ?>
		<?php if ($nowPlayingData['Type'] == "Picture") { ?>
		<?php $this->session->set_userdata('NowPlayingTitle', 'Slideshow'); ?>
			Slideshow
		<?php } else { ?>
			<?php echo $nowPlayingData['Title']; ?>
	<?php } ?>
	<?php } ?>
<?php } ?>
<br>
<?php
	if (isset($nowPlayingData['Rating'])) {
		$x = 0;
		while($x < 10) {
			if ($x < substr($nowPlayingData['Rating'], 0, 1)) {
				echo "<img src='public/img/icons/star-small.png'>";
			} else {
				echo "<img src='public/img/icons/star-small-empty.png'>";
			}
			$x++;
		}
		echo "<br>";
	}
?>
<br>
<?php
	$current_image = $xbmc_url . "thumb" . $this->session->userdata('thumb_code') . ".jpg";
	if (@fclose(@fopen($current_image, "r"))) {
?>
	<img src="<?php echo $current_image; ?>" style="max-width:200px;xmax-height:80px;xborder-top:1px solid #333;xborder-left:1px solid #333;xborder-right:1px solid #dcdcdc;">
	<div style="margin-top:-3px;"><img src="public/img/img_shadow.png"></div>
<?php } ?>
<?php if (isset($nowPlayingData['Plot'])) { ?>
	<div style="font-family:'Trebuchet MS';font-size:14px;">
		<?php if (isset($nowPlayingData['Show Title'])) { ?>
			Episode Plot
		<?php } else { ?>
			Movie Plot
		<?php } ?>
	</div>
	<?php echo $nowPlayingData['Plot']; ?>
	<br><br>
<?php } ?>
<?php
	//print_r($array);
?>
<?php } ?>
