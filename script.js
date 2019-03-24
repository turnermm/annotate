 jQuery( document ).ready(function() {    
  var last_anno_open; 
   jQuery("span.anno") .mouseover(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,1200);
    });
    
  jQuery("span.anno") .click(function() {       
      var title = jQuery( this ).attr('title');     
      open_anno(title,1);
    });
    
    function open_anno(title,tm) {
       setTimeout(function() {
            if(last_anno_open)     {
              jQuery(last_anno_open) .css('display','none');
           }
           last_anno_open = "span." + title;
           jQuery("p." + title).css('display','inline-block');           
           }, tm);         
    }

      jQuery("span#anno_close") .each(function() {       
         var clss = jQuery(this).parent().attr('class');
         if(typeof clss != 'undefined') {
             if(clss.match(/_r/) ) {
                 jQuery(this).css('border-radius','10px');
             }
         }
    });
    
/*anno-dclk-over */
/*span[class*='anno-dclk-over']*/
   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").mouseover(function() {     
	 jQuery(this).css('display','inline-block');
   });	
   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").mouseout(function() {     
     jQuery(this).css('display','none');
   });	


   jQuery("span[class*='annotation'],p[class*='annotation'], .anno-dclk-over").dblclick(function() {     
	 jQuery(this).css('display','none');
   });	
   
   jQuery("span.anno_exit").click(function() {     
	 jQuery(this).parent().parent().css('display','none');
    });	
});
    
 	


