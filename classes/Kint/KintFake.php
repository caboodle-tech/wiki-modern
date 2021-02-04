<?php
/**
 * Fake class.
 * 
 * @package Wiki Modern Theme
 */

namespace Kint;

/**
 * Fake class.
 */
class Kint {

    const STATIC_BLACKHOLE = '';

    public function blackhole( $a ) {
        return;
    }

    public function __call( $m, $a ) {
        return call_user_func_array( array( $this, $this->blackhole ), $a );
    }

    public static function __callStatic( $m, $a ) {
        return self::STATIC_BLACKHOLE;
    }
}
$kint = new Kint();

// Alias of Kint::dump()
if ( ! function_exists( 'd' ) ) {
    /**
     * Fake function to catch Kint::dump()
     *
     * @return void
     */
    function d() {
        return;
    }
}
