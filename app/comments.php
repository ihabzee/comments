<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 9/28/2018
 * Time: 9:31 PM
 */

namespace App;


class comments extends DB{


    /**
     * comments constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add_comment($data)
    {
            $sql = "INSERT INTO comments (author_name, parent_comment_id, comment, comment_level, created_at) VALUES (?,?,?,?,?)";
            $stmt= $this->db->prepare($sql);
            $this->db->beginTransaction();
            $stmt->execute($data);
           return  $this->db->commit();
    }

    /**
     * insert one comment
     */
    public function add_test(){
        $this->add_comment(array('Test', 3, 'This is a test reply for reply  three', 2, date("Y-m-d H:i:s")));
        $this->add_comment(array('Test', 3, 'This is a test reply for reply three', 2, date("Y-m-d H:i:s")));
    }

    /**
     * Check wither parent comment exist
     * @param int $comment_id
     * @return bool
     */
    public function is_parent_comment_exist($comment_id)
    {
        $stmt = $this->db->prepare("SELECT * from comments WHERE id = :param");
        $stmt->bindParam(':param', $comment_id, \PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }
    /**
     * Get parent
     * @param int $parent_comment_id
     * @param string $order
     * @return array
     */
    public function get_comments($parent_comment_id = 0)
    {
        $stmt = $this->db->prepare("SELECT * from comments WHERE parent_comment_id = :param ORDER BY created_at DESC");
        $stmt->bindParam(':param', $parent_comment_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieve all comments and their replies
     * @return mixed
     */
    public function get_all_comments()
    {
        $comments = $this->get_comments();
        return $this->prepare_replies($comments);
    }

    /**
     * Loop over comments and their replies to build multidimensional array of comments and replies
     * @param array $comments
     * @return array
     */
    public function prepare_replies($comments)
    {
        $pointer = 0;
        foreach ($comments as $comment){
            $comments[$pointer]['replies'] = $this->get_comment_replies($comment['id']);
            $pointer++;
        }
        return $comments;
    }

    /**
     * Get all comment replies
     * @param int $comment_id
     * @return array
     */
    public function get_comment_replies($comment_id)
    {
        $comments = $this->get_comments($comment_id);
        return $this->prepare_replies($comments);
    }
}