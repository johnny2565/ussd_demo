<?php
// Reads the variables sent via POST
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;



$sessionId   = $_POST["sessionId"];  
$serviceCode = $_POST["serviceCode"]; 
$servicePhone = $_POST["phoneNumber"]; 
$text = $_POST["text"];
$uniqId = $_POST["unid"];



$connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");

$level = explode("*", $text);

if ( $text == "" ) {
$response  = "CON Hi welcome, Press\n";
$response .= " 1 - Generate Key (Keep This Key Safe) \n";
$response .= " 2 - To Vote (You must have a key) \n";
}

if(isset($level[0]) && $level[0]!="" && !isset($level[1]))
{
    
    if($level[0] == "1")
    {
       if(checking($servicePhone) > 0 ){
            $response.='END You have created a voters id before please continue with voting ';
       }else{
            $response.= createNewRecord($servicePhone);
        } 
    }

    if($level[0] == "2")
    {
      $response = " CON Enter Your OTP  \n";
    
    }
}
else if(isset($level[1]) and $level[1]!="" and !isset($level[2]))
{
    $response = " \n";
    $response.= checkParsedToken($level[1])."\n";
    // $response.= $level[0];
}
else if(isset($level[2]) and $level[2] !="" and !isset($level[3]))
{
    $response="CON Select Your Favorite Candidate ";
    $response.= displaySelectionMenu($level[2]); // This displays a menu of available candidates qualifiued for the post

//    $response = "CON Your Name is ".$level[0]." Your Number is ".$level[1]." and Your Password is".$level[2]." \n";
}else if(isset($level[3]) and $level[3]!="" and !isset($level[4]))
{
    // $response="CON You selected option".$level[3]." of ".$level[2]; 

    if($level[2] == "1" and $level[3] == "0") //Here if the voter decides to quit
    {
        $response = "END You did not cast any vote";
    }
    elseif ($level[2] == "1" and in_array($level[3], ["1","2","3","4","5"]))
    {
        // $response = "CON Vote Status \n";
       
            $response.= "END  Vote Status \n".checkForEligibility($servicePhone);
        
        // $response.= "\n END ";
    }

  
    //************************For Deputy President ********************
    if($level[2] == "2" and $level[3] == "0") //Here if the voter decides to quit
    {
        $response = "END You did not cast any vote ";
    }
    elseif ($level[2] == "2" and in_array($level[3], ["1","2","3","4","5"]))
    {
        // $response = "CON Vote Status \n";
        $response.= "END  Vote Status \n".checkForEligibility2($servicePhone);
        // $response.= "\n END ";
    }


     //************************For Secretary General ********************
    if($level[2] == "3" and $level[3] == "0") //Here if the voter decides to quit
    {
        $response = "END You did not cast any vote ";
    }
    elseif ($level[2] == "3" and in_array($level[3], ["1","2","3","4","5"]))
    {
        // $response = "CON Vote Status \n";
        $response.= "END  Vote Status \n".checkForEligibility3($servicePhone);
        // $response.= "\n END ";
    }


     //************************For Welfare ********************
    if($level[2] == "4" and $level[3] == "0") //Here if the voter decides to quit
    {
        $response = "END You did not cast any vote ";
    }
    elseif ($level[2] == "4" and in_array($level[3], ["1","2","3","4","5"]))
    {
        // $response = "CON Vote Status \n";
        $response.= "END  Vote Status \n".checkForEligibility4($servicePhone);
        // $response.= "\n END ";
    }


     //************************For Director Social ********************
    if($level[2] == "5" and $level[3] == "0") //Here if the voter decides to quit
    {
        $response = "END You did not cast any vote ";
    }
    elseif ($level[2] == "5" and in_array($level[3], ["1","2","3","4","5"]))
    {
        // $response = "CON Vote Status \n";
        $response.= "END  Vote Status \n".checkForEligibility5($servicePhone);
        // $response.= "\n END ";
    }


}

// This is the last option 

header('Content-type: text/plain');
echo $response;







function takeEnteredValue()
{
    $response.= $level[0];
}             




function checkParsedToken($token)
{
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");


     $sql = "SELECT token FROM voter WHERE token = '$token' ";
     
     $query = pg_query($connection, $sql);
     $numrow = pg_fetch_array($query);



        if($numrow["token"] > 0)
        {
            // $response = "CON "; 
            $response  = "CON Select The Post You Want To Vote For \n";
            $response .= "Enter 1 For Departmental President \n";
            $response .= "Enter 2 For Departmental Vice President \n";
            $response .= "Enter 3 For Departmental Secretary General \n";
            $response .= "Enter 4 For Departmental WelFare \n";
            $response .= "Enter 5 For Director Of Social \n";
            
            return $response;
        }
        else{
            // $response = "CON You Provided An Invalid Pin Please go and generate a unique Pin first "; 
            $response.="END You Provided An Invalid Pin Please go and generate a unique Pin first ";
            return $response;

        }



}


