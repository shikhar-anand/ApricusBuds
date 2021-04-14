//GO UP
jQuery(document).ready(function(){ 
			
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 200) {
			jQuery('.goup').fadeIn();
			} else {
			jQuery('.goup').fadeOut();
			}
		}); 
			
		jQuery('.goup').click(function(){
			jQuery("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});

//LOCK THE SEARCH IF THE FIELD IS EMPTY
     jQuery('.searchsubmit').attr('disabled','disabled');
     jQuery('.s').keypress(function(){
            if(jQuery(this).val() != ''){
               jQuery('.searchsubmit').removeAttr('disabled');
            }
     });

});

