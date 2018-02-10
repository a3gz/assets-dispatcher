<?php 
namespace AssetsDispatcher;

use AssetsDispatcher\Dispatchers\JsDispatcher; 
use AssetsDispatcher\Dispatchers\CssDispatcher; 

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


    /**
     *
     */
     public static function getPipe( $file, $catalogPath, $cachePath, $version )
     {
         $types = ['js', 'css'];

         $i = strrpos( $file, '.' );
         $type = trim(substr( $file, $i ), '.');
          
         if ( !in_array($type, $types) ) {
             throw new \Exception( "Unexpected file type: {$type}. Expected types: " . implode(',', $types) );
         }
 
         $dispatcher = null;
         switch ( $type ) {
             case 'js':
                 $dispatcher = new JsDispatcher( $file, $catalogPath, $cachePath, $version );
             break;
 
             case 'css': 
                 $dispatcher = new CssDispatcher( $file, $catalogPath, $cachePath, $version );
             break;
         }
 
         return $dispatcher;
     } // getPipe()     

} // class 

// EOF