<br><br><br><br>
<b>Recently Played</b>
<br>
<table style="width:100%;">
<?php
	foreach ($query->result() as $item) {
			$x = 1;
			$array = explode('|', $item->blob);
			while ($x < count($array)) {
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
				$recentlyPlayedData[$key] = $value;
				$x++;
			}

		?>

		<tr>
			<td style="text-align:right;padding-right:6px;">
				<?php 
					$getNowPlayingSession = $this->session->userdata('NowPlayingTitle');
					if ($recentlyPlayedData['Filename'] == $this->session->userdata('Filename')) { ?>
						Playing for <?php echo distanceOfTimeInWords(now(), $item->unix_timestamp); ?>
				<?php } else { ?>
						<?php echo distanceOfTimeInWords(now(), $item->unix_timestamp); ?> ago
				<?php } ?>
			</td>
			<td></td>
		</tr>

		<tr valign="top">
			<td style="background-color:#222;-moz-border-radius:4px;background-image: url('public/img/header_bg.png');background-repeat:no-repeat;padding:6px;border-top:232323;border-left:232323;">
				<div style="font-size:12px;margin-bottom:15px;">
					<?php if ($recentlyPlayedData['Type'] == "Video") { ?>
						<img src="public/img/icons/film.png" style="vertical-align:middle;margin-top:-2px;">
					<?php } else if ($recentlyPlayedData['Type'] == "Audio") { ?>
						<img src="public/img/icons/music.png" style="vertical-align:middle;margin-top:-2px;">
					<?php } else { ?>
						<img src="public/img/icons/images.png" style="vertical-align:middle;margin-top:-2px;">
					<?php } ?>
					<?php if ((isset($recentlyPlayedData['Title'])) && ($recentlyPlayedData['Type'] != "Picture")) { ?>
						<span style="color:lightblue;"><?php echo $recentlyPlayedData['Title']; ?></span>
					<?php } ?>

					<?php if (isset($recentlyPlayedData['Artist'])) { ?>
						<?php $guessNowPlaying = $recentlyPlayedData['Artist'] . " - " . $recentlyPlayedData['Title']; ?>
						<?php echo $recentlyPlayedData['Artist']; ?>
						<br>
						<?php if (isset($recentlyPlayedData['Lyrics'])) { ?>
							<div style="font-size:9px;margin-bottom:2px;">
								<?php echo $recentlyPlayedData['Lyrics']; ?>
							</div>
						<?php } ?>
						<?php if (isset($recentlyPlayedData['Album'])) { ?>
							<span style="font-size:9px;">album</span>
							<span style="font-size:9px;">
								<?php $search = str_replace(" ","+", $recentlyPlayedData['Artist']); ?>
								<?php $search = $search . "+" . str_replace(" ","+", $recentlyPlayedData['Album']); ?>
								<a href="http://www.amazon.com/s/ref=nb_ss_gw?url=search-alias%3Daps&field-keywords=<?php echo $search; ?>&x=0&y=0" target="_blank" style="font-size:9px;">
									<?php echo $recentlyPlayedData['Album']; ?>
								</a>
							</span>
						<?php } ?>
						<?php if (isset($recentlyPlayedData['Genre'])) { ?>
							<br>
							<span style="font-size:9px;">genre</span>
							<span style="font-size:9px;color:#939393;">
								<?php echo $recentlyPlayedData['Genre']; ?>
							</span>
						<?php } ?>
						<?php if (isset($recentlyPlayedData['Bitrate'])) { ?>
							<br>
							<span style="font-size:9px;">bitrate</span>
							<span style="font-size:9px;color:#939393;">
								<?php echo $recentlyPlayedData['Bitrate']; ?> kbit/s
							</span>
						<?php } ?>
						<?php if (isset($recentlyPlayedData['Samplerate'])) { ?>
							<br>
							<span style="font-size:9px;">samplerate</span>
							<span style="font-size:9px;color:#939393;">
								<?php echo $recentlyPlayedData['Samplerate']; ?> kHz
							</span>
						<?php } ?>
					<?php } else { ?>
						<?php if (isset($recentlyPlayedData['Title'])) { ?>
							<?php $guessNowPlaying = $recentlyPlayedData['Title']; ?>
						<?php }  ?>

						<?php if ($recentlyPlayedData['Type'] == "Video") { ?>
							<?php if (isset($recentlyPlayedData['Show Title'])) { ?>
								<?php $guessNowPlaying = $recentlyPlayedData['Show Title'] . " - " . $recentlyPlayedData['Title']; ?>
								<?php echo $recentlyPlayedData['Show Title']; ?>
								<span style="font-weight:bold;font-size:9px;">
									season <?php echo $recentlyPlayedData['Season']; ?>
								</span>
							<?php } ?>
							<br>
							<?php
							if (isset($recentlyPlayedData['Rating'])) {
								$x = 0;
								while($x < 10) {
									if ($x < substr($recentlyPlayedData['Rating'], 0, 1)) {
										echo "<img src='public/img/icons/star-small.png'>";
									} else {
										echo "<img src='public/img/icons/star-small-empty.png'>";
									}
									$x++;
								}
								echo "<br>";
							}
							?>
							<?php if (isset($recentlyPlayedData['Plot'])) { ?>
								<div style="font-size:9px;margin-bottom:2px;">
									<?php echo $recentlyPlayedData['Plot']; ?>
								</div>
							<?php } ?>
							<?php if (isset($recentlyPlayedData['Genre'])) { ?>
								<span style="font-size:9px;">genre</span>
								<span style="font-size:9px;color:#939393;">
									<?php echo $recentlyPlayedData['Genre']; ?>
								</span>
							<?php } ?>
							<?php if (isset($recentlyPlayedData['Duration'])) { ?>
								<span style="font-size:9px;">runtime</span>
								<span style="font-size:9px;color:#939393;">
									<?php echo $recentlyPlayedData['Duration']; ?>
								</span>
							<?php } ?>
							<?php if (isset($recentlyPlayedData['First Aired'])) { ?>
								<br>
								<span style="font-size:9px;">first aired</span>
								<span style="font-size:9px;color:#939393;">
									<?php echo $recentlyPlayedData['First Aired']; ?>
								</span>
							<?php } ?>
							<?php if (isset($recentlyPlayedData['Director'])) { ?>
								<br>
								<span style="font-size:9px;">director</span>
								<span style="font-size:9px;color:#939393;">
									<?php $search = str_replace(" ","+", $recentlyPlayedData['Director']); ?>
									<a href="http://www.imdb.com/find?s=all&q=<?php echo $search; ?>&x=9&y=7" target="_blank" style="font-size:9px;">
										<?php echo $recentlyPlayedData['Director']; ?>
									</a>
								</span>
							<?php } ?>
							<?php if (isset($recentlyPlayedData['Writer'])) { ?>
								<br>
								<span style="font-size:9px;">written by</span>
								<span style="font-size:9px;color:#939393;">
									<?php 
										$writers = explode('/', $recentlyPlayedData['Writer']); 
										$t = 0;
										while ($t < count($writers)) {
									?>
										<?php $search = str_replace(" ","+", $writers[$t]); ?>
										<a href="http://www.imdb.com/find?s=all&q=<?php echo $search; ?>&x=9&y=7" target="_blank" style="font-size:9px;">
											<?php echo $writers[$t]; ?>
										</a>
										<?php if ((count($writers) > 1) && ($t != (count($writers) - 1))) { echo "&nbsp;/"; } ?>
									<?php $t++; } ?>
								</span>
							<?php } ?>
						<?php } else { ?>
							<?php if ($recentlyPlayedData['Type'] == "Picture") { ?>
							<?php $guessNowPlaying = "Slideshow"; ?>
								Slideshow
							<?php } else { ?>
								<?php echo $recentlyPlayedData['Title']; ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			</td>
			<td style="padding-left:5px;">
				<img src="<?php echo $item->thumb; ?>" style="max-width:140px;">
				<br>
				<?php if ($guessNowPlaying != "Slideshow") { ?>
					<div class="tiny_remote_button" onClick="javascript:alert('not working yet \;\)');">
						<img src="public/img/icons/control.png">
					</div>
					<?php if ($recentlyPlayedData['Type'] == "Video") { ?>
						<div class="tiny_remote_button" onClick="javascript:alert('not working yet \;\)');">
							<img src="public/img/icons/film--plus.png">
						</div>
					<?php } ?>
					<?php if ($recentlyPlayedData['Type'] == "Audio") { ?>
						<div class="tiny_remote_button" onClick="javascript:alert('not working yet \;\)');">
							<img src="public/img/icons/music--plus.png">
						</div>
					<?php } ?>
				<?php } ?>
			</td>
		</tr>
		<tr><td colspan="2" style="height:20px;"></td></tr>
<?php } ?>
</table>
