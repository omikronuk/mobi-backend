<?php
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Services
 */


/**
 * This is a test/example service. Remove it for production use
 *
 * @package Amfphp_Services
 * @author Ariel Sommeria-kleinextends ActiveRecord\Model
 */
class UserService extends ActiveRecord\Model  {
	static $table = 'kw_users';

    
	
	function createUser($data=array()){
		$data['password'] = md5($data['password']);
		$data['active'] = 1;
		//$data['cdate'] = date('Y-m-d h:iA');
                $result = array();
		
                if(self::isEmailTaken($data['email'])):
                    $result['msg'] = "Oops! this email is already registered on our system, please choose a different email.";
                    
                elseif(!self::validateEmail($data['email'])):
                    $result['msg'] = 'Your email address is invalid';
                      
                else:
                    $mem = self::create($data);
                    
                    if($mem->{'id'}):
                        $result['memID'] = $mem->{'id'};

                       // $api = new MCAPI(MC_apikey);
                      //  $mem_email = $data['email'];
                       // $merge_vars = array('FNAME'=> $data['fname'], 'LNAME'=>$data['lname']);

                        // By default this sends a confirmation email - you will not see new users
                        // until the link contained in it is clicked!
                        //$retval = $api->listSubscribe( MC_listID, $mem_email, $merge_vars );
                        /*
                        if ($api->errorCode){
                                //Unable to load  \tCode=".$api->errorCode."\n \tMsg=".
                                $result['mc_msg'] = $api->errorMessage;

                        } else {
                                $result['mc_msg'] = "Your details have been submitted successfully, please check your inbox to confirm your subscription";
                        }
                        */
                    endif;
		endif;
		return $result;
	}
	
	function getAll(){
		
		$dtList = self::all();
		$rs = array();
		foreach($dtList as $key=>$val):
			 $rs[$key]['id'] = $val->{'id'}; #$dtList[$i]->{'id'};
			 $rs[$key]['fname'] = $val->{'fname'};
			 $rs[$key]['lname'] = $val->{'lname'};
			
			$rs[$key]['email'] = $val->{'email'};
			  $rs[$key]['password'] = $val->{'password'};
			 /*$rs[$key]['customer_ref'] = $dtList[$i]->{'customer_ref'};
			 */
			
		endforeach;
		
		
		return $rs;
		
	}
	
	
	function getUser($id){
		$dtList = self::find($id);
		$rs = array();
		 $rs['id'] = $dtList->{'id'};
		 $rs['fname'] = $dtList->{'fname'};
		 $rs['lname'] = $dtList->{'lname'};
		 $rs['email'] = $dtList->{'email'};
		 $rs['password'] = $dtList->{'password'};
		 $rs['customer_ref'] = $dtList->{'customer_ref'};
		
		//$rs = convertToArray($mem, $rs);
		
		if(!empty($dtList)):
                    return $rs;
                endif;
	}


	function deleteUser($id){
            $isMem = self::getUser($id);
		
            if(!empty($isMem)):
                $mem = self::find($id);
                $delRs = $mem->delete();

                return $delRs;
            endif;
                
              
	
	}
	
	function login($email, $pword){
            
            if(self::validateEmail($email)):

                $rs = self::isUserActive($email, $pword);
                $rs = ($rs !=0) ? $result['memID'] = $rs
                      : $result['msg'] = 'Oops! Login unsuccessfull, your account may have been suspended or your password may be incorrect.' ;

                 $_SESSION['uid'] = $rs;
            else:
                $result['msg'] = 'Your email address is invalid';
            endif;
            
            return $result;
	}
        
        
        
       function isEmailTaken($email){
             $rs = self::find('all', array('conditions' => array('email = ?' , $email))
                                     );
          
                 
            return (bool)$rs;
	}
        
        
        function isUserFound($username, $password){
                 $pword = md5($password);
		return (bool) self::getUserID($username, $password, '`active`=1 ');
	}
         
       function isUserActive($email, $pword){
                $pword = md5($pword);
             $rs = self::find('all', array('conditions' => 
                                            array('email = ? AND password = ? AND active = ?', $email, $pword, 1))
                                     );
             if(!empty($rs)):
                $rs = $rs[0]->{'id'};
             else: $rs = (bool)$rs;
             endif;
                 
            return $rs;
	}
                 
                 
         function getUserID($email, $pword){
		$rs = self::find('all', array('conditions' => array('email = ? AND password = ?', $email, $pword)));
		
		 $rs = $rs->{'id'};
		
		return $rs;
	}
        
        
        
        function check_email_address($email) {
            // First, we check that there's one @ symbol, 
            // and that the lengths are right.
            if (!preg_match("^[^@]{1,64}@[^@]{1,255}$", $email)) {
                // Email invalid because wrong number of characters 
                // in one section or wrong number of @ symbols.
                return false;
            }
            // Split it into sections to make life easier
            $email_array = explode("@", $email);
            $local_array = explode(".", $email_array[0]);
            for ($i = 0; $i < sizeof($local_array); $i++) {
                if (!preg_match("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
                }
            }
            // Check if domain is IP. If not, 
            // it should be valid domain name
            if (!preg_match("^\[?[0-9\.]+\]?$", $email_array[1])) {
                $domain_array = explode(".", $email_array[1]);
                if (sizeof($domain_array) < 2) {
                    return false; // Not enough parts to domain
                }
                for ($i = 0; $i < sizeof($domain_array); $i++) {
                if(!preg_match("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|↪([A-Za-z0-9]+))$", $domain_array[$i])) {
                        return false;
                    }
                }
                
                return true;
            }
            
       }
       
       
       function validateEmail($email)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}

}
?>