function displaySelectionMenu($menuOption)
{
    switch ($menuOption) {
        case '1':
            $response.= presidentialCandidates();
            break;

        case '2':
            $response.= vicePresidentialCandidates();
            break;

        case '3':
            $response.= secretaryCandidates();
            break;

        case '4':
            $response.= welfareCandidate();
            break;

        case '5':
            $response.= socialCandidate();
            break;
        
        default:
            $response.= "You selected an option that is not listed";
            break;
    }

    // $response=" END ".$menuOption;
    return $response;
}




// ********************************************************************* END OF RECONSTRUCTED PROGRAM *********************************

























function young($value)
{ 
  $xplode = explode("*", $value);
  return $value[2];
}


function checkPassword($valuePassed)
{
    if($valuePassed === "1234")
    {
        $response = "CON :  \n";
        $response .= "Enter 1 For Departmental President \n";
        $response .= "Enter 2 For Departmental Vice President \n";
        $response .= "Enter 3 For Departmental Secretary General \n";
        $response .= "Enter 4 For Departmental WelFare \n";
        $response .= "Enter 5 For Director Of Social \n";
    }
    else
    {
      $response .= "END \n";
    }
}

function generateToken()
{
		    $time = time();
		    $sub = substr($time, 5);
		    return $sub;
    
}

function insertGeneratedToken($token,$phonenumber)
{
    pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $code = "INSERT INTO voter(token, phonenumber) values ('$token', '$phonenumber' )";
    $gen_token = pg_query($code);
    // Populating the voted
    $voted = "INSERT INTO voted(token,post1, post2, post3, post4, post5, post6, post7 ) values ('$token', '', '', '', '', '', '', '')";
    pg_query($voted); 

    if($gen_token){
        return true;
    }else{
        return false;
    }
}

function createNewRecord($phonenumber) {
        // pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $response = "CON Token has been sent to ".$phonenumber;
        $response.= "\n please keep it safe";
        $response.= sendSMS($phonenumber);
        $resObtained = insertGeneratedToken(generateToken(),$phonenumber);  
        $response .= "\n Enter 0 Exit to ";
        return $response;
        
     
}


function sendSMS($number)
{
    // Set your app credentials
$username   = "johnn_io";
$apiKey     = "0f8b50b252faa75d32fcd463d34a3104397ab2453ea95973e55b3ab12e728760";

// Initialize the SDK
$AT = new AfricasTalking($username, $apiKey);

// Get the SMS service
$sms = $AT->sms();

// Set the numbers you want to send to in international format
$recipients = $number;
 $time = time();
  $sub = substr($time, 5);

// Set your message
$message = "Your token is ".$sub;

// Set your shortCode or senderId
// $from  = "";

try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $recipients,
        'message' => $message,
        // 'from'    => $from
    ]);

 return $result;
} catch (Exception $e) {
    return "Error Sending message: ".$e->getMessage();
}


}

function presidentialCandidates() {
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $collect_aspirants = " SELECT * FROM aspirants WHERE position NOT IN ('secretary', 'welfare', 'social', 'sport') ";
    $result = pg_query($connection, $collect_aspirants);
    $count = 1;
    while($row = pg_fetch_array($result)){
        
        if(strtolower($row['position']) !="president" )
        {
            continue;
        }
        else
        {
            $response .= " Enter ".$count." to vote  ".$row['fullname']."<br/>";
        }
        ++$count;

    }
 
    $response .= "\n Enter 0 to Exit  ";
    return $response;
    
 
}


function vicePresidentialCandidates() {
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $collect_aspirants = " SELECT * FROM aspirants WHERE position NOT IN ('secretary', 'welfare', 'social', 'sport') ";
    $result = pg_query($connection, $collect_aspirants);
    $count = 1;
    while($row = pg_fetch_array($result)){
        
        if(strtolower($row['position']) !="vice president" )
        {
            continue;
        }
        else
        {
            $response.= " Enter ".$count." to vote  ".$row['fullname']."<br/>";
        }

        ++$count;
    }
 
    // $response.= "\n Enter 0 to Exit  ";
    return $response;
    
 
}


