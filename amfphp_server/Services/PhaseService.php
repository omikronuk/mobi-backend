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
class PhaseService extends ActiveRecord\Model  {
	static $table = 'kw_posts';

	
	function getAll(){
            $dbQts = ' " ';
            $sgQts = " ' ";
            $ltr = array($dbQts, $sgQts);
            
            $nDBqts = ' \" ';
            $nSGqts = "  ";
            
            $nltr = array($nDBqts, $nSGqts);
		$dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE post_type = 'phase' AND `post_status` = 2");
		$rs = array();
		$i= 0;
		foreach($dtList as $key=>$val):
			 $rs[$key]['id'] = $dtList[$i]->{'id'};
			# $rs[$key]['post_title'] = str_replace("'", "\'", $dtList[$i]->{'post_title'});
			# $rs[$key]['post_content'] =  str_replace("'", " \'", $dtList[$i]->{'post_content'});
                         $rs[$key]['post_title'] = strip_tags($dtList[$i]->{'post_title'});
			 $rs[$key]['post_content'] =  strip_tags($dtList[$i]->{'post_content'});
			 $rs[$key]['created_on'] = $dtList[$i]->{'created_on'};
                         $rs[$key]['slug'] = $dtList[$i]->{'slug'};
                         $rs[$key]['principle'] = self::getOption('principle', $dtList[$i]->{'id'});
                         $rs[$key]['problem'] = self::getOption('problem', $dtList[$i]->{'id'});
			 
			 $i++;
		endforeach;
		
		
		return $rs;
		
	}
        
        
          function getAllPhaseSections($pid){
            $dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE parent={$pid} AND post_type = 'phase_section'");
           // $phaseInfo = self::getPhase($pid);
           
		$rs = array();
                
		$i= 0;
		foreach($dtList as $key=>$val):
                        $mediaInfo = self::find_by_sql("SELECT * FROM kw_media WHERE post_guid = {$val->{'post_guid'}}");
			 $rs[$key]['id'] = $dtList[$i]->{'id'};
			 $rs[$key]['post_title'] = ($dtList[$i]->{'post_title'});
                         $rs[$key]['tags'] = $dtList[$i]->{'tags'};
			 $rs[$key]['post_content'] = strip_tags($dtList[$i]->{'post_content'});
                          $rs[$key]['slug'] = $dtList[$i]->{'slug'};
			 $rs[$key]['created_on'] = $dtList[$i]->{'created_on'};
                         $rs[$key]['phase_id'] = $pid;
                         
                         if(!empty($mediaInfo)):
                            $rs[$key]['file'] = $mediaInfo[$i]->{'file_name'};
                         
                            endif;
			 
			 $i++;
		endforeach;
		
		
		return $rs;
        }
	
	
	function getPhase($str){
          
            if(is_numeric($str)):
                  $dtList = self::find($str);
                
            else:
                $i = 0;
                $dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE post_type = 'phase' AND slug = '{$str}'") ;
                 $dtList =  $dtList[$i];
                    
            endif;
            
            $rs = array();
            $rs['id'] = $dtList->{'id'};
            $rs['phase_title'] = $dtList->{'post_title'};
            $rs['phase_content'] = strip_tags($dtList->{'post_content'});
            $rs['ecomments'] = $dtList->{'ecomments'};
            $rs['parent'] = $dtList->{'parent'};
            $rs['principle'] = self::getOption('principle', $rs['id']);
            $rs['problem'] = self::getOption('problem', $rs['id']);
		
            //$rs = convertToArray($mem, $rs);
		
            if(!empty($dtList)):
                    return $rs;
                
            else: return null;
                
                endif;
               
	}
        
        
        function getPhaseSection($id){
		$dtList = self::find($id);
		$rs = array();
		 $rs['id'] = $dtList->{'id'};
		 $rs['phase_title'] = $dtList->{'post_title'};
		 $rs['phase_content'] = strip_tags($dtList->{'post_content'});
		 $rs['ecomments'] = $dtList->{'ecomments'};
		 $rs['parent'] = $dtList->{'parent'};
		
		//$rs = convertToArray($mem, $rs);
		
		if(!empty($dtList)):
                    return $rs;
                
                else: return null;
                
                endif;
               
	}

