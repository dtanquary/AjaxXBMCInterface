function nav(target) {
	$('#home').hide();
	$('#video').hide();
	$('#music').hide();
	$('#pictures').hide();
	$('#settings').hide();
	$('#remote').hide();
	var getDiv = document.getElementById(target);
	getDiv.style.display = "";
}