function secretaryCandidates() {
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $collect_aspirants = " SELECT * FROM aspirants  ";
    $result = pg_query($connection, $collect_aspirants);
    $count = 1;
    while($row = pg_fetch_array($result)){
        
        if(strtolower($row['position']) !="secretary" )
        {
            continue;
        }
        else
        {
            $response.= " Enter ".$count." to vote  ".$row['fullname']."<br/>";
        }

        ++$count;
    }
 
    // $response.= "\n Enter 0 to Exit  ";
    return $response;
    
 
}

function welfareCandidate()
{
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $collect_aspirants = " SELECT * FROM aspirants WHERE position NOT IN ('secretary', 'welfare', 'social', 'sport') ";
    $result = pg_query($connection, $collect_aspirants);
    $count = 1;
    while($row = pg_fetch_array($result)){
        
        if(strtolower($row['position']) !="welfare" )
        {
            continue;
        }
        else
        {
            $response.= " Enter ".$count." to vote  ".$row['fullname']."<br/>";
        }

        ++$count;
    }
 
    // $response.= "\n Enter 0 to Exit  ";
    return $response;

}

function socialCandidate()
{

    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $collect_aspirants = " SELECT * FROM aspirants WHERE position NOT IN ('secretary', 'welfare', 'social', 'sport') ";
    $result = pg_query($connection, $collect_aspirants);
    $count = 1;
    while($row = pg_fetch_array($result)){
        
        if(strtolower($row['position']) !="social" )
        {
            continue;
        }
        else
        {
            $response.= " Enter ".$count." to vote  ".$row['fullname']."<br/>";
        }

        ++$count;
    }
 
    // $response.= "\n Enter 0 to Exit  ";
    return $response;


}



function checking($servicePhone)
{
    $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    $check = " SELECT * FROM voter WHERE phonenumber = '$servicePhone' ";
    $phonenumberFound = pg_query($connection, $check);
    $result = pg_num_rows($phonenumberFound);
    return $result;
}



