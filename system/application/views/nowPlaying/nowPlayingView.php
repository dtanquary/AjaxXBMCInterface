<?php if ($size <= 2) { ?>
	<!--Nothing Playing-->
	<?php $this->session->set_userdata('NowPlayingTitle', "Nothing Playing"); ?>
	<?php $this->session->set_userdata('Filename', ""); ?>
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

	$this->session->set_userdata('Filename', $nowPlayingData['Filename']);

	$new_code = $this->session->userdata('new_code');
	$new_image = $xbmc_url . "thumb" . $new_code . ".jpg";
	if (@fclose(@fopen($new_image, "r"))) {
		$this->session->set_userdata('thumb_code', $new_code);
	}
?>
	<?php
		if ($nowPlayingData['Type'] != "Audio") {
			$current_image = $xbmc_url . "thumb" . $this->session->userdata('thumb_code') . ".jpg";
		?>
		<table style="width:100%;margin:0;padding:0;xbackground-image: url('<?php echo $current_image; ?>');background-repeat:no-repeat;background-position:top right;">
	<?php } else { ?>
		<table style="width:100%;margin:0;padding:0;">
	<?php } ?>
	<tr valign="top">
		<?php if ($nowPlayingData['Type'] == "Picture") { ?>
			<!--<td style="height:124x;width:auto;">-->
			<td style="max-width:200px;height:122px;">
		<?php } else if ($nowPlayingData['Type'] == "Audio") { ?>
			<td style="width:100px;max-width:100px;">
		<?php } else { ?>
			<td style="width:auto;max-width:200px;">
		<?php } ?>
			<?php
				$current_image = $xbmc_url . "thumb" . $this->session->userdata('thumb_code') . ".jpg";
				if (@fclose(@fopen($current_image, "r"))) {
			?>
			<?php if ($nowPlayingData['Type'] == "Audio") { ?>
				<img src="<?php echo $current_image; ?>" style="max-width:90px;margin:0px;padding:0px;">
			<?php } else { ?>
				<img src="<?php echo $current_image; ?>" style="max-width:200px;margin:0px;padding:0px;">
			<?php } ?>
			<?php } ?>
			<?php 
				if ($nowPlayingData['Changed'] !== "False") {
					//write array to database
					$this->now_playing->writeNowPlayingData($current_image);
				}
			?>
		</td>
		<td style="padding-left:5px;text-align:left;">
			<div style="font-size:18px;margin-bottom:15px;">
				<?php if ($nowPlayingData['Type'] == "Video") { ?>
					<img src="public/img/icons/film.png" style="vertical-align:middle;margin-top:-2px;">
				<?php } else if ($nowPlayingData['Type'] == "Audio") { ?>
					<img src="public/img/icons/music.png" style="vertical-align:middle;margin-top:-2px;">
				<?php } else { ?>
					<img src="public/img/icons/images.png" style="vertical-align:middle;margin-top:-2px;">
				<?php } ?>
				<span style="color:#fff;">NOW PLAYING</span>
				<?php if (isset($nowPlayingData['Title'])) { ?>
					<span style="color:lightblue;"><?php echo $nowPlayingData['Title']; ?></span>
				<?php } ?>

				<?php if (isset($nowPlayingData['Artist'])) { ?>
					<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Artist'] . " - " . $nowPlayingData['Title']); ?>
					<?php echo $nowPlayingData['Artist']; ?>
					<br>
					<?php if (isset($nowPlayingData['Lyrics'])) { ?>
						<div style="font-size:9px;margin-bottom:2px;">
							<?php echo $nowPlayingData['Lyrics']; ?>
						</div>
					<?php } ?>
					<?php if (isset($nowPlayingData['Album'])) { ?>
						<span style="font-size:10px;">album</span>
						<span style="font-size:12px;">
							<?php $search = str_replace(" ","+", $nowPlayingData['Artist']); ?>
							<?php $search = $search . "+" . str_replace(" ","+", $nowPlayingData['Album']); ?>
							<a href="http://www.amazon.com/s/ref=nb_ss_gw?url=search-alias%3Daps&field-keywords=<?php echo $search; ?>&x=0&y=0" target="_blank">
								<?php echo $nowPlayingData['Album']; ?>
							</a>
						</span>
					<?php } ?>
					<?php if (isset($nowPlayingData['Genre'])) { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span style="font-size:10px;">genre</span>
						<span style="font-size:12px;color:#939393;">
							<?php echo $nowPlayingData['Genre']; ?>
						</span>
					<?php } ?>
					<?php if (isset($nowPlayingData['Bitrate'])) { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span style="font-size:10px;">bitrate</span>
						<span style="font-size:12px;color:#939393;">
							<?php echo $nowPlayingData['Bitrate']; ?> kbit/s
						</span>
					<?php } ?>
					<?php if (isset($nowPlayingData['Samplerate'])) { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span style="font-size:10px;">samplerate</span>
						<span style="font-size:12px;color:#939393;">
							<?php echo $nowPlayingData['Samplerate']; ?> kHz
						</span>
					<?php } ?>
				<?php } else { ?>
					<?php if (isset($nowPlayingData['Title'])) { ?>
						<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Title']); ?>
					<?php }  ?>

					<?php if ($nowPlayingData['Type'] == "Video") { ?>
						<?php if (isset($nowPlayingData['Show Title'])) { ?>
							<?php $this->session->set_userdata('NowPlayingTitle', $nowPlayingData['Show Title'] . " - " . $nowPlayingData['Title']); ?>
							<?php echo $nowPlayingData['Show Title']; ?>
							<span style="font-weight:bold;font-size:12px;">
								season <?php echo $nowPlayingData['Season']; ?>
							</span>
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
						<?php if (isset($nowPlayingData['Plot'])) { ?>
							<div style="font-size:9px;margin-bottom:2px;">
								<?php echo $nowPlayingData['Plot']; ?>
							</div>
						<?php } ?>
						<?php if (isset($nowPlayingData['Genre'])) { ?>
							<span style="font-size:10px;">genre</span>
							<span style="font-size:12px;color:#939393;">
								<?php echo $nowPlayingData['Genre']; ?>
							</span>
						<?php } ?>
						<?php if (isset($nowPlayingData['First Aired'])) { ?>
							<span style="font-size:10px;">first aired</span>
							<span style="font-size:12px;color:#939393;">
								<?php echo $nowPlayingData['First Aired']; ?>
							</span>
						<?php } ?>
						<?php if (isset($nowPlayingData['Director'])) { ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-size:10px;">director</span>
							<span style="font-size:12px;color:#939393;">
								<?php $search = str_replace(" ","+", $nowPlayingData['Director']); ?>
								<a href="http://www.imdb.com/find?s=all&q=<?php echo $search; ?>&x=9&y=7" target="_blank">
									<?php echo $nowPlayingData['Director']; ?>
								</a>
							</span>
						<?php } ?>
						<?php if (isset($nowPlayingData['Writer'])) { ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-size:10px;">written by</span>
							<span style="font-size:12px;color:#939393;">
								<?php 
									$writers = explode('/', $nowPlayingData['Writer']); 
									$t = 0;
									while ($t < count($writers)) {
								?>
									<?php $search = str_replace(" ","+", $writers[$t]); ?>
									<a href="http://www.imdb.com/find?s=all&q=<?php echo $search; ?>&x=9&y=7" target="_blank">
										<?php echo $writers[$t]; ?>
									</a>
									<?php if ((count($writers) > 1) && ($t != (count($writers) - 1))) { echo "&nbsp;/"; } ?>
								<?php $t++; } ?>
							</span>
						<?php } ?>
					<?php } else { ?>
						<?php if ($nowPlayingData['Type'] == "Picture") { ?>
						<?php $this->session->set_userdata('NowPlayingTitle', 'Slideshow'); ?>
							Slideshow
						<?php } else { ?>
							<?php echo $nowPlayingData['Title']; ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
		</td>
		<td style="width:250px;">
			<?php if(isset($nowPlayingData['PlayStatus'])) { ?>
				<div style="height:10px;"></div>
				<?php //echo $nowPlayingData['PlayStatus']; echo "&nbsp;"; ?>
				<center>
					<span style="font-size:28px;">
						<?php if ($nowPlayingData['PlayStatus'] == "Paused") { ?><blink><?php } ?>
						<?php echo $nowPlayingData['Time']; ?>
						<?php if ($nowPlayingData['PlayStatus'] == "Paused") { ?></blink><?php } ?>
					</span>
					<span style="font-size:9px;">/&nbsp;</span>
					<span style="font-size:18px;">
						<?php echo $nowPlayingData['Duration']; ?>
					</span>
					<br>
				</center>
				<div style="height:5px;"></div>
				<center>
					<div class="tiny_remote_button" onClick="sendCommand('action(23)');nowPlaying();"><img src="public/img/icons/control-skip-180.png"></div>
					<div class="tiny_remote_button" onClick="sendCommand('action(21)');nowPlaying();"><img src="public/img/icons/control-double-180.png" style="border:0;"></div>

					<?php if ($nowPlayingData['PlayStatus'] == "Playing") { ?>
						<div class="tiny_remote_button" onClick="sendCommand('action(12)');nowPlaying();"><img src="public/img/icons/control-pause.png" style="border:0;"></div>
					<?php } else { ?>
						<div class="tiny_remote_button" onClick="sendCommand('action(12)');nowPlaying();"><img src="public/img/icons/control.png" style="border:0;"></div>
					<?php } ?>
					<div class="tiny_remote_button" onClick="sendCommand('action(13)');nowPlaying();"><img src="public/img/icons/control-stop-square.png" style="border:0;"></div>

					<div class="tiny_remote_button" onClick="sendCommand('action(20)');nowPlaying();"><img src="public/img/icons/control-double.png" style="border:0;"></div>
					<div class="tiny_remote_button" onClick="sendCommand('action(22)');nowPlaying();"><img src="public/img/icons/control-skip.png" style="border:0;"></div>
				</center>
			<?php } ?>
		</td>
	</tr>
</table>
<?php if ($nowPlayingData['Type'] != "Picture") { ?>
	<div id="progress">
		<div id="progress_fill" style="width:<?php echo $nowPlayingData['Percentage']; ?>%;">
			<?php $limit = "98"; if ($nowPlayingData['Percentage'] < $limit) { ?>
				<span style="margin-right:-26px;color:#939393;">
			<?php } ?>
				<?php echo $nowPlayingData['Percentage'];?>%
			<?php if ($nowPlayingData['Percentage'] < $limit) { ?>
				</span>
			<?php } else { echo "&nbsp;"; } ?>
		</div>
	</div>
<?php } ?>
<?php
	//print_r($array);
?>
<?php } ?>
