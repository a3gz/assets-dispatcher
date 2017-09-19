<?php 
namespace AssetsDispatcher;

class DispatcherFactory 
{
    /**
     *
     */
    public static function getDispatcher( $catalogPath, $cachePath )
    {
        $s = $_SERVER['SCRIPT_NAME'];
        $u = $_SERVER['PHP_SELF'];
        
        $file = substr( $u, strlen($s)+1 );

        $i = strrpos( $file, '.' );
        $type = trim(substr( $file, $i ), '.');

        $dispatcher = null;
        switch ( $type ) {
            case 'js':
                $dispatcher = new JsDispatcher( $file, $catalogPath, $cachePath );
            break;

            case 'css': 
                $dispatcher = new CssDispatcher( $file, $catalogPath, $cachePath );
            break;
        }

        if ( isset($_REQUEST['nocache']) ) {
            $dispatcher = $dispatcher->withNoCache();
        }
        return $dispatcher;
    } // getDispatcher()
} // class 

// EOF