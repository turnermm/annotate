<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
   *
   * class       plugin_ckgedit_specials
   * @author     Myron Turner <turnermm02@shaw.ca>
*/
        
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'syntax.php');
define("BULLET_PNG", DOKU_REL ."lib/plugins/annotate/bullet.png");
//msg(BULLET_PNG);
class syntax_plugin_annotate_anno extends DokuWiki_Syntax_Plugin {

    var $test_str;
    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
   
    /**
     * What about paragraphs?
     */

    function getPType(){      
       //return 'block';
    }

    /**
     * Where to sort in?
     */ 
    function getSort(){
        return 155;
    }
    public function  __construct() {
      $this->test_str = '';
    }

    /**
     * Connect pattern to lexer
     */
     public function connectTo($mode) {
		 $this->Lexer->addEntryPattern(
		 '<@anno:\d\d?>(?=.*?</@anno>)',$mode,
		 'plugin_annotate_anno');
		 
		 $this->Lexer->addSpecialPattern(
		 '<anno:\d\d?>.*?</anno>',$mode,'plugin_annotate_anno');	
      
	 }
     

 public function postConnect() { 
       $this->Lexer->addExitPattern('</@anno>','plugin_annotate_anno'); 
 }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){

        switch($state) {    
          case DOKU_LEXER_ENTER :
		   $match = str_replace(':','_',substr($match,2,-1));	
			   return array($state, $match);
          case DOKU_LEXER_UNMATCHED :  
              if(preg_match("/<top>([\w\:]+)\<\/top\>/m",$match,$matches)) {
                   $id = $matches[1];
                   $text = io_readWikiPage(wikiFN($id, $rev), $id, false);
                   if($text) {
                      $match = preg_replace("/<top>.*?<\/top>/ms", "\n$text",$match);
                  }                  
              }    
              if(preg_match("/<bottom>([\w\:]+)\<\/bottom\>/m",$match,$matches)) {
                   $id = $matches[1];
                   $text = io_readWikiPage(wikiFN($id, $rev), $id, false);
                   if($text) {
                      $match = preg_replace("/<bottom>.*?<\/bottom>/ms", "\\\\\\ $text",$match);
                  }                  
              }    
              
            //  msg(htmlentities($match));		  
              return array($state, $match);
          case DOKU_LEXER_EXIT :   return array($state, '');                
          case DOKU_LEXER_SPECIAL: 			  
		      $inner = substr($match,6,-7);
			  return array($state, $inner); 
       }
         return array($state, "" );
       
    }

   /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
		
        if($mode == 'xhtml'){
            list($state, $xhtml) = $data;
            switch ($state) {
                case DOKU_LEXER_ENTER : 
				    $tip = '<span class="annotation ui-widget-content '. $xhtml . '">';
				    $renderer->doc .= $tip;
				break;                                                        
                case DOKU_LEXER_UNMATCHED : 
                $renderer->doc .= '<span id="anno_close"><span class="anno_exit">close</span> </span>';
       		    $xhtml = trim($xhtml);				
                if(preg_match('/^\{\{([\w\:]+)\}\}$/',$xhtml,$matches)) {					
				  	   $html = p_wiki_xhtml($matches[1]); 
			        }
			       else {
                      $secedit = false;                  
				      $html = html_secedit(p_render('xhtml',p_get_instructions($xhtml),$info),$secedit);				 //$info is reference, $secedit is handled by html_secedit
 				} 
				$html = $this->html_filter($html);				
                $renderer->doc .= $html;  break;
                case DOKU_LEXER_EXIT : 
				    $renderer->doc .= "</span>"; break; 
				case DOKU_LEXER_SPECIAL:				
					list($which,$text)= explode('>',$xhtml); 
                    $title = 'anno_' .$which;
				    $renderer->doc .= '<span class="anno" title="' .$title.'">' .htmlentities($text).'</span>'; break;	
				
        }
           return true;
        }
        return false;
    }
	
	function html_filter($html){
       $html = str_replace(array('[List]','[tsiL]'),"",$html);   
	   $html = preg_replace('/<\/?p>/ms',"",$html);
	   $html = preg_replace_callback('/<(\/)?h(\d).*?>/ms',
		function($matches){
			if($matches[1] == '/'){
				$style = '</b>';	
				if($matches[2] <= 3){
					$style .= '<br />';
				}						
			}
			else {
				if($matches[2] <= 3){
				  $style = '<br /><b class="extra_bold">';
				}
				else $style = '<br /><b>';
			}
			return $style;
		}, $html);
		
		$html = preg_replace_callback(
        '/<table[^>]+>(.*?)<\/table>/ms',
        function($matches) {
            $replace = array('td','th','</tr>');
            $replacements = array('span','span_h','<br/>');
            $matches[1] = str_replace($replace, $replacements,$matches[1]);
            $matches[1] = preg_replace("/\<tr\s+class=\"row\d\">/","",$matches[1]);
            $matches[1] = preg_replace(array("/\<tr\s+class=\"row\d\">/","/col\d+/"),array("",'anno_col'),$matches[1]);           
            $matches[1] = preg_replace('/\"anno_col\"\s+colspan=\"(\d)\"/',"anno_colspan_$1",$matches[1]);  
            $matches[1] = preg_replace("/span_h\s+class=\"/","span class=\"theader ",$matches[1]); 
            $matches[1] = str_replace('/span_h','/span',$matches[1]);       
            return'<br>' . $matches[1] .'<br />';
        },$html);
 
        $html = preg_replace_callback(
         '/\<(o|u)l\>([\s\S]+)\<\/(o|u)l\>/ms',
        function($matches) {
            $matches[0] = preg_replace("/\<li\s+class=\"level(\d).*?\"\>/","<span class='anno_li_$1'>&nbsp; </span>", $matches[0]);
            $matches[0] = preg_replace('/\<div\s+class.*?li\">/',"",$matches[0]);
            $matches[0] = str_replace('</div>','<br>',$matches[0]);
            return  $matches[0] ."\nEOL";
        },$html);
        //$html = preg_replace("/\<\/?(ul|ol|li)\>/","", $html);
      
       $html = preg_replace("/\<\/(ul|ol|li)\>/","", $html);

        $html = preg_replace_callback(
          '/(\<ol>|\<ul\>)(.*?)EOL/ms',
            function($matches) {
             $type = "";              
    /*
ol             { list-style: decimal outside; }
ol ol          { list-style-type: lower-alpha; }
ol ol ol       { list-style-type: upper-roman; }
ol ol ol ol    { list-style-type: upper-alpha; }
ol ol ol ol ol { list-style-type: lower-roman; }
*/    
     $anno_li_1 = 0;
     $anno_li_3 = 'abcdefghijklmnopqrstuvwxyz';
     $anno_li_2 = $anno_li_8=$anno_li_7=$anno_li_6 = array('i','ii','iii','iv','v','vi','vii','viii','ix','x','xi','xii','xiii','xiv','xv','xvi','xvii','xviii','xix','xx','xxi','xxii','xxiii','xxiv','xxv','xxvi');
     $anno_li_4 = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII','XIV','XV','XVI','XVII','XVIII','XIX','XX','XXI','XXII','XXIII','XXIV','XXV','XXVI');
     $anno_li_5 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');     
     $current = array('anno_li_0' => 0,'anno_li_1' => 0,'anno_li_2' => 0,'anno_li_3'=>0,'anno_li_4'=>0,'anno_li_5'=>0,'anno_li_6'=>0,
         'anno_li_7'=>0,'anno_li_8'=>0);

     $_list =  explode("\n", $matches[2]);
     $retv = "<br />";

     for($i=0; $i<count($_list); $i++) {
         $_list[$i] = trim($_list[$i]);

         if(!empty($_list[$i])) {
             if(preg_match("/\<ol>/",$_list[$i])) {
                 $type = 'o';
                 continue;
             }
             else if(preg_match("/\<ul\>/",$_list[$i])) {
                 $type = 'u';
                 continue;
             }

             if($type == 'u') {
                 $_list[$i] = str_replace("</span>", "<img src=\"" . BULLET_PNG ."\"></span>",$_list[$i] );
             }
             else {
                if(preg_match("/(anno_li_(\d))/",$_list[$i],$match)) {
                    if($match[1] == 'anno_li_1') {
                        $anno_li_1++;
                        $_list[$i] = str_replace('&nbsp;',$anno_li_1,$_list[$i]);  // Insert current number                      
                    }
                    else {
                        $b = $match[1]; // anno_li_<n>
                        $a = ${$b};  //   $anno_li_<n>
                        $marker = $a[$current[$match[1]]];
                        $_list[$i] = str_replace('&nbsp;',$marker,$_list[$i]);
                        $current[$match[1]]++;       // $current[ 'anno_li_<n>']         
                    }
                }
             }
             $retv .= $_list[$i] ."\n";
         }
     }
        return $retv;
    },$html);


		$html = preg_replace('/<\/?div.*?>/ms',"",$html);
		$html = preg_replace('/<!--.*?-->/ms',"",$html);	
     
		return $html;
	}
    
}


