<?


require_once '../bootstrap.php';
require_once '../Services/MemberService.php';
require_once '../Services/MemberOptions.php';
require_once '../Services/IMT/TransactionService.php';
#require_once 'ActiveRecord/Amfphp/Services/PageService.php';
#require_once 'ActiveRecord/Amfphp/Services/PhaseService.php';

global $data;

$email = 'kiwd@laeg.com';
$pword = 'tarvig7y';
$id = 44;
$fname = 'Jamesaa';
$lname = 'Darkoaa';


#var_dump(MemberService::isMemberActive($email, $pword));

#var_dump(MemberService::getAll());

// login test
#var_dump(MemberService::login($email, $pword));

//Delete a Member
#var_dump(MemberService::deleteMember($id));



//Create Member
$data = array('fname'=>$fname, 'lname'=>$lname, 'email'=>$email, 'password'=>$pword, 'question'=>'what is this', 'answer'=>'testing', 'account_type'=>'classicc');
//var_dump(MemberService::createMember($data));

#var_dump(MemberService::updateMember('', $data));
#var_dump(TransactionService::getAll());

#var_dump(MemberService::getMember(2));

######################## testing PageService
$slug = 'our-mission';
#var_dump(PageService::getAll());

// show page content
#var_dump(PageService::pgContent($slug));

#var_dump(PhaseService::getAll());

 $options = array('sec_question' => 'test quesiton', 'sec_answer' => 'tests answer' );
 ##var_dump(MemberOptions::addMemberOption(42, $options));
 
 $rs = DB::dbRows('SELECT * FROM kw_posts');
 $rs = DB::getSpecificRecordFields('post_content', 'kw_posts');
 var_dump($rs);
 
 #echo preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email);