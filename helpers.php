<?php
namespace Modules\Core;

if(!function_exists(__NAMESPACE__.'\strEqual')){
    function strEqual(...$args)
    {
        $result = true;
        foreach($args as $arg){
            if(!next($args)){
                break;
            }
            $result = $result && (strval($arg) === strval(current($args)));
        }

        return $result;
    }
}
