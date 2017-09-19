<?php 

// In a real environment these imports will be automatically resolved 
// by composer's autoload. 
include '../src/AbstractDispatcher.php';
include '../src/DispatcherFactory.php';
include '../src/MinifierInterface.php';
include '../src/DefaultMinifier.php';
include '../src/Dispatchers/JsDispatcher.php';
include '../src/Dispatchers/CssDispatcher.php';

// Create the dispatcher and dispatch the requested resource. 
AssetsDispatcher\DispatcherFactory::getDispatcher( 
    __DIR__.'/resources/catalog',
    __DIR__.'/resources/cache'
)->dispatch();