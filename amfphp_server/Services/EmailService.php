<?php
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Examples_ExampleService
 */

/**
 * an example service for the pizza examples
 * @package Amfphp_Examples_ExampleService
 * @author Ariel Sommeria-klein
 */
class EmailService {
    
    function sendMessage($data=array()){
        
		$from = $data['from'];
		$cc = $data['cc'];
		$bc = $data['bc'];
		$subject = $data['subject'];
		$to = $data['to'];
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $text = $data['msg'];

			// More headers
		$headers .= 'From:' . $from . "\r\n";
		$headers .= 'CC:' . $cc . "\r\n";
		$headers .= 'BC:' . $bc . "\r\n";



     	$msg ='<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>'.$subject.'</title>

				</head>
				<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" >
					<center>
					<table width="100%" cellpadding="0" cellspacing="0" bgcolor="">
						<tr valign="top" align="center">
							<td>
								'.$text.'

							</td>
						</tr>
					</table>
					</center>

				</body>
			';


        $ok = @mail($to, $subject, $msg, $headers);
		if ($ok) {
		  $status = TRUE;
		} else {
		  $status = FALSE;
		}

		return $status;
        
    }
}
?>
