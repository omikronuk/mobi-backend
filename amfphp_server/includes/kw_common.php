<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Entities to Quotes 
 *
 * Converts entities tosingle and double quotes 
 *
 * @access	public
 * @param	string
 * @return	string
 */	


if ( ! function_exists('get_status_color'))
{

	function get_status_color($status){
		$result='000000';
		
		switch($status){
               case 'n':
			$result='cRed';
			break;
		case 'y':
			$result='cGreen';
			break;
		case 0:
			$result='cRed';
			break;
		case 1: 
			$result='cBlue';
			break;
		case 2:
			$result='cGreen';
			break;
		case 3:
			$result='cYell';
		case 4:
			$result='cBrown';
        case 5:
			$result='cMaroon';
		}
		return $result;
	}
}
   
   
   /**
 * Entities to Quotes 
 *
 * Converts entities tosingle and double quotes 
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('entities_to_quotes'))
{
	function entities_to_quotes($str)
	{	
		return str_replace(array("&rsquo;","&ndash;","&amp;",'&lsquo;'), array("'","-","&","'"), $str);
	}
}

/* Formats the value
	*
	*/
	function around($amount){
		return sprintf("%6.2f", $amount);
	}
	
	
	function prndate($date, $dateFormat=DateFormat){
		global $data;
		if($date == '0000-00-00 00:00:00' || $date == '0000-00-00' )return '---';
		else return date($dateFormat, strtotime($date));
	}
	
	function prnintg($number){
		return number_format($number, 0, '', '');
	}
	
	function prnsum($sum){
		return (float)str_replace(",", "", $sum);
	}
	
	function prnsumm($summ){
		global $data;
		$summ = str_replace(",", ".", $summ);
		return number_format(($summ > 0? $summ : -$summ ), 2, '.', ',');
	}
	
	
	function balSumm($summ){
		global $data;
		$summ = str_replace(",", ".", $summ);
		return number_format(($summ > 0? $summ : $summ ), 2, '.', ',');
	}
	
	
	
	function prnpays($summ, $splus=false, $curr=''){
		global $data;
		$curr = $curr == '' ? Currency : $curr;
		if($summ<0)$color='red';else $color='green';
		return
			"<font color={$color}>".
			($summ>=0?($splus?'+':''):'-').$curr.prnsumm($summ).
			'</font>'
		;
	}
	
	function prnfees($summ, $curr=''){
		return $summ != 0 ? prnpays($summ, false, $curr):'<font color=maroon>'. KAWIENGINE::prnpays(0,false,$curr).'</font>';
	}
	
	function prntext($text){
		return preg_replace('/\r\n|\r|\n/i', '<br />', htmlentities(stripslashes($text), ENT_QUOTES));
	}
	
	function balance($summ){
		return prnpays($summ, false);
	}     

	
	/* Verify data input accuracy
	*
	*/
	function matchPreg($var, $option='/^[a-z0-9.-_]+$/'){
		if(!preg_match($option, trim($var))){
			return false;
		}else{ return true;}
	}
	


 /*
         * @name time_ago
         * Formats a date to how long is had been created
         * return form output
         */
if ( ! function_exists('time_ago')){
        function time_ago($date, $granularity=2) {
		$date = strtotime($date);
		$difference = time() - $date;
		$periods = array('decade' => 315360000,
			'year' => 31536000,
			'month' => 2628000,
			'week' => 604800, 
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1);
									 
		foreach ($periods as $key => $value) {
			if ($difference >= $value) {
				$time = floor($difference/$value);
				$difference %= $value;
				$retval .= ($retval ? ' ' : '').$time.' ';
				$retval .= (($time > 1) ? $key.'s' : $key);
				$granularity--;
			}
			if ($granularity == '0') { break; }
		}
		return $retval.' ago';      
	}
}

/* this method will seek to replaec the keyword with the specified word within the content */
if ( ! function_exists('kw_content_replace')):
 function kw_content_replace($key, $post=array()){
	 $page = new PageService();
	  
		 $text = $page->showCopy($key);
		  
		  foreach($post as $key => $value):
		  	 $text=str_replace('['.$key. ']', $value,$text);
		  endforeach;
					  
	 return $text ;
  }
endif;





	function save_remote_ip($uid, $address){
		global $data;
		DB::dbQuery(
			"INSERT `{$data['DbPrefix']}visits`(`member`,`date`,`address`".
			")VALUES({$uid},'".date('Y-m-d H:i:s')."','{$address}')"
		);
	}
	



/**
         * @params message, message type
         * @access public
         * @return string
         */
  if(!function_exists('eventNotice')):
        function eventNotice($msg,$msgType='error'){
		
		switch($msgType){
			case 'success':
				$result = ' <div class="success">'.$msg.'</div>';
			break;
			 
			 case 'error':
				$result = ' <div class="error">'.$msg.'</div>';
			 break;
			 
			  case 'notice':
				$result = ' <div class="notice">'.$msg.'</div>';
			 break;
		}
		
		return $result;
		
	}
endif;


/* getExtension
		*
		*/
		function getExtension($str) {
		
				 $i = strrpos($str,".");
				 if (!$i) { return false; } 
		
				 $l = strlen($str) - $i;
				 $ext = substr($str, $i+1, $l);
				 
				 return $ext;
		}
		
                
                /**
                 * cleanOut escapes any input and make it safe for mysql insertion
                 * @param type array
                 * @return array 
                 */
		function cleanOut($var){
		
			$result=array();
			foreach ($var as $key => $value) {
                            $result[$key] = mysql_real_escape_string ($value);
			}
			
			reset($var);
			return $result;
		}
     
	 
	       
if(!function_exists('arrayToObject')){
	function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map(__FUNCTION__, $d);
		}
		else {
			// Return object
			return $d;
		}
	}
}
 
        
 if(!function_exists('objectToArray')){       
 	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
 }
 
 
 
