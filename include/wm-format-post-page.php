<?php
/**
*
*/
if( !function_exists( 'wm_format_comments' ) ){

    function wm_format_comments( $post_id, $page, $per_page ){

        require( 'kint.phar' );

        $page--;

        /** Create a new WP_Comment_Query and get the comments for this post. */
        $comments_query = new WP_Comment_Query;

        /** Grab the first page of comments. */
        $args = array(
            'hierarchical' => 'threaded',
            'number' => $per_page,
            'offset' => $page * $per_page,
            'post_id' => $post_id,
            'status' => 'all'
        );
        $comments = $comments_query->query( $args );

        // Number = how many top level comments to return.
        // Offset = how many records to skip before grabing the next number.


        Kint::dump( $count );
        Kint::dump( $comments );


        /** Build up the HTML to display in the page. */
        $html = '';

        /** Loop through all the comments; AKA Comment Loop. */
        if ( !empty( $comments ) ) {
            /** Is the current user an admin? */
            $user = wp_get_current_user();
            $admin = false;
            if( array_intersect( array('editor', 'administrator'), $user->roles ) ){
                $admin = true;
            }
            /** Loop through each top level comment we found. */
            foreach ( $comments as $comment ) {
                /**
                * Recursively build the Post's comments by working from top level
                * comments down through their children (replies).
                *
                * NOTE: The WP_Comment object has the `children` property protected
                * so we have to call to_array() on each WP_Comment in order to work
                * with any children. Well I would prefer it was not protected this
                * is a simple workaround instead of having to extend the
                * WP_Comment_Query and WP_Comment classes to add a getter.
                */
                $html .= wm_get_comment_html( $comment->to_array(), 0, $admin, wm_get_user_ip() );
            }
        } else {
            /** No comments were found. */
            $html .= 'No comments found.';
        }

        /** Return the HTML we built. */
        return $html;
    }
}