function checkForEligibility($phonenumber)
    {
        // $phonenumber = '+2348125125489';
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $checkE = "SELECT token FROM voter WHERE phonenumber = '$phonenumber' ";  
        $checkDB = pg_query($connection, $checkE);
        $numrow = pg_fetch_array($checkDB);
        // $all_result = pg_num_array($result);
        // print_r($numrow)."<br/>";
        // return $numrow["token"];

        if($numrow["token"] > 0)
        {
            $response.= castVote($numrow["token"]); 
            // $response = $numrow["token"]; 
            return $response;
        }
        else{
            $response.='Please go and generate a unique ID first';
            return $response;

        }
    }

    function castVote($token){
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    
        //Check if voted for before
        $chkVoted =  "SELECT  post1 FROM voted WHERE token = '$token' ";  
        $query = pg_query($connection,$chkVoted);
        $numrow = pg_fetch_array($query);
        // return $numrow["post1"]."".$numrow["token"];
        if($numrow["post1"] == "" )
        {
            $update = "UPDATE voted SET post1= '1' WHERE token = '$token' ";
            $action = pg_query($connection,$update);
            $result = pg_affected_rows($action);
            $actionRes = $result;
            $res= 'You have Successfully Voted';
            return $res;
             
        }
        else{
            $res="It seems you have voted before";
            return $res;
        }

    }

    // Casting Two

    function checkForEligibility2($phonenumber)
    {
        // $phonenumber = '+2348125125489';
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $checkE = "SELECT token FROM voter WHERE phonenumber = '$phonenumber' ";  
        $checkDB = pg_query($connection, $checkE);
        $numrow = pg_fetch_array($checkDB);
        // $all_result = pg_num_array($result);
        // print_r($numrow)."<br/>";
        // return $numrow["token"];

        if($numrow["token"] > 0)
        {
            $response.= castVote2($numrow["token"]); 
            // $response = $numrow["token"]; 
            return $response;
        }
        else{
            $response.='Please go and generate a unique ID first';
            return $response;

        }
    }



    function castVote2($token)
    {
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    
        //Check if voted for before
        $chkVoted =  "SELECT  post2 FROM voted WHERE token = '$token' ";  
        $query = pg_query($connection,$chkVoted);
        $numrow = pg_fetch_array($query);
        // return $numrow["post1"]."".$numrow["token"];
        if($numrow["post2"] == "" )
        {
            $update = "UPDATE voted SET post2= '1' WHERE token = '$token' ";
            $action = pg_query($connection,$update);
            $result = pg_affected_rows($action);
            $actionRes = $result;
            $res= 'You have Successfully Voted';
            return $res;
             
        }
        else{
            $res="It seems you have voted before";
            return $res;
        }

    }

    function checkForEligibility3($phonenumber)
    {
        // $phonenumber = '+2348125125489';
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $checkE = "SELECT token FROM voter WHERE phonenumber = '$phonenumber' ";  
        $checkDB = pg_query($connection, $checkE);
        $numrow = pg_fetch_array($checkDB);
        // $all_result = pg_num_array($result);
        // print_r($numrow)."<br/>";
        // return $numrow["token"];

        if($numrow["token"] > 0)
        {
            $response.= castVote3($numrow["token"]); 
            // $response = $numrow["token"]; 
            return $response;
        }
        else{
            $response.='Please go and generate a unique ID first';
            return $response;

        }
    }



    function castVote3($token)
    {
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    
        //Check if voted for before
        $chkVoted =  "SELECT  post3 FROM voted WHERE token = '$token' ";  
        $query = pg_query($connection,$chkVoted);
        $numrow = pg_fetch_array($query);
        // return $numrow["post1"]."".$numrow["token"];
        if($numrow["post3"] == "" )
        {
            $update = "UPDATE voted SET post3 = '1' WHERE token = '$token' ";
            $action = pg_query($connection,$update);
            $result = pg_affected_rows($action);
            $actionRes = $result;
            $res= 'You have Successfully Voted';
            return $res;
             
        }
        else{
            $res="It seems you have voted before";
            return $res;
        }

    }


    function checkForEligibility4($phonenumber)
    {
        // $phonenumber = '+2348125125489';
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $checkE = "SELECT token FROM voter WHERE phonenumber = '$phonenumber' ";  
        $checkDB = pg_query($connection, $checkE);
        $numrow = pg_fetch_array($checkDB);
        // $all_result = pg_num_array($result);
        // print_r($numrow)."<br/>";
        // return $numrow["token"];

        if($numrow["token"] > 0)
        {
            $response.= castVote4($numrow["token"]); 
            // $response = $numrow["token"]; 
            return $response;
        }
        else{
            $response.='Please go and generate a unique ID first';
            return $response;

        }
    }



    function castVote4($token)
    {
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    
        //Check if voted for before
        $chkVoted =  "SELECT  post4 FROM voted WHERE token = '$token' ";  
        $query = pg_query($connection,$chkVoted);
        $numrow = pg_fetch_array($query);
        // return $numrow["post1"]."".$numrow["token"];
        if($numrow["post4"] == "" )
        {
            $update = "UPDATE voted SET post4 = '1' WHERE token = '$token' ";
            $action = pg_query($connection,$update);
            $result = pg_affected_rows($action);
            $actionRes = $result;
            $res= 'You have Successfully Voted';
            return $res;
             
        }
        else{
            $res="It seems you have voted before";
            return $res;
        }

    }


    function checkForEligibility5($phonenumber)
    {
        // $phonenumber = '+2348125125489';
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
        $checkE = "SELECT token FROM voter WHERE phonenumber = '$phonenumber' ";  
        $checkDB = pg_query($connection, $checkE);
        $numrow = pg_fetch_array($checkDB);
        // $all_result = pg_num_array($result);
        // print_r($numrow)."<br/>";
        // return $numrow["token"];

        if($numrow["token"] > 0)
        {
            $response.= castVote5($numrow["token"]); 
            // $response = $numrow["token"]; 
            return $response;
        }
        else{
            $response.='Please go and generate a unique ID first';
            return $response;

        }
    }



    function castVote5($token)
    {
        $connection = pg_connect("host=ec2-3-213-228-206.compute-1.amazonaws.com dbname=dekg3d43m01ak4 user=ungxjvmznyohtl password=618aa5ddefd4ea83f6709974f292f2fd0e2138c5d31b054a6821e9c801424977");
    
        //Check if voted for before
        $chkVoted =  "SELECT  post5 FROM voted WHERE token = '$token' ";  
        $query = pg_query($connection,$chkVoted);
        $numrow = pg_fetch_array($query);
        // return $numrow["post1"]."".$numrow["token"];
        if($numrow["post5"] == "" )
        {
            $update = "UPDATE voted SET post5 = '1' WHERE token = '$token' ";
            $action = pg_query($connection,$update);
            $result = pg_affected_rows($action);
            $actionRes = $result;
            $res= 'You have Successfully Voted';
            return $res;
             
        }
        else{
            $res="It seems you have voted before";
            return $res;
        }

    }




?>


