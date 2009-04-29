<?php echo $header; ?>

<script type="text/javascript">

        $(function() {
            $("#2").lavaLamp({
                fx: "backout",
				autoReturn: "False",
                speed: 700,
                click: function(event, menuItem) {
                    return false;
                }
            });
        });
    </script>

<script>

	function sendCommand(command) {
		//var url = xbmc_url + "xbmcCmds/xbmcHttp?command=" + command;
		var command = command.replace("(", "aaa");
		var command = command.replace(")", "bbb");

		var url = "xbmc/sendCommand/" + command;
		$.getJSON(url,
        function(data){
			//alert(data);
        });
	}

	function playFile(path) {
		$.ajax({
			url: "xbmc/playFile/",
			type: "POST",
			data: "path=" + path,
			success: function() { 
				//do nothing
			}
		});
	}

	function GetDirectory(path) {
		var loading = "Loading Directory";
		$("#tabs-video").html(loading);
		$("#tabs-music").html(loading);

		$.ajax({
			url: "xbmc/getDirectory/",
			type: "POST",
			data: "path=" + path,
			success: function() { 
				refreshDirectoryView();
			}
		});
		setTimeout ( "refreshDirectoryView()", 500 );
	}

	function GetVideoDirectory(path) {
		var loading = "Loading Directory";
		$("#tabs-video").html(loading);

		$.ajax({
			url: "xbmc/getDirectory/",
			type: "POST",
			data: "path=" + path,
			success: function() { 
				refreshVideoDirectoryView();
			}
		});
		setTimeout ( "refreshVideoDirectoryView()", 500 );
	}

	function GetMusicDirectory(path) {
		var loading = "Loading Directory";
		$("#tabs-music").html(loading);

		$.ajax({
			url: "xbmc/getDirectory/",
			type: "POST",
			data: "path=" + path,
			success: function() { 
				refreshMusicDirectoryView();
			}
		});
		setTimeout ( "refreshMusicDirectoryView()", 500 );
	}

	function refreshVideoDirectoryView() {
		$.ajax({ url: "home/getVideoDirectory", success: function(html) {  
			$("#tabs-video").html(html);
		} });
	}

	function refreshMusicDirectoryView() {
		$.ajax({ url: "home/getMusicDirectory", success: function(html) {  
			$("#tabs-music").html(html);
		} });
	}

	function nowPlaying() {
		$.ajax({ url: "xbmc/getNowPlaying", success: function() { refreshNowPlaying(); } });
		setTimeout ( "refreshNowPlaying()", 500 );
	}

	function refreshNowPlaying() {
		$.ajax({ url: "home/nowPlaying", success: function(html) { $("#nowPlaying").html(html); ajaxTitle(); } });
	}

	function ajaxTitle() {
		$.ajax({ url: "home/ajaxTitle", success: function(html) { document.title = html; } });
	}

	function getVideoShares() {
		var loading = "Loading Video Shares";
		$("#tabs-video").html(loading);
		$.ajax({ url: "xbmc/getVideoShares", success: function(html) { refreshVideoShares(); } });
		setTimeout ( "refreshVideoShares()", 500 );
	}

	function refreshVideoShares() {
		$.ajax({ url: "home/getVideoShares", success: function(html) { $("#tabs-video").html(html); } });
	}

	function getMusicShares() {
		var loading = "Loading Music Shares";
		$("#tabs-music").html(loading);
		$.ajax({ url: "xbmc/getMusicShares", success: function(html) { refreshVideoShares(); } });
		setTimeout ( "refreshMusicShares()", 500 );
	}

	function refreshMusicShares() {
		$.ajax({ url: "home/getMusicShares", success: function(html) { $("#tabs-music").html(html); } });
	}

	function bodyInit() {
		nowPlaying();
		setInterval ( "nowPlaying()", 5000 );
		$("#tabs").tabs();
		$(document).bind('keypress', ']', function (){ sendCommand('action(88)'); });
		$(document).bind('keypress', '[', function (){ sendCommand('action(89)'); });
		$(document).bind('keypress', 'm', function (){ sendCommand('action(91)'); });
		//$(document).bind('keypress', 'v', function (){ sendCommand('action(18)'); });
	}

</script>