if( !function_exists( 'wm_get_comment_html' ) ){

    function wm_get_comment_html( $comment, $level, $admin, $ip ){

        /** The HTML template for each comment or reply. */
        if( $admin ){
            /** Use the admin template. */
            $html = '<div class="{{comment-class}}" id="{{comment-anchor-id}}"><div class="wm-comment-header"><span class="wm-comment-author">{{comment-author}}</span><span class="wm-comment-date">{{comment-date}} at {{comment-time}}</span></div><div class="wm-comment-content">{{comment-moderation-notice}}{{comment-content}}</div><div class="wm-comment-footer">{{comment-moderation}}<a href="{{comment-edit-url}}" target="_blank" class="wm-control-btns"><i class="fas fa-edit"></i> Edit</a>{{reply-button}}</div></div>';
        } else {
            /** Use the normal user template. */
            $html = '<div class="{{comment-class}}" id="{{comment-anchor-id}}"><div class="wm-comment-header"><span class="wm-comment-author">{{comment-author}}</span><span class="wm-comment-date">{{comment-date}} at {{comment-time}}</span></div><div class="wm-comment-content">{{comment-moderation-notice}}{{comment-content}}</div><div class="wm-comment-footer">{{reply-button}}</div></div>';
        }

        /** Determine if the comment under moderation notice should been shown on this comment. */
        $show_moderation_notice = false;
        if ( $comment['comment_approved'] < 1 ){
            /** Yes. Is the current user a guest user? */
            if ( get_current_user_id() == 0 ){
                /** Does the comments IP address match the current users? */
                if ( $comment['comment_author_IP'] == $ip ){
                    $show_moderation_notice = true;
                }
            }
            /** Yes. Is the current user the same user as this comment? */
            if ( $comment['user_id'] == get_current_user_id() ){
                $show_moderation_notice = true;
            }
        }

        /** Build the moderation notice if we need it. */
        $moderation_notice = '';
        if( $show_moderation_notice ){
            $moderation_notice = '<div class="wm-comment-moderation-notice"><i class="fas fa-exclamation-triangle"></i> This comment is pending moderator approval.</div>';
        }

        /** Do not show a reply button on pending comments. */
        $reply_button = '';
        if ( $comment['comment_approved'] > 0 ){
            $reply_button = ' <a href="" class="wm-control-btns"><i class="fas fa-reply"></i> Reply</a>';
        }

        /** Build the CSS class needed for this comment or reply. */
        if( $level > 0 ){
            $class = 'wm-comment-wrapper wm-comment-reply wm-comment-reply-level-' . $level;
        } else {
            $class = 'wm-comment-wrapper';
        }

        /** Do we need to add the comment under moderation CSS class? */
        if( $comment['comment_approved'] < 1 ){
            /** Yes. */
            $class .= ' wm-comment-moderation';
        }

        /** Do we need to add the trackback or pingback class? */
        // TODO: FIX THIS. JUST PUT THEM IN THEIR OWN LIST.
        switch( $comment['comment_type'] ){
            case 'trackback':
                $class .= ' wm-comment-trackback';
                break;
            case 'pingback':
                $class .= ' wm-comment-pingback';
                break;
        }

        /** Is this a pending comment and is the current user an admin? */
        $comment_moderation = '';
        if( $comment['comment_approved'] < 1 && $admin ){
            /** Yes. Add the comment moderation buttons. */
            // TODO: ACTUALLY MAKE THIS WORK
            // wp_nonce_url( admin_url( 'comment.php?c=' . $comment['comment_ID'] . '&action=approvecomment' ) ) ???
            $comment_moderation = '<a href="" target="_blank" class="wm-control-btns"><i class="fas fa-trash-alt"></i> Trash</a> <a href="" target="_blank" class="wm-control-btns"><i class="fas fa-flag"></i> Spam</a> <a href="" target="_blank" class="wm-control-btns"><i class="fas fa-check"></i> Approve</a>';
        }

        /** Build a replacment array to replace the HTML template placeholders. */
        $replacements = array(
            'comment-anchor-id' => 'comment-' . $comment['comment_ID'],
            'comment-author' => $comment['comment_author'],
            'comment-class' => $class,
            'comment-content' => preg_replace( '/\r\n|\n/', '<br>', trim( $comment['comment_content'] ) ),
            'comment-date' => date( get_option( 'date_format' ), strtotime( $comment['comment_date'] ) ),
            'comment-edit-url' => admin_url( 'comment.php?action=editcomment&c=' .  $comment['comment_ID'] ),
            'comment-moderation-notice' => $moderation_notice,
            'comment-moderation' => $comment_moderation,
            'comment-time' => date( get_option( 'time_format' ), strtotime( $comment['comment_date'] ) ),
            'reply-button' => $reply_button
        );

        /**
        * Only show this comment based on the following checks:
        *   - The comment is approved
        *   - or its unapproved but belongs to the current user
        *   - or the current user is an Admin.
        */
        if( $comment['comment_approved'] > 0 || $show_moderation_notice || $admin ){
            /** Replace the HTML template placeholders. */
            foreach( $replacements as $key => $value ){
                $html = str_replace( '{{' . $key . '}}', $value, $html );
            }
        } else {
            /** If the checks failed dont show this comment. */
            $html = '';
        }

        /** Does this comment have children (replies)? */
        if( !empty( $comment['children'] ) ){
            /** Yes. Loop through them too. */
            foreach ( $comment['children'] as $child ) {
                /**
                * Recursive call to find more children.
                *
                * NOTE: The WP_Comment object has the `children` property protected
                * so we have to call to_array() on each WP_Comment in order to work
                * with any children. Well I would prefer it was not protected this
                * is a simple workaround instead of having to extend the
                * WP_Comment_Query and WP_Comment classes to add a getter.
                */
                $html .= wm_get_comment_html( $child->to_array(), $level + 1, $admin, $ip );
            }
        }

        /** Done with this loop. */
        return $html;
    }
}

if( !function_exists( 'wm_format_comment_form' ) ){

    function wm_format_comment_form(){

        /** Capture the default Word Press form. */
        ob_start();
        comment_form();
        $form = ob_get_clean();

        /** Remove submit button HTML and replace with plain button HTML. */
        $form = str_replace( 'type="submit"', 'type="button"', $form );

        /** Add the .wm-control-btns class to the submit button. */
        $form = str_replace( 'class="submit"', 'class="submit wm-control-btns"', $form );

        /** Display the form. */
        return $form;
    }
}
