<?php
/**
* Remove elements from an HTML string by their tag name.
*
* @author Christopher Keers <source@caboodle.tech>
* @param string $html A string of HTML code representing all or part of document.
* @param string|array $tags A string or array of the HTML tags you want removed.
*   NOTE: You can pass in `comment` or `comments` to also remove HTML comments.
* @return string The cleaned HTML string.
*/
function trim_html_tags( $html, $tags ){

    /** Don't run if there is no HTML. */
    if( empty( $html ) ){
        return '';
    }

    /** Does DOMDocument exists on this server? */
    if( in_array( 'DOMDocument', get_declared_classes() ) ){
        /** Yes. Parse the HTML properly. */

        /** If we do not have an array of tags make an array with the tag we have. */
        if( !is_array( $tags ) ){
            $tags = array( $tags );
        }

        /**
        * Parse the HTML into a DOM like object. DOMDocument will throw
        * warnings if it encounters HTML5 tags so just ignore them.
        */
        $dom = new DOMDocument();
        @$dom->loadHTML( '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $html . '</body></html>' );

        /** Remove each requested tag. */
        foreach( $tags as $tag ){

            /** Find all occurances of the current tag we're looking for. */
            $nodes = $dom->getElementsByTagName( $tag );

            /** Remove the tags we found. */
            if( $nodes->length > 0 ){

                /**
                * We must remove in reverse order because $nodes is a dynamic list
                * that updates after evert removal!
                */
                for( $x = $nodes->length-1; $x > -1; $x--){
                    $nodes->item($x)->parentNode->removeChild( $nodes->item($x) );
                }
            }
        }

        /** Get the cleaned HTML. */
        $html = $dom->saveHTML( $dom->documentElement );
        //$html = utf8_decode( $dom->saveHTML( $dom->documentElement ) );

        /** Should we remove comments as well? */
        $comment_tags = array( 'comment', 'COMMENT', 'COMMENTS', 'comments', '<!', '<!>', '<!-', '<!---->');
        if( array_intersect( $tags, $comment_tags ) ){
            /** Yes. Remove all HTML comments. */
            $html = preg_replace( '/<!--([^>]+)>/i', '', $html );
        }

        /** Remove HTML and BODY tags that were added. */
        $remove = array(
            '<html>',
            '</html>',
            '<head>',
            '</head>',
            '<body>',
            '</body>',
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'
        );
        $html = str_ireplace( $remove, '', $html);

        /** Remove any empty P tags. */
        $html = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $html);

    } else {
        /** No. Use regex and send back something useful. */
        $html = '';
        // TODO: ADD THIS FEATURE
    }

    /** Send back the cleaned HTML. */
    return $html;
}
