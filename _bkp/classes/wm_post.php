<?php
if ( !class_exists( 'WM_posts' ) ){

    /**
    * Responsible for post pages
    */
	class WM_posts {

        private $_aacp = false;
        private $_admin = false;

        public function __construct () {

            /** Is the active user an Admin or Editor? */
            $user = wp_get_current_user();
            if( array_intersect( array('editor', 'administrator'), $user->roles ) ){
                $_admin = true;
            }

            /** */
            add_action( 'wp_ajax_wm_comment_pagination', 'wm_comment_pagination' );
            add_action( 'wp_ajax_nopriv_wm_comment_pagination', 'wm_comment_pagination' );

            /** Check if the Wiki Modern Authors and Contributors plugin is active. */
        }

        /**
        * Gathers all top level comments and starts the comment loop {@see WM_posts::format_post_comments_loop}
        * which will generate the HTML for all comments and replies to this post.
        *
        * @param    int    $post_id    What is the ID of post to get comments for.
        * @param    int    $page       What page of comments, if any, should be loaded. Default 1.
        * @param    int    $per_page   How many comments to show per page. Default 50.
        * @param    string $sort       How to sort the comments ASC (oldest) or DESC (newest). Default DESC.
        * @return   string The HTML for all comments and replies for this post or a simple message if none were found.
        */
        private function format_post_comments( $post_id, $sort, $per_page, $page ){

            /** Page is used for offset math so go down by 1. */
            $page--;

            /** Create a new WP_Comment_Query and get the comments for this post. */
            $comments_query = new WP_Comment_Query;

            /** Grab the first page of comments. */
            $args = array(
                'hierarchical' => 'threaded',
                'number' => $per_page,
                'offset' => $page * $per_page,
                'order' => $sort,
                'post_id' => $post_id,
                'status' => 'all'
            );
            $comments = $comments_query->query( $args );

            // 'order' => 'ASC',
            // Number = how many top level comments to return.
            // Offset = how many records to skip before grabing the next number.

            /** Build up the HTML to display in the page. */
            $html = '';

            /** Loop through all the comments; AKA The Comment Loop. */
            if ( !empty( $comments ) ) {

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
                    $html .= $this->format_post_comments_loop( $comment->to_array(), 0, $this->_admin, wm_get_user_ip() );
                }
            } else {
                /** No comments were found. */
                $html .= 'No comments found.';
            }

            /** Return the HTML we built. */
            return $html;
        }

        /**
        * Recursive loop that builds the HTML structure for comments and replies
        * to a post. Admin users will see moderator controls in comments and users
        * who posted a pending comment will see the waiting for moderation notice.
        *
        * @param    array  $comment    Array containing all the information of the current comment or reply.
        * @param    int    $level      Nested level number. Top level comments (parents) are level 0 for example.
        * @param    bool   $admin      True if the active user is an admin.
        * @param    string $ip         The current users ip address.
        * @return   string The HTML for the current comment or reply to add to the final HTML output.
        */
        private function format_post_comments_loop( $comment, $level, $admin, $ip ){

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

            /**
            * Only show this comment based on the following checks:
            *   - The comment is approved
            *   - or its unapproved but belongs to the current user
            *   - or the current user is an Admin.
            */
            if( $comment['comment_approved'] > 0 || $show_moderation_notice || $admin ){

                /** The HTML template for each comment or reply. */
                if( $admin ){
                    /** Use the admin template. */
                    $html = '<div class="{{comment-class}}" id="{{comment-anchor-id}}"><div class="wm-comment-header"><span class="wm-comment-author">{{comment-author}}</span><span class="wm-comment-date">{{comment-date}} at {{comment-time}}</span></div><div class="wm-comment-content">{{comment-moderation-notice}}{{comment-content}}</div><div class="wm-comment-footer">{{comment-moderation}}<a href="{{comment-edit-url}}" target="_blank" class="wm-control-btns"><i class="fas fa-edit"></i> Edit</a>{{reply-button}}</div></div>';
                } else {
                    /** Use the normal user template. */
                    $html = '<div class="{{comment-class}}" id="{{comment-anchor-id}}"><div class="wm-comment-header"><span class="wm-comment-author">{{comment-author}}</span><span class="wm-comment-date">{{comment-date}} at {{comment-time}}</span></div><div class="wm-comment-content">{{comment-moderation-notice}}{{comment-content}}</div><div class="wm-comment-footer">{{reply-button}}</div></div>';
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
                // [TODO][BP20F4838] FIX THIS. JUST PUT THEM IN THEIR OWN LIST.
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
                    // [TODO][BP20F4839] ACTUALLY MAKE THIS WORK.
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

                /** Replace the HTML template placeholders. */
                foreach( $replacements as $key => $value ){
                    $html = str_replace( '{{' . $key . '}}', $value, $html );
                }

            } else {
                /** If the checks failed dont show this comment. */
                $html = '';
            }

            /** Does this comment have children (replies) and is it's parent approved? */
            if( !empty( $comment['children'] ) && $comment['comment_approved'] > 0 ){
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
                    $html .= $this->format_post_comments_loop( $child->to_array(), $level + 1, $admin, $ip );
                }
            }

            /** Done with this loop. */
            return $html;
        }

        /**
        * Return the HTML for the Authors and Contributors sections. This will default
        * to just showing the post author but will check if there is a plugin that
        * allows Authors, Co-Authors, and Contributors. If a plugin is found that
        * supports this that information will be shown instead.
        *
        * @return   string  The HTML for the Author section or the HTML for the uthors, Co-Authors, and Contributors sections.
        */
        public function get_html_authors() {

            $html = '<tr class="wm-widget-sub-title"><td>{{author-title}}:</td></tr>';

            /**
            * Display the authors section using Wiki Modern Authors and Contributors plugin
            * data or default to the standard WordPress Post author.
            */
            if( $this->_aacp ){
                // [TODO][BP20F4840] Make the plugin and remove this! The proper way should be to overide this function.
                /** Gather all authors. */

                /** Gather all co-authors. */

                /** Gather all contributors. */
            } else {
                /** Use default WordPress Post author. */
                $post = get_post();
                $author = get_the_author_meta( 'display_name', $post->post_author );
                $html .= '<tr class="wm-widget-info"><td>' . $author . '</td></tr>';
                /** Replace the author title to be singular. */
                $html = str_replace( '{{author-title}}', 'Author', $html );
            }

            return $html;
        }

        public function get_html_meta_authors(){
            $post = get_post();
            $author = get_the_author_meta( 'display_name', $post->post_author );
            return '<div><span class="wm-title">Author:</span> ' . $author . '</div>';
        }

        /**
        * Return the HTML for the Categories section.
        *
        * @return   string  The HTML for the categories section with all categories shown in a comma seperated list.
        */
        public function get_html_categories(){

            $html = '<tr class="wm-widget-sub-title"><td>{{categories-title}}:</td></tr><tr class="wm-widget-info"><td>';

            $categories = get_the_category();
            $output = '';
            foreach( $categories as $category ){
                $id = get_cat_ID( $category->name );
                $url =  get_category_link( $id );
                $output .= '<span class="wm-tags"><a href="' . $url . '">' . $category->name . '</a></span>, ';
            }

            if( count( $categories ) > 1 ){
                /** Replace the categories title to be plural. */
                $html = str_replace( '{{categories-title}}', 'Categories', $html );
            } else {
                /** Replace the categories title to be singular. */
                $html = str_replace( '{{categories-title}}', 'Category', $html );
            }

            /** Remove the extra comma and space from the loop and close the HTML. */
            $html .= substr( $output, 0, strlen( $output ) - 2 ) . '</td></tr>';
            return $html;
        }

        /**
        * Start the process of loading and building the HTML for this posts comments.
        * After checking the post is unlocked and gathering needed information this
        * will call {@see WP_post_page::format_post_comments} which in turn will call
        * {@see WP_post_page::format_post_comments_loop} to build the needed HTML.
        *
        * @return   string The HTML for all comments and replies, a simple message if none were found, or a message if this is a locked post.
        */
        public function get_comments( $post_id = null, $sort = null, $per_page = null, $page = null ){

            /** If we were not given a post ID see if we can find it. */
            if( empty($post_id) ){
                global $post;
                if ( $post ){
                    $post_id = $post->ID;
                } else {
                    /** Return empty now, this was called in a bad context and we can't find a post ID. */
                    return '';
                }
            }

            /**
            * Don't show anything if post is password protected and not unlocked.
            *
            * NOTE: The post page should have already been blocked from loading
            * this is just a fail safe in case someone is trying to bypass theme
            * block.
            */
            $html = '';
            if( !post_password_required( $post_id ) ){

                /** How many top level comments are there? */
                $comments_query = new WP_Comment_Query;
                if( $this->_admin ){
                    $args = array(
                        'count' => true,
                        'parent' => 0,
                        'post_id' => $post_id,
                        'status' => 'all'
                    );
                } else {
                    $args = array(
                        'count' => true,
                        'parent' => 0,
                        'post_id' => $post_id,
                        'status' => 1
                    );
                }
                $count = $comments_query->query( $args );

                /** Is there comments to show? */
                if ( $count > 0 ){
                    /** Yes. */

                    // [TODO][BP20F4841] Make cookies to store this in and check from.

                    /** Validate $sort. */
                    switch( $sort ){
                        case 'ASC':
                        case 'asc':
                            $sort = 'ASC';
                            break;
                        case 'DESC':
                        case 'desc':
                        default:
                            $sort = 'DESC';
                            break;
                    }

                    /** Validate $per_page. */
                    if( !is_int( $per_page + 0 ) || $per_page < 50 || $per_page > 150 ){
                        $per_page = 50;
                    }

                    /** Validate $page_number. */
                    if( !is_int( $page + 0 ) ){
                        $page = 1;
                    }

                    $html .= $this->format_post_comments( $post->ID, $sort, $per_page, $page );

                } else {
                    /** No. Show no comments message. */
                    $html = '<p>There are no comments for this post.</p>';
                }
            }
            return $html;
        }

        /**
        * Captures the default WordPress comment form and alters its HTML
        * for use by Wiki Modern.
        *
        * @return   string  The modified HTML for the WordPress comment form.
        */
        public function get_comment_form(){

            /** Capture the default Word Press form. */
            ob_start();
            comment_form();
            $form = ob_get_clean();

            /** Replace the forms ID and Class. */
            $form = str_replace( 'id="respond"', 'id="wm-respond"', $form );
            $form = str_replace( 'class="comment-respond"', 'class="wm-comment-respond"', $form );

            /** Remove submit button HTML and replace with plain button HTML. */
            $form = str_replace( 'type="submit"', 'type="button"', $form );

            /** Add the .wm-control-btns class to the submit button. */
            $form = str_replace( 'class="submit"', 'class="submit wm-control-btns"', $form );

            /** Display the form. */
            return $form;
        }

        /**
        * Build the pagination for post comments.
        *
        * TODO: Add params
        *
        * @return   array  The HTML for the comment pagination controls, index 0 is for the top of the page and index 1 is for the bottom.
        */
        public function get_comment_pagination( $post_id = null, $sort = null, $per_page = null, $page = null ){

            /** If we were not given a post ID see if we can find it. */
            if( empty($post_id) ){
                global $post;
                if ( $post ){
                    $post_id = $post->ID;
                } else {
                    /** Return empty now, this was called in a bad context and we can't find a post ID. */
                    return '';
                }
            }

            /** Validate $sort. */
            switch( $sort ){
                case 'ASC':
                case 'asc':
                    $sort = 'ASC';
                    break;
                case 'DESC':
                case 'desc':
                default:
                    $sort = 'DESC';
                    break;
            }

            /** Validate $per_page. */
            if( !is_int( $per_page + 0 ) || $per_page < 50 || $per_page > 150 ){
                $per_page = 50;
            }

            /** Validate $page_number. */
            if( !is_int( $page + 0 ) ){
                $page = 1;
            }

            /** How many top level comments are there? */
            $comments_query = new WP_Comment_Query;
            if( $this->_admin ){
                $args = array(
                    'count' => true,
                    'parent' => 0,
                    'post_id' => $post_id,
                    'status' => 'all'
                );
            } else {
                $args = array(
                    'count' => true,
                    'parent' => 0,
                    'post_id' => $post_id,
                    'status' => 1
                );
            }
            $count = $comments_query->query( $args );

            /** Is there comments to show? */
            if( $count > 0 ){

                /** Yes. Build the pagination HTML. */
                $html = array();

                /** How many pages do we need? */
                $pages = ceil( $count / $per_page );

                /** The pagenation HTML templates. */
                $html[0] = '<div class="wm-pagination">Showing <select id="wm-pagination-comment">{{comment-options}}</select> comments per page. <select id="wm-pagination-sort">{{sort-options}}</select> comments are shown first and this is page <select id="wm-pagination-page">{{page-options}}</select> of {{page-count}}.</div>';
                $html[1] = '<div class="wm-pagination">Showing <select id="wm-pagination-comment-bottom">{{comment-options}}</select> comments per page. <select id="wm-pagination-sort-bottom">{{sort-options}}</select> comments are shown first and this is page <select id="wm-pagination-page-bottom">{{page-options}}</select> of {{page-count}}.</div>';

                /** Replace the various template parts with their actual values. */
                $html[0] = str_replace( '{{page-count}}', $pages, $html[0] );
                $html[1] = str_replace( '{{page-count}}', $pages, $html[1] );
                $replacement = '';

                /** Display X comments per page. */
                for( $x = 0; $x < 5; $x++ ){
                    $count = 50 + $x * 25;
                    if( $count == $per_page ){
                        $replacement .= '<option value="' . $count . '" selected="">' . $count . '</option>';
                    } else {
                        $replacement .= '<option value="' . $count . '">' . $count . '</option>';
                    }
                }
                $html[0] = str_replace( '{{comment-options}}', $replacement, $html[0] );
                $html[1] = str_replace( '{{comment-options}}', $replacement, $html[1] );
                $replacement = '';

                /** Page options. */
                for( $x = 1; $x <= $pages; $x++ ){
                    if( $x > $page ){
                        $replacement .= '<option value="' . $x . '">' . $x .'</option>';
                    } else {
                        $replacement .= '<option value="' . $x . '" selected="">' . $x .'</option>';
                    }
                }
                $html[0] = str_replace( '{{page-options}}', $replacement, $html[0] );
                $html[1] = str_replace( '{{page-options}}', $replacement, $html[1] );
                $replacement = '';

                /** Sort options. */
                switch( $sort ){
                    case 'DESC':
                        $replacement = '<option value="DESC" selected>Newest</option><option value="ASC">Oldest</option>';
                        break;
                    default:
                        $replacement = '<option value="DESC">Newest</option><option value="ASC" selected="">Oldest</option>';
                        break;
                }

                $html[0] = str_replace( '{{sort-options}}', $replacement, $html[0] );
                $html[1] = str_replace( '{{sort-options}}', $replacement, $html[1] );

            } else {
                /** No. Don't show any pagination. */
                $html = array( '', '' );
            }

            return $html;
        }

        public function get_content( $post_id = null ){

            if( empty( $post_id ) ){
                global $post;
            } else {
                $post = the_post( $post_id );
            }

            if ( $post ){

                if( !post_password_required( $post->ID ) ){
                    return apply_filters( 'the_content', $post->post_content );
                } else {
                    return get_the_password_form( $post->ID );
                }
            }

            return '';
        }

        /**
        * Return the HTML for the Publised Date and Last Updated section.
        *
        * @return   string  The HTML for the Publised Date and Last Updated section formated according to the sites settings.
        */
        public function get_html_dates(){

            $html = '<tr class="wm-widget-sub-title"><td>Published:</td></tr><tr class="wm-widget-info"><td>';
            $html .= get_the_date() . '</td></tr>';

            if( strtotime( get_the_date() ) < strtotime( get_the_modified_date() ) ){
                $html .= '<tr class="wm-widget-sub-title"><td>Last Updated:</td></tr><tr class="wm-widget-info"><td>';
                $html .= get_the_modified_date() . '</td></tr>';
            }

            return $html;
        }

        /**
        * Return an array with the original and updated dates for this post.
        *
        * @return   array The original and updated dates for this post.
        */
        public function get_raw_dates(){
            if( strtotime( get_the_date() ) < strtotime( get_the_modified_date() ) ){
                return [ get_the_date(), get_the_modified_date() ];
            } else {
                return [ get_the_date(), '' ];
            }
        }

        /**
        * Return the HTML for the Tags section.
        *
        * @return   string  The HTML for the Tags section with all tags shown in a comma seperated list.
        */
        public function get_html_tags(){

            $html = '<tr class="wm-widget-sub-title"><td>{{tag-title}}:</td></tr><tr class="wm-widget-info"><td>';

            $tags = get_the_tags();

            if( $tags ){
                $output = '';
                foreach( $tags as $tag ){
                    $url = get_tag_link( $tag->term_id );
                    $output .= '<span class="wm-tags"><a href="' . $url . '">' . $tag->name . '</a></span>, ';
                }
                $html .= substr( $output, 0, strlen( $output ) - 2 ) . '</td></tr>';
                if( count( $tags ) > 1 ){
                    /** Replace the author title to be plural. */
                    $html = str_replace( '{{tag-title}}', 'Tags', $html );
                } else {
                    /** Replace the author title to be singular. */
                    $html = str_replace( '{{tag-title}}', 'Tag', $html );
                }
                return $html;
            }
            /** There was no tags found hide the whole Tag section. */
            return '';
        }

        /**
        * Return the HTML for the post's title.
        *
        * @return   string  The HTML for the post's title.
        */
        public function get_html_title( $post_id = null ){

            /** If we were not given a post ID see if we can find it. */
            if( empty($post_id) ){
                global $post;
                if ( $post ){
                    $post_id = $post->ID;
                } else {
                    /** Return empty now, this was called in a bad context and we can't find a post ID. */
                    return '';
                }
            }

            return '<h1>' . apply_filters( 'the_title', $post->post_title ) . '</h1>';
        }

        /*public function get_posts(){

            // https://developer.wordpress.org/reference/functions/get_posts/
            // https://developer.wordpress.org/reference/classes/wp_post/
            // https://codex.wordpress.org/Class_Reference/WP_Query#Status_Parameters

            $post_limit = 20;
            $html = '';

            // Load and build the correct post HTML.
            // {{post-title}}
            // {{post-author}}
            // {{post-date}}
            // {{post-update}}
            // {{post-summary}}
            $template = '<article class="wm-post-block"><div class="wm-post-title">{{post-title}}</div><div class="wm-post-meta"><span class="wm-post-meta-author">{{post-author}}</span><span class="wm-post-meta-date">{{post-date}}</span><span class="wm-post-meta-update">{{post-update}}</span></div><div class="wm-post-image">{{post-image}}</div><div class="wm-post-summary">{{post-summary}}</div></article>';

            // Get all Sticky Posts if any, sort them newest to oldest, and only return up to our limit.
            $sticky_posts = get_option( 'sticky_posts' );
            rsort( $sticky_posts );
            $sticky_posts = array_slice( $sticky_posts, 0, $post_limit );
            $sticky_posts = new WP_Query( array( 'post__in' => $sticky_posts, 'ignore_sticky_posts' => 1 ) );
            $sticky_posts_ID = array();

            // Are there sticky posts?
            if( $sticky_posts->post_count > 0 ){

                // Yes. Get all the WP_post objects for these sticky posts.
                $sticky_posts = $sticky_posts->posts;

                /** Loop through and build each post.
                foreach( $sticky_posts as $sticky ){

                    /** If this sticky post is published show it.
                    if( $sticky->post_status == 'publish' ){
                        $post_limit--;
                        $sticky_posts_ID[] = $sticky->ID;
                        $html .= $this->format_posts_loop( $sticky, $template );
                    }
                }
            }

            /** Do we still need more posts to hit our display limit?
            if( $post_limit > 0 ){

                /** Show only published post if the user is not an admin.
                if( $this->_admin ){
                    $args = array(
                        'numberposts' => $post_limit + count( $sticky_posts_ID ),
                        'post_status' => array( 'publish', 'private' )
                    );
                } else {
                    $args = array(
                        'numberposts' => $post_limit + count( $sticky_posts_ID ),
                        'post_status' => array( 'publish' )
                    );
                }
                $latest_posts = get_posts( $args );

                /** Loop through each post found.
                foreach( $latest_posts as $post ){

                    /** If we've reached our limit stop.
                    if( $post_limit < 1 ){ break; }

                    /** Skip this post if it was a sticky post already shown.
                    if( !in_array( $post->ID, $sticky_posts_ID ) ){
                        $post_limit--;
                        $html .= $this->format_posts_loop( $post, $template );
                    }
                }
            }

            // Return the HTML for the posts.
            return $html;
        }*/

    /** End Class. */
    }
/** End check for class. */
}
