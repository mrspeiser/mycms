	function openGal() {
    document.getElementById("dropdowngallery").style.height = "100%";
}

	function closeGal() {
    document.getElementById("dropdowngallery").style.height = "0%";
}


$(document).ready(function() {
	$('.replysection').click(function(){
		$('.reply_text', this).show();
	});
});



$('.post_image').click(function(e){
	openGal();
});