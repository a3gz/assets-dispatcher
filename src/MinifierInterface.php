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

} // interface 

// EOF