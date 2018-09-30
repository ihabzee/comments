<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 9/28/2018
 * Time: 11:12 PM
 */

namespace App;
class blocks
{

    /**
     * Get html for comments
     * @param array $comment
     * @param int $offset
     * @param int $width
     * @return string
     */
    public function get_comment_block($comments, $level, $width)
    {
        $content = '';
        $offset = '';
        if ($level > 0) {
            $offset = 'col-md-offset-' . $level;

        }
        foreach ($comments as $comment) {
            $current_width = (int)$width - $comment['comment_level'];
            $content .= '<article class="row comment-row">
                            <div class="col-md-2 col-sm-2 ' . $offset . '">
                                <figure class="thumbnail">
                                    <img class="img-responsive" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                                    <figcaption class="text-center">' . $comment['author_name'] . '</figcaption>
                                </figure>
                            </div>
                            <div class="col-md-' . $current_width . '">
                                <div class="panel panel-default arrow left">
                                    '.($comment['comment_level'] < 2 ? '<div class="panel-heading right">Comment</div>' : '').'
                                    <div class="panel-body">
                                        <header class="text-left">
                                            <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> ' . $comment['created_at'] . '</time>
                                        </header>
                                        <div class="comment-post">
                                            <p>
                                                ' . $comment['comment'] . '
                                            </p>
                                        </div>
                                        <p class="text-right"><a href="#" data-column-width="col-md-' . $current_width . '" data-comment-level="' . $comment['comment_level'] . '" data-parent-comment="' . $comment['id'] . '" class="btn btn-default btn-sm reply-btn"><i class="fa fa-reply"></i> reply</a></p>
                                    </div>
                                </div>
                                
                            </div>
                        </article>
                        <div class="reply-form"></div>
                        ';
            if (!empty($comment['replies'])) {
                $content .= $this->get_comment_block($comment['replies'], $level + 1, $width);
            }

        }
        return $content;
    }


    /**
     * Build comment form
     * @param int $parent_id
     * @param int $comment_level
     * @return string
     */
    public function get_comment_form($parent_id = 0, $comment_level = 0)
    {
        $comment_level = $comment_level + 1;
        return '<form id="parent_comment_id_'.$parent_id.'">
                    <input type="hidden" name="parent_comment_id"  id="parent_comment_id" value="'.$parent_id.'">
                    <input type="hidden" name="comment_level"  id="comment_level" value="'.$comment_level .'"> 
                  <div class="form-group">
                    <label for="author_name">Author Name</label>
                    <input required type="text" class="form-control" name="author_name" id="author_name" aria-describedby="authorHelp" placeholder="Author Name">
                    <small id="authorHelp" class="form-text text-muted">Please type your name here.</small>
                  </div>                
                  <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea required class="form-control" name="comment" id="comment" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary" data-parent-comment="'.$parent_id.'">Submit</button>
                </form>';
    }
}