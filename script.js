    jQuery( document ).ready(function() {            
   jQuery("span.anno") .mouseover(function() {
       var title = jQuery( this ).attr('title');     
       jQuery("span." + title).css('display','inline-block');           
    });
	
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    
 	


