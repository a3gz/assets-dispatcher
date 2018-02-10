<?php 
namespace AssetsDispatcher\Dispatchers;

use AssetsDispatcher\AbstractDispatcher; 

class JsDispatcher extends AbstractDispatcher 
{
    /**
     * @inheritdoc
     */
     protected function getContentType()
     {
         return 'application/javascript';
     } // getContentType()
 } // class 

// EOF