<body onload="bodyInit();">

	<div id="pageBg"></div>

	<div id="header">
			 <!--<ul class="lavaLampNoImage" id="2">
				<li class="current"><a href="#">Home</a></li>
				<li><a href="#">Plant a tree</a></li>
				<li><a href="#">Travel</a></li>

				<li><a href="#">Ride an elephant</a></li>
			</ul>-->

	</div>
	<div id="leftColumn">
		<div id="nowPlaying"></div>
		<b>volume</b>
		<a href="javascript:sendCommand('action(88)');">Up</a>&nbsp;/
		<a href="javascript:sendCommand('action(89)');">Down</a>&nbsp/
		<a href="javascript:sendCommand('action(91)');">Mute</a>
	</div>
	<div id="centerColumn">

<div id="tabs" style="background: rgba(255, 255, 255, 0.4);">
	<ul>
		<li><a href="#tabs-1"><img src="public/img/icons/arrow-move.png" style="border:0;vertical-align:middle;">&nbsp;Gui Controls</a></li>
		<li><a href="#tabs-video" onClick="if ($('#tabs-video').css('display') == 'none') { getVideoShares(); }"><img src="public/img/icons/film.png" style="border:0;vertical-align:middle;">&nbsp;Video</a></li>
		<li><a href="#tabs-music" onClick="if ($('#tabs-music').css('display') == 'none') { getMusicShares(); }"><img src="public/img/icons/music.png" style="border:0;vertical-align:middle;">&nbsp;Music</a></li>
		<li><a href="#tabs-1"><img src="public/img/icons/images.png" style="border:0;vertical-align:middle;">&nbsp;&nbsp;Pictures</a></li>
		<li><a href="#tabs-1"><img src="public/img/icons/equalizer.png" style="border:0;vertical-align:middle;">&nbsp;&nbsp;Settings</a></li>
	</ul>
	<div id="tabs-1">

		<h3>GUI Control</h3>



		<a href="javascript:sendCommand('action(3)');">Up</a>&nbsp;/
		<a href="javascript:sendCommand('action(4)');">Down</a>
		<br>
		<a href="javascript:sendCommand('action(1)');">Left</a>&nbsp;/
		<a href="javascript:sendCommand('action(2)');">Right</a>
		<br>
		<a href="javascript:sendCommand('action(7)');">Select Item</a>
		<br>
		<a href="javascript:sendCommand('action(9)');">Up a level</a>
		<br>



		<br><br>
		<a href="javascript:sendCommand('action(18)');">Toggle Visualization</a>

		<br>
		<h3>Video Playback</h3>
		<a href="javascript:sendCommand('action(23)');nowPlaying();">Big Step Back</a>&nbsp;/
		<a href="javascript:sendCommand('action(21)');nowPlaying();">Step Back</a>&nbsp;/
		<a href="javascript:sendCommand('action(20)');nowPlaying();">Step Forward</a>&nbsp;/
		<a href="javascript:sendCommand('action(22)');nowPlaying();">Big Step Forward</a>






	</div>
	<div id="tabs-video"></div>
	<div id="tabs-music"></div>
</div>

<div id="footer">
	<div id="footer_block" style="margin-right:4%;">
		About XBMC App
		<br>
		<span style="font-size:9px;">
		Current Version: <?php echo $this->config->item('version'); ?>
		</span>

		<br><br>
		Keyboard shortcuts:
		<br>
		<span style="font-size:9px;">
		<b>[</b> = Volume Down<br>
		<b>]</b> = Volume Up<br>
		<b>m</b> = toggle mute<br>
		</span>
	</div>
	<div id="footer_block" style="margin-right:5%;">
		Special Thanks
		<br>
		<span style="font-size:9px;">
		Credits
		</span>

		<br><br>
		<a href="http://pixelresort.com/icon/" target="_blank">Pixel Resort Icons</a>
		<br>
		<a href="#">item</a>
		<br>
	</div>
	<div id="footer_block">
		Developer's Twitter
		<div id="twitter_div" style="margin-left: -15px;">
			<ul id="twitter_update_list">Loading Tweets...</ul>
			<a href="http://twitter.com/dtanquary" target="_blank" id="twitter-link" style="display:block;text-align:right;">follow
			<img src="public/img/icons/arrow-skip.png" style="vertical-align:middle;border:0;">
			</a>
		</div>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/dtanquary.json?callback=twitterCallback2&amp;count=5"></script>
	</div>
</div>

</div>


</body>
</html>
