<?php
class Reactions
{
    static function setReaction($postArray){
        global $con;
        $array = [];
        if (!empty($postArray)) {

            if (isset($postArray['name']) && $postArray['name'] != '') {
                $name = stripslashes(trim($postArray['name']));
            }else{
                $array['error'][] = "Name not set in array";
            }
            if (isset($postArray['email']) && filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)) {
                $email = stripslashes(trim($postArray['email']));
            }else{
                $array['error'][] = "Invalid email format";
            }

            if (isset($postArray['message']) && $postArray['message'] != '') {
                $message = stripslashes(trim($postArray['message']));
            }else{
                $array['error'][] = "Message not set in array";
            }

            if (empty($array['error'])) {

                $srqry = $con->prepare("INSERT INTO reactions (name,email,message) VALUES (?,?,?);");
                if ($srqry === false) {
                    prettyDump( mysqli_error($con) );
                }
                
                $srqry->bind_param('sss',$name,$email,$message);
                if ($srqry->execute() === false) {
                    prettyDump( mysqli_error($con) );
                }else{
                    $array['succes'] = "Reaction save succesfully";
                }
            
                $srqry->close();
            }

            return $array;
        }
    }
    
    static function getReactions(){
        global $con;
        $array = [];
        $grqry = $con->prepare("SELECT id,name,email,message FROM reactions;");
        if($grqry === false) {
            prettyDump( mysqli_error($con) );
        } else{
            $grqry->bind_result($id,$name,$email,$message);
            if($grqry->execute()){
                $grqry->store_result();
                while($grqry->fetch()){
                    $array[] = [
                        'id' => $id,
                        'name' => $name,
                        'email'=> $email,
                        'message'=> $message
                    ];
                }
            }
            $grqry->close();
        }
        return $array;
    }
}

