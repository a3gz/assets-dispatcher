<?php 
namespace AssetsDispatcher;

interface MinifierInterface 
{
    /**
     * Minifies the string in $content. 
     *
     * @param string $content
     * @return Chainable
     */
    public function run( &$content );


    /**
     * Searches for $fileName in the resources catalog, minifies the content and 
     * writes the result in the cache. 
     *
     * @param string $fileName
     */
    public function pipe( $fileName );
} // interface 

// EOF