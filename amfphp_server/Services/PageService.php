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
class PageService extends ActiveRecord\Model  {
	static $table = 'kw_posts';

   function getAll(){
		
		$dtList = self::all();
		$rs = array();
		
		foreach($dtList as $key=>$val):
			 $rs[$key]['id'] = $val->{'id'};
			 $rs[$key]['post_title'] = $val->{'post_title'};
			 $rs[$key]['post_content'] =  strip_tags($val->{'post_content'});
			 $rs[$key]['created_on'] = $val->{'created_on'};
                         $rs[$key]['ecomments'] = $val->{'ecomments'};
                         $rs[$key]['parent'] = $val->{'parent'};
		
		endforeach;
		
		
		return $rs;
		
}
	
	
	function getPage($id){
		$dtList = self::find($id);
		$rs = array();
		 $rs['id'] = $dtList->{'id'};
		 $rs['post_title'] = $dtList->{'post_title'};
		 $rs['post_content'] = $dtList->{'post_content'};
		 $rs['created_on'] = $dtList->{'created_on'};
		 $rs['ecomments'] = $dtList->{'ecomments'};
		 $rs['parent'] = $dtList->{'parent'};
		
		//get the category record of the current post
                $catInfo = self::find_by_sql("SELECT * FROM kw_post_cat_rel WHERE post_id =".$dtList->{'id'});
                $rs['cat_id'] = $catInfo[0]->{'cat_id'};
               		
		if(!empty($dtList)):
                    return $rs;
                endif;
	}
  
       function pgContent($data=array()){
	    $data = is_object($data) ? objectToArray($data) : $data;
           $slug = $data['slug'];
           $rs = array();
           
            $dtList = self::find_by_sql("SELECT post_title, slug, post_content, parent FROM kw_posts ".
                            "WHERE post_type = 'page' AND post_status = 2 AND slug = '".$slug."'");

	 if(!empty($dtList)){
              $rs['post_title'] = $dtList[0]->{'post_title'};
                #$rs['post_content'] = strip_tags($dtList[0]->{'post_content'});
                $rs['post_content'] = $dtList[0]->{'post_content'};
                $rs['slug'] = $dtList[0]->{'slug'};
                $rs['parent'] = $dtList[0]->{'parent'};
                

          }
            return $rs;
       }
       
       
       function pgTitle($slug){
           $slug = "'". $slug. "'";
                $dtList = self::find_by_sql("SELECT post_title FROM kw_posts WHERE slug =".$slug);
		
		 $ctn = $dtList[0]->{'post_title'};
		
		if(!empty($dtList)):
                    return $ctn;
                endif;
           
       }
        
        
      function title($slug=''){
          // $dtList = self::find_by_slug_or_id_and_post_status_and_post_type($slug, $slug, 2, 9);
            $dtList = self::find_by_sql("SELECT post_title FROM kw_posts ".
                            "WHERE post_type = 9 AND post_status = 2 AND slug = '".$slug."'");
           
	 return $rs['post_title'] = $dtList[0]->{'post_title'};
      }

      

     function showCopyTitle($slug){
         //$dtList = self::find_by_slug_or_id_and_post_status_and_post_type($slug, $slug, 2, 12);
            $dtList = self::find_by_sql("SELECT post_title FROM kw_posts ".
                            "WHERE post_type = 12 AND post_status = 2 AND slug = '".$slug."'");
	 return $rs['post_title'] = $dtList[0]->{'post_title'};
     }



    function showCopy($slug, $img='', $excerpt=null){
           $dtList = self::find_by_sql("SELECT post_title, slug, post_content, parent FROM kw_posts ".
                            "WHERE post_type = 12 AND post_status = 2 AND slug = '".$slug."'");
                $rs['post_title'] = $dtList[0]->{'post_title'};
                $rs['post_content'] = $dtList[0]->{'post_content'};
                $rs['slug'] = $dtList[0]->{'slug'};
                $rs['parent'] = $dtList[0]->{'parent'};
                
                
             if($img != 'image'):
                    return $excerpt !==null ? $rs['post_intro'] : $rs['post_content'];
             else:
                    //$postMedia = Mediamanager::getMediaInfoBy(array('post_guid'=>$rs['post_guid']));
                    //echo '<img src="/assets/images/'.$postMedia[0]['file_name'].'" />';
            endif;
		
      }



        function getPagesDropDown($p_type=9){
           # return Kw_posts::getPostsDropDown(array('post_type'=>$p_type));

        }





         function setStatus($id, $post){


            $this->db->where('id', $id);
            $this->db->update('kw_posts', $post);
            return $this->db->affected_rows();

         }


         function deletePage($id, $post){

            $this->db->delete('kw_posts', array('id' => $id));
			return affected_rows();

         }



    /**
     * verify if Page Content already exists
     * @return boolean
     */
     function isPageExist($pTitle, $pType=9){
            global $data;
           $pid = mysql_escape_string($pid);
            $sql = "SELECT `id` FROM `kw_posts` WHERE (`post_title`='{$pTitle}' AND `post_type` = '{$pType}') LIMIT 1";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return (bool)($result['id']);
     }



	/*
	build a menu for this page

	*/
	function relatedContent($option=array()){
		    $slug = !$option['slug'] ? $this->uri->segment(2) : $option['slug'];
			$this->db->where('slug', $slug);
			$this->db->where('post_status', 2);
            $query = $this->db->get('kw_posts');
			$rs = $query->row_array();


			$query = $this->db->get_where('kw_posts', array('parent' => $rs['id']));
            $rs = $query->result_array();

			$result = array();
			$class = $option['class'];
			
			if(!empty($rs)):
				echo '<div class="mB10 bdrB">'. $option['menu_header'] . '</div>';
				echo '<ul id="'.$option['css_id'].'" class="'.$option['class'].'">';
				foreach($rs as $key=>$val):
					$title = $val['post_title'];
					$slug = $val['slug'];
					echo ' <li id="'.$title.'" class="'.$option['li_class'].'">
								<a href="#" title="'.$title.'" class="rel_pg" id="'.$slug.'" >'.$title.'</a>
	
							</li>';
	
				endforeach;
				#return $rs;
				echo '</ul>';
			endif;

	}   
        

}
?>
