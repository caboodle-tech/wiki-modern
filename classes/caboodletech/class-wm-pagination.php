<?php
/**
 * Handles building the HTML for the current pages pagination.
 * 
 * @package Wiki Modern Theme
 */

namespace Caboodletech;

/**
 * Responsible for pagination.
 */
class WM_Pagination {

    // Required variables for WM_Pagination.
    private $current_page = 1;
    private $links        = null;
    private $max_page     = 1;
    private $post_count   = 0;
    private $post_found   = 0;
    private $ready        = false;
    private $sort_by      = null;

    /**
     * WM_Pagination construct.
     */
    public function __construct() {
        // Make sure we have the information we need.
        $this->get_ready();
    }

    /**
     * Builds the HTML that comprises the pages pagination.
     *
     * @param string $position Lowercase string of the pagination position on the page.
     */
    private function get_html( $position ) {

        // Do not make a bottom control for a single page of results.
        if ( $this->max_page === 1 && $position === 'bottom' ) {
            return '';
        }

        // Set the $reverse flag.
        $reverse = false;
        if ( $position === 'bottom' ) {
            $reverse = true;
        }

        // Build the pages pagination by replacing template parts with their values.
        $html = $this->pagination_template();
        $html = str_replace( '{{location}}', $position, $html );
        $html = str_replace( '{{current-page}}', $this->current_page, $html );
        $html = str_replace( '{{current-page-options}}', $this->get_page_ops( $reverse ), $html );
        $html = str_replace( '{{max-page}}', $this->max_page, $html );
        $html = str_replace( '{{sort}}', ucwords( $this->sort_by ), $html );
        $html = str_replace( '{{sort-options}}', $this->get_result_ops( $reverse ), $html );
        $html = str_replace( '{{limit}}', $this->post_count, $html );
        $html = str_replace( '{{limit-options}}', $this->get_limit_ops( $reverse ), $html );
        return $html;
    }

    /**
     * Builds the HTML for how many posts to show per page.
     *
     * @param bool $reverse A flag that tells us the HTML is for the top (true) or bottom (false) of the page.
     */
    private function get_limit_ops( $reverse ) {

        $html = '';

        // Add the available options.
        // NOTE: We do not show the current setting in the list of selectable options.
        if ( $reverse ) {
            for ( $x = 50; $x > 0; $x -= 10 ) {
                if ( $x !== $this->post_count ) {
                    $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                }
            }
        } else {
            for ( $x = 10; $x < 60; $x += 10 ) {
                if ( $x !== $this->post_count ) {
                    $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                }
            }
        }

        return $html;
    }

    /**
     * Builds the HTML for changing the page the user is on.
     *
     * @param bool $reverse A flag that tells us the HTML is for the top (true) or bottom (false) of the page.
     */
    private function get_page_ops( $reverse ) {

        $html = '';

        // Is there 10 pages of post or less?
        if ( $this->max_page > 10 ) {

            // No. Only show the next and previous 5 pages the user can jump to
            if ( $reverse ) {

                $min = $this->current_page - 6;
                if ( $min < 1 ) {
                    $min = 1;
                }

                $max = $this->current_page + 5;
                if ( $max > $this->max_page ) {
                    $max = $this->max_page;
                }

                // NOTE: We do not show the current page in the list of selectable options
                for ( $x = $max; $x > $min; $x-- ) {
                    if ( $x !== $this->current_page ) {
                        if ( isset( $this->links[ $x - 1 ] ) ) {
                            $html .= '<li data-wm-link="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                        } else {
                            $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                        }
                    }
                }

                // Stop bug where page 1 is not shown when current page is to close to 0
                if ( $x === 1 ) {
                    $html .= '<li data-wm-value="1">1</li>';
                }
            } else {

                $min = $this->current_page - 5;
                if ( $min < 1 ) {
                    $min = 1;
                }

                $max = $this->current_page + 6;
                if ( $max > $this->max_page ) {
                    $max = $this->max_page;
                }

                // NOTE: We do not show the current page in the list of selectable options
                for ( $x = $min; $x < $max; $x++ ) {
                    if ( $x !== $this->current_page ) {
                        if ( isset( $this->links[ $x - 1 ] ) ) {
                            $html .= '<li data-wm-link="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                        } else {
                            $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                        }
                    }
                }
            }
        } else {

            // Yes. Show all the available pages the user can jump to
            if ( $reverse ) {
                for ( $x = $this->max_page; $x > 0; $x-- ) {
                    if ( $x !== $this->current_page ) {
                        if ( isset( $this->links[ $x - 1 ] ) ) {
                            $html .= '<li data-wm-link="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                        } else {
                            $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                        }
                    }
                }
            } else {
                for ( $x = 1; $x <= $this->max_page; $x++ ) {
                    if ( $x !== $this->current_page ) {
                        if ( isset( $this->links[ $x - 1 ] ) ) {
                            $html .= '<li data-wm-link="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                        } else {
                            $html .= '<li data-wm-value="' . $x . '">' . $x . '</li>';
                        }
                    }
                }
            }
        }

        return $html;
    }

