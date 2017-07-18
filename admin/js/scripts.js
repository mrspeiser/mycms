

// tinymce.init({ selector:'textarea'});

$(document).ready(function(){
	$('#selectAllBoxes').click(function(event){
		if(this.checked) {
			$('.checkBoxes').each(function(){
				this.checked = true;
			});
		} else {
			$('.checkBoxes').each(function(){
				this.checked = false;
			});
		}
	});



	var div_box = "<div id='load-screen'><div id='loading'></div></div>";
	$("body").prepend(div_box);
	$('#load-screen').delay(700).fadeOut(200, function(){
		$(this).remove();
	});

});

function loadUsersOnline() {
	$.get("functions.php?usersonline=result", function(data){
		$(".usersonline").text(data);
	});
}

setInterval(function(){
	loadUsersOnline();
},500);


$(document).ready(function(){
  $('.add_recipient').click(function(){
  	$('.recipient_show').text($(this).attr('value'));
  	$('.recipient_input').val($(this).attr('value'));
    // alert($(this).attr('value'));
  });
});
  
 
$( document ).ready(function() {
    $('#myModal').on('hidden.bs.modal', function () {
          $(this).removeData('bs.modal');
    });
});