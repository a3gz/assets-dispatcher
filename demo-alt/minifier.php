<?php 

// In a real environment these imports will be automatically resolved 
// by composer's autoload. 
include '../src/AbstractDispatcher.php';
include '../src/DispatcherFactory.php';
include '../src/MinifierInterface.php';
include '../src/DefaultMinifier.php';
include '../src/Dispatchers/JsDispatcher.php';
include '../src/Dispatchers/CssDispatcher.php';

/**
 * To "manually" minify a file we use the pipes. 
 * A pipe will get 
 */

AssetsDispatcher\DispatcherFactory::getPipe( 
    'file.js',                                      // Source file
    dirname(__DIR__).'/demo/resources/catalog/js',  // Source directory
    __DIR__.'/resources/cache/js',                  // Target directory
    'v8'                                            // New version
)->createCache();

AssetsDispatcher\DispatcherFactory::getPipe( 
    'styles.css',                                   // Source file
    dirname(__DIR__).'/demo/resources/catalog/css', // Source directory
    __DIR__.'/resources/cache/css',                 // Target directory
    'v1'                                            // New version
)->createCache();
    