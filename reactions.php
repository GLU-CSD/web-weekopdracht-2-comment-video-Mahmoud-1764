<?php
class Reactions
{
    static function setReaction($postArray)
    {
        global $con;
        $array = [];
        if (!empty($postArray)) {
            if (isset($postArray['name']) && $postArray['name'] != '') {
                $name = stripslashes(trim($postArray['name']));
            } else {
                $array['error'][] = "Name not set in array";
            }

            if (isset($postArray['email']) && filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)) {
                $email = stripslashes(trim($postArray['email']));
            } else {
                $array['error'][] = "Invalid email format";
            }

            if (isset($postArray['message']) && $postArray['message'] != '') {
                $message = stripslashes(trim($postArray['message']));
            } else {
                $array['error'][] = "Message not set in array";
            }

            if (isset($postArray['video_id']) && is_numeric($postArray['video_id'])) {
                $video_id = (int) $postArray['video_id'];
            } else {
                $array['error'][] = "Video ID is missing or invalid";
            }

            if (empty($array['error'])) {
                $srqry = $con->prepare("INSERT INTO reactions (name, email, message, video_id) VALUES (?, ?, ?, ?);");
                if ($srqry === false) {
                    prettyDump(mysqli_error($con));
                }

                $srqry->bind_param('sssi', $name, $email, $message, $video_id);
                if ($srqry->execute() === false) {
                    prettyDump(mysqli_error($con));
                } else {
                    $array['success'] = "Reaction saved successfully";
                }

                $srqry->close();
            }

            return $array;
        }
    }
    static function getReactions($video_id)
    {
        global $con;
        $array = [];
        $grqry = $con->prepare("SELECT id, name, email, message FROM reactions WHERE video_id = ?;");
        if ($grqry === false) {
            prettyDump(mysqli_error($con));
        } else {
            // Bind de parameter $video_id aan het statement
            $grqry->bind_param('i', $video_id); // 'i' staat voor integer
    
            if ($grqry->execute()) {
                $grqry->store_result();
                $grqry->bind_result($id, $name, $email, $message);
                while ($grqry->fetch()) {
                    $array[] = [
                        'id' => $id,
                        'name' => $name,
                        'email' => $email,
                        'message' => $message
                    ];
                }
            }
            $grqry->close();
        }
        return $array;
    }
}

