<?php if ($size <= 1) { ?>
	No Shares
<?php } else { ?>
	<?php
		$x = 1;
		$c = 0;
		while ($x < $size) {
			$item_row = $array[$x];
			$items = explode(';', $item_row);
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
			$shareTitle[$c] = $key;
			$shareLocation[$c] = $value;
			$x++;
			$c++;
		}
	?>

	<?php
		$t = 0;
		while ($t < $c) {
				echo "<div style='font-size:18px;'>";
				$linkLocation = $shareLocation[$t];
				//$linkLocation = str_replace("/", "ccc", $linkLocation);
					echo "<a href='javascript:GetMusicDirectory(\"".$linkLocation."\");'>";
						echo $shareTitle[$t];
					echo "</a>";
				echo "</div>";
				echo $shareLocation[$t];
			echo "<br><br>";
			$t++;
		}
	?>

	<?php
		//print_r($array);
	?>
<?php } ?>
