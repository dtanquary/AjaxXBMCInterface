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

		$.ajax({ url: "home/recentlyPlayed", success: function(html) { $('#recently_played').html(html); } });
		$.ajax({ url: "home/currentPlaylist", success: function(html) { $('#current_playlist').html(html); } });
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
		$.ajax({ url: "xbmc/getVideoShares", success: function(html) { alert(html); refreshVideoShares(); } });
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
		getVideoShares();
		getMusicShares();
		setInterval ( "nowPlaying()", 5000 );
		$(document).bind('keypress', ']', function (){ sendCommand('action(88)'); });
		$(document).bind('keypress', '[', function (){ sendCommand('action(89)'); });
		$(document).bind('keypress', 'm', function (){ sendCommand('action(91)'); });
		//$(document).bind('keypress', 'v', function (){ sendCommand('action(18)'); });
	}

</script>

<body onload="bodyInit();">

	<div id="pageBg"></div>

	<div id="header">
		<div id="nowPlaying"></div>
	</div>
	<div id="subHeader">
		 <ul class="lavaLampNoImage" id="2">
			<li class="current"><a href="javascript:;" onClick="nav('home');"><img src="public/img/icons/home.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Home</a></li>
			<li><a href="javascript:;" onClick="nav('video');"><img src="public/img/icons/film.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Video</a></li>
			<li><a href="javascript:;" onClick="nav('music');"><img src="public/img/icons/music-beam.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Music</a></li>
			<li><a href="javascript:;" onClick="nav('pictures');"><img src="public/img/icons/images.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Pictures</a></li>
			<li><a href="javascript:;" onClick="nav('settings');"><img src="public/img/icons/switch.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Settings</a></li>
			<li><a href="javascript:;" onClick="nav('remote');"><img src="public/img/icons/control-power.png" style="vertical-align:middle;border:0;margin-top:-4px;">&nbsp;Remote Control</a></li>
		</ul>
	</div>
	<div id="centerColumn">
		<div id="home">
			<div id="current_playlist" style="width:60%;"></div>
			<div id="recently_played" style="width:60%;"></div>
		</div>
		<div id="video" style="display:none;"><div id="tabs-video"></div></div>
		<div id="music" style="display:none;"><div id="tabs-music"></div></div>
		<div id="pictures" style="display:none;"><div id="tabs-pictures"></div></div>
		<div id="settings" style="display:none;">settings</div>
		<div id="remote" style="display:none;">
			<div style="height:200px;padding-top:10px;">
				<div style="height:150px;float:left;margin-right:25px;">
					<div class="big_remote_button" onClick="javascript:sendCommand('action(24)');">On Screen Display</div>
					<div style="height:45px;"></div>
					<div class="big_remote_button" onClick="javascript:sendCommand('action(10106)');">Context Menu</div>
					<div style="height:45px;"></div>
					<div class="big_remote_button" onClick="javascript:sendCommand('action(18)');">Toggle GUI</div>
				</div>
				<div style="height:150px;float:left;margin-right:25px;">
					<div class="remote_button" onClick="javascript:sendCommand('action(9)');">...</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(3)');">
						<img src="public/img/icons/arrow-090.png">
					</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(88)');">Vol Up</div>

					<div style="height:45px;"></div>

					<div class="remote_button" onClick="javascript:sendCommand('action(1)');">
						<img src="public/img/icons/arrow-180.png">
					</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(7)');">OK</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(2)');">
						<img src="public/img/icons/arrow.png">
					</div>

					<div style="height:45px;"></div>

					<div class="remote_button" onClick="javascript:sendCommand('action(10)');">Back</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(4)');">
						<img src="public/img/icons/arrow-270.png">
					</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(89)');">Vol Down</div>

					<div style="height:45px;"></div>

					<div class="remote_button" onClick="javascript:sendCommand('action(24)');">OSD</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(10106)');">
						CM
					</div>
					<div class="remote_button" onClick="javascript:sendCommand('action(18)');">GUI</div>

				</div>
			</div>
		</div>



<div id="footer">
	<div id="footer_block" style="margin-right:4%;">
		About XBMC App
		<span style="font-size:9px;">
		<?php echo $this->config->item('version'); ?>
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
		Credits

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
