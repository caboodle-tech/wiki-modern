<?php
/**
* If not in debug mode help the dev out who may have accidently left Kint calls
* in the code by catching all calls and ignoring them.
*/
class Kint {

    const static_blackhole = '';

    public function blackhole( $a ){
        return;
    }

    public function __call( $m, $a ) {
        return call_user_func_array( array( $this, $this->blackhole ), $a );
    }

    public static function __callStatic( $m, $a ) {
        return self::static_blackhole;
    }
}
$kint = new Kint();

// Alias of Kint::dump()
if( !function_exists('d') ){
    function d(){
        return;
    }
}
?>
