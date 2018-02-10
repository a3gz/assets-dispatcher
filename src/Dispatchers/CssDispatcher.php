<?php 
namespace AssetsDispatcher\Dispatchers;

use AssetsDispatcher\AbstractDispatcher; 

class CssDispatcher extends AbstractDispatcher 
{
    /**
     * @inheritdoc
     */
    protected function getContentType()
    {
        return 'text/css';
    } // getContentType()
} // class 

// EOF