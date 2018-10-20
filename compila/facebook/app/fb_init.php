<?php  


require 'facebook/src/Facebook/autoload.php';


// session_start();


$fb = new Facebook\Facebook([
  'app_id' => '1830890463900211', // Replace {app-id} with your app id
  'app_secret' => '37b525f84e35d8369d779e338e02c2bc',
  'default_graph_version' => 'v2.2',
  ]);


?>