        function getPhasePrinciple($pid){
            $dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE parent={$pid} AND post_type = 'phase_section' AND tags = 'principle'");
            $phaseInfo = self::getPhase($pid);
           
		$rs = array();
                
		$i= 0;
		foreach($dtList as $key=>$val):
                        $mediaInfo = self::find_by_sql("SELECT * FROM kw_media WHERE post_guid = {$val->{'post_guid'}}");
			 $rs[$key]['id'] = $dtList[$i]->{'id'};
			 $rs[$key]['post_title'] = $dtList[$i]->{'post_title'};
			 $rs[$key]['post_content'] = strip_tags($dtList[$i]->{'post_content'});
			 $rs[$key]['created_on'] = $dtList[$i]->{'created_on'};
                         $rs[$key]['phase'] = $phaseInfo['phase_title'];
                         
                         if(!empty($mediaInfo)):
                            $rs[$key]['file'] = $mediaInfo[$i]->{'file_name'};
                         
                            endif;
			 
			 $i++;
		endforeach;
		
		
		return $rs;
        }

        
        function getPhaseProblems($pid){
            
             $dtList = self::find_by_sql("SELECT * FROM kw_posts WHERE parent={$pid} AND post_type = 'phase_section' AND tags = 'problem'");
             $phaseInfo = self::getPhase($pid);
           
		$rs = array();
                
		$i= 0;
		foreach($dtList as $key=>$val):
                        $mediaInfo = self::find_by_sql("SELECT * FROM kw_media WHERE post_guid = {$val->{'post_guid'}}");
			 $rs[$key]['id'] = $dtList[$i]->{'id'};
			 $rs[$key]['post_title'] = $dtList[$i]->{'post_title'};
			 $rs[$key]['post_content'] = strip_tags($dtList[$i]->{'post_content'});
			 $rs[$key]['created_on'] = $dtList[$i]->{'created_on'};
                         $rs[$key]['phase'] = $phaseInfo['phase_title'];
                         
                         if(!empty($mediaInfo)):
                            $rs[$key]['file'] = $mediaInfo[$i]->{'file_name'};
                         
                            endif;
			 
			 $i++;
		endforeach;
		
		
		return $rs;
            
        }
		
				
	function getPhaseSectionFiles($guid){
            $dlList = self::find_by_sql("SELECT * FROM kw_media WHERE post_guid =".$guid);
            $phaseSecInfo = self::find($guid);
            $rs = array();
            $i= 0;
            foreach($dlList as $key=>$val):
                        $rs[$key]['post_guid'] = $guid;
                        $rs[$key]['id'] = $dlList[$i]->{'id'};
                        $rs[$key]['media_title'] = $dlList[$i]->{'media_title'};
			$rs[$key]['file_name'] = $dlList[$i]->{'file_name'};
                        $rs[$key]['file_path'] = $dlList[$i]->{'file_path'};
                        $rs[$key]['created_on'] = $dlList[$i]->{'created_on'};
                        $rs[$key]['status'] = $dlList[$i]->{'status'};
                        $rs[$key]['phaseSection'] = $phaseSecInfo->{'post_title'};
                        $media_desc = unserialize($dlList[$i]->{'description'});
                        $rs[$key]['desc']  = strip_tags($media_desc['description']);
                        $rs[$key]['file1'] = $media_desc['m1']; #'/assets/video_shots/vid-01.jpg'; # 
                        $rs[$key]['file2'] = $media_desc['m2']; #'/assets/video_shots/vid-02.jpg'; # 
                        $rs[$key]['file3'] = $media_desc['m3']; #'/assets/video_shots/vid-03.jpg'; #
                        



                        $i++;
            endforeach;

            if(!empty($dlList)):
                    return $rs;
            endif;
	}
        
        
            /*
	*
	*/
    function addPhaseOption($options = array(), $postId)
    {
		foreach ($options as $key => $val):
			$data = array('post_id' => $postId,
                                      'meta_key' => $key,
				      'meta_value' => $val
				     );
			$this->db->insert('kw_post_meta', $data);
                         $mem = self::create($data);
		endforeach;


         return $this->db->insert_id();

    }


    
    /* getOption retrieves an option in the kw_options table    *
    */
    function getOption($key, $postId){
             global $data;
            
            $dtList = self::find_by_sql("SELECT `meta_value` FROM kw_post_meta WHERE `meta_key` = '".$key."' AND post_id = $postId ");
             
            return  $dtList[0]->{'meta_value'};
            

    }





    /*	Method to update a member meta data
	*
	*/
    function updatePhaseOption($options = array(), $pid)
    {

                $this->db->where('post_id', $pid);
		$this->db->where('meta_key', $options['meta_key']);
                $this->db->update('kw_post_meta', $options);
                $res = $this->db->affected_rows();

            return  $res;

    }

}
?>
