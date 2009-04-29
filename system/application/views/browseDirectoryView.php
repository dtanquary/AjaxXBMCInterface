

<?php if ($size <= 1) { ?>
	No Files
<?php } else { ?>
	<?php
		$x = 1;
		$c = 0;
		while ($x < $size) {
			$item_row = $array[$x];
			$items = explode(';', $item_row);
			$value = trim($items[0]);
			$shareTitle[$c] = basename($value);
			$shareLocation[$c] = $value;
			$upPath = dirname($value);
			$pattern = basename($upPath);
			$upPath = str_replace($pattern, "", $upPath);
			$filename[$c] = $value;
			$x++;
			$c++;
		}
	?>

	<a href="javascript:getVideoShares();">All Video Shares</a>
	&nbsp;|&nbsp;
	<a href="javascript:GetDirectory('<?php echo $upPath; ?>');">Up a Level</a>
	<br><br>

	<?php
		$t = 0;
		while ($t < $c) {
				echo "<div style='font-size:18px;'>";
				$linkLocation = $shareLocation[$t];
				$linkLocation = str_replace(" ", "%20", $linkLocation);
					echo "<a href='javascript:GetDirectory(\"".$linkLocation."\");'>";
						echo $shareTitle[$t];
					echo "</a>";
				echo "</div>";
				echo $shareLocation[$t];
				echo "<br>";
				echo "<a href=\"javascript:sendCommand('playfile($filename[$t])');\">Play File</a>";
			echo "<br><br>";
			$t++;
		}
	?>

<?php
	print_r($array);
?>
<?php } ?>
