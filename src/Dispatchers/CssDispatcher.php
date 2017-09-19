<?php 
namespace AssetsDispatcher;

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