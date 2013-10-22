<?php

$server = "http://staging.eventtrac.co.uk";
$apiusername = "dodec_et_api";
$apipassword = "Password2012$";
$event_id = 221;

#$start_date = "2008-10-07";
#$end_date = "2008-10-09";

#Event List Process
#################################
$event_list_json = @file_get_contents("$server/active_events.json");

$event_list = json_decode($event_list_json);
echo("\n\n\nEvent List\n####################################\n");
echo("ID,Event Name\n");
foreach($event_list as $event) {
  $id = $event->{'id'};
  $name = $event->{'name'};
  printf("%d,%s\n", $id, $name);
}


#exit;

#AttendanceTypes
#################################
$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$apiusername:$apipassword")
    )
));

$attendance_types_json = @file_get_contents("$server/registrations_api/attendance_types.json",false,$context);

$attendance_types = json_decode($attendance_types_json);

echo("\n\nAttendance Type List\n####################################\n");
echo("ID,Name\n");
foreach($attendance_types as $att) {
  $id = $att->{'id'};
  $name = $att->{'name'};
  printf("%d,%s\n", $id, $name);
}

#exit;

#List Registrations Process
#################################

#Build Options Array
$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$apiusername:$apipassword")
    )
));

#Send Query
$registrations_json = @file_get_contents("$server/registrations_api.json?event_id=$event_id&start_date=$start_date&end_date=$end_date", false, $context);

#Decode JSON Data
$registrations = json_decode($registrations_json);

# Do somthing with the data
echo("\n\nRegistration List\n####################################\n");
echo("ID,First Name, Surname, Email Address, Employer Name, Job Title, Created At\n");
foreach($registrations as $reg) {
  $id = $reg->{'id'};
  $attendance_type = $reg->{'attendance_type_name'};
  $attendee_first_name = $reg->{'attendee_first_name'};
  $attendee_surname = $reg->{'attendee_surname'};
  $attendee_email_address = $reg->{'attendee_email_address'};
  $employer = $reg->{'attendee_organisation'};
  $job_title = $reg->{'attendee_job_title'};
  $created_at = $reg->{'created_at'};
  printf("%d,%s,%s,%s,%s,%s,%s,%s\n", $id, $attendance_type, $attendee_first_name, $attendee_surname, $attendee_email_address, $employer, $job_title, $created_at);
}

#exit;

#Create Registrations Process
#################################
    $data = array('eventID'=>221, 'attendanceType'=>1, 'fname'=>'badFname', 
                      'lname'=>'badLname', 'email'=>'sdaasd@gmai.com', 'employer'=>'dodec',
                      'jobTitle'=>'business man', 'desc'=>'test data from the badge printer'
            );
#Build Post Data Array
$post_data = http_build_query(
     array('main_registration' => array(
                'event_id' => $data['eventID'],
                'attendance_type_id' => $data['attendanceType'],
                'person_attributes' => array(
                'first_name' => $data['fname'],
                'surname' => $data['lname'],
                'email_address' => $data['email'],
                'employer_name' => $data['employer'],
                'job_title_name' => $data['jobTitle']
				
                ),
                'notes' => $data['desc'],
      )
  )
);

#Build Options Array
$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$apiusername:$apipassword"),
        'method' => 'POST',
        'content' => $post_data
    )
));

#Post Data
$result = @file_get_contents("$server/registrations_api.json", false, $context);

echo("\n\nCreate Result\n####################################\n");
var_dump($result);

#exit;

#Update Delegate Details Process
################################

#Supply the Registration ID to be updated
$registration_id = 1163;

#Build Post Data Array
$post_data = http_build_query(
  array('main_registration' => array(
        'event_id' => $event_id,
        'attendance_type_id' => 1,
        'person_attributes' => array(
          'first_name' => "ApiTestFirstName",
          'surname' => "ApiTestSurname",
          'email_address' => 'Apitest@test.com',
          'employer_name' => 'API Empoyer Test',
          'job_title_name' => 'API Job Title Name',
          'notes' => 'Note Added to Person Record'
        ),
        'notes' => "Additional Data Supplied for Keying Later",
      )
  )
);

#Build Options Array
$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$apiusername:$apipassword"),
        'method' => 'PUT',
        'content' => $post_data
    )
));

#Post Data
$result = @file_get_contents("$server/registrations_api/$registration_id.json", false, $context);

echo("\n\nUpdate Result\n####################################\n");
var_dump($result);

?>