    /**
     * Finds and records values WM_Pagination needs to work.
     */
    private function get_ready() {

        // We need access to the wm_query.
        global $wp_query;

        // Get the next and previous 5 page links based on the current settings (search).
        $links = paginate_links(
            array( 
                'type'      => 'array',
                'prev_next' => false,
                'show_all'  => false,
                'mid_size'  => 5,
            )
        );

        if ( isset( $links ) ) {

            foreach ( $links as $key => $value ) {

                // Is this actually a link or the current page HTML?
                if ( strpos( $value, '</a>' ) !== false ) {

                    // Try to pull a URL out
                    preg_match( '/href=(["\'])([^\1]*)\1/i', $value, $matches );
                    if ( isset( $matches[2] ) ) {
                        // Found a link, save it
                        $links[ $key ] = $matches[2];
                        // Restart loop so we don't NULL this index out.
                        continue;
                    }
                }

                // Anything not actually a link should be ignored.
                $links[ $key ] = null;
            }
            unset( $value );

            // Update the class value.
            $this->links = $links;
        }

        // Record the current page number the user is on,
        $current_page = $wp_query->query_vars['paged'];
        if ( $current_page < 1 ) {
            $current_page = 1;
        }
        $this->current_page = $current_page;

        // Record the highest possible page number,
        $max_page = $wp_query->max_num_pages;
        if ( $max_page < 1 ) {
            $max_page = 1;
        }
        $this->max_page = $max_page;

        // Record how many post will display on this page,
        $this->post_count = $wp_query->post_count;

        // Record how many total post were found with the current settings (search),
        $this->post_found = $wp_query->found_posts;

        // Record how the results are sorted,
        $this->sort_by = '';
        if ( isset( $_COOKIE['wm-pagination-sort'] ) ) {
            $this->sort_by = sanitize_meta( 'wm_cookie', wp_unslash( $_COOKIE['wm-pagination-sort'] ), 'json' );
        }
        if ( empty( $this->sort_by ) ) {
            $this->sort_by = 'newest';
        }

        // WM_Pagination is now ready to be used.
        $this->ready = true;
    }

    /**
     * Builds the HTML for how many post match the search and how they are sorted.
     */
    private function get_result_ops() {

        $html = '';

        // Add the correct options based on how the results were sorted
        if ( $this->sort_by === 'newest' ) {
            $html .= '<li data-wm-value="oldest">Oldest</li>';
        } else {
            $html .= '<li data-wm-value="newest">Newest</li>';
        }

        return $html;
    }

    /**
     * Echo out the HTML for the bottom pagination
     */
    public function get_bottom() {
        return $this->get_html( 'bottom' );
    }

    /**
     * Echo out the HTML for the top pagination
     */
    public function get_top() {
        return $this->get_html( 'top' );
    }

    /**
     * The pagination template for the Wiki Modern theme.
     */
    private function pagination_template() {
return <<<HTML
<div class="wm-pagination" id="wm-{{location}}-pagination">
<div class="wm-page">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.744 8s1.522-8-3.335-8h-8.409v24h20v-13c0-3.419-5.247-3.745-8.256-3zm.256 11h-8v-1h8v1zm4-3h-12v-1h12v1zm0-3h-12v-1h12v1zm-3.432-12.925c2.202 1.174 5.938 4.883 7.432 6.881-1.286-.9-4.044-1.657-6.091-1.179.222-1.468-.185-4.534-1.341-5.702z"/></svg>
    Page
    <div class="wm-inline-dropdown">
        {{current-page}}
        <ul class="wm-inline-options wm-current-page">
            {{current-page-options}}
        </ul>
    </div>
    of {{max-page}}.
</div>
<div class="wm-sort">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8 10v4h4l-6 7-6-7h4v-4h-4l6-7 6 7h-4zm16 5h-10v2h10v-2zm0 6h-10v-2h10v2zm0-8h-10v-2h10v2zm0-4h-10v-2h10v2zm0-4h-10v-2h10v2z"/></svg>
    <div class="wm-inline-dropdown">
        {{sort}}
        <ul class="wm-inline-options wm-sort-order">
            {{sort-options}}
        </ul>
    </div>
    results first.
</div>
<div class="wm-limit">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7 16h13v1h-13v-1zm13-3h-13v1h13v-1zm0-6h-5v1h5v-1zm0 3h-5v1h5v-1zm-17-8v17.199c0 .771-1 .771-1 0v-15.199h-2v15.98c0 1.115.905 2.02 2.02 2.02h19.958c1.117 0 2.022-.904 2.022-2.02v-17.98h-21zm19 17h-17v-15h17v15zm-9-12h-6v4h6v-4z"/></svg>
    <div class="wm-inline-dropdown">
        {{limit}}
        <ul class="wm-inline-options wm-page-limit">
            {{limit-options}}
        </ul>
    </div>
    results per page.
</div>
</div>
HTML;
    }
}
