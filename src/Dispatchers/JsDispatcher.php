<?php 
namespace AssetsDispatcher;

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