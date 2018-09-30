<?php
include ("vendor/autoload.php");
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 9/29/2018
 * Time: 9:13 AM
 */
if(isset($_POST['action'])){
    /**
     * Get All Comments
     */
    if($_POST['action'] == 'get_comments'){
        $object = new \App\comments();
        $comments = $object->get_all_comments();
        $blocks = new \App\blocks();
        $offset = '';
        $width = 9;
        echo $blocks->get_comment_block($comments, 0, 9);
    }
    /**
     * Insert new comment or reply
     */
    elseif($_POST['action'] == 'add_comment'){
        try{
            $object = new \App\comments();
            if($_POST['comment_level'] > 3){
                throw new \Exception('Cant have more than 3 nested replies');
            }elseif($_POST['parent_comment_id'] > 0){
                if(!$object->is_parent_comment_exist($_POST['parent_comment_id'])){
                    throw new \Exception('Parent comment does not exist');
                }
            }
            $data = array(
                htmlspecialchars($_POST['author_name']),
                htmlspecialchars($_POST['parent_comment_id']),
                htmlspecialchars($_POST['comment']),
                htmlspecialchars($_POST['comment_level']),
                date("Y-m-d H:i:s"));

            if($object->add_comment($data)){
                echo json_encode(array('status' => "ok", 'message' => 'comment added successfully'));
            }
        }catch(Exception $e){
            echo json_encode(array('status' => "error", 'message' => $e->getMessage()));
        }
    }
    /**
     * Get Reply form  
     */
    elseif($_POST['action'] == 'get_reply_form'){
        $blocks = new \App\blocks();
        $parent_id = $_POST['parent_id'];
        $comment_level = $_POST['comment_level'];
        echo $blocks->get_comment_form($parent_id, $comment_level);
    }
}