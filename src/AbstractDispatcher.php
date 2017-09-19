<?php 
namespace AssetsDispatcher;

abstract class AbstractDispatcher
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var AssetsDispatcher\MinifierInterface
     */
    protected $minifier;

    /**
     * @var bool
     */
    protected $noCache = false;

    /**
     * @var string
     */
    protected $version; 

    /**
     * @var array
     */
    protected $versions;
    

    /**
     *
     */
    public function __construct( $file, $catalogBase, $cachedBase )
    {
        // Take extenstion
        $i = strrpos( $file, '.' );
        $extension = trim(substr( $file, $i ), '.');
        $file = substr( $file, 0, $i );
        
        // Take version
        $i = strrpos( $file, '-' );
        if ( $i !== false ) {
            $fileName = substr( $file, 0, $i );
            $version = trim(substr( $file, $i ), '-');
        } else {
            $fileName = $file;
            $version = '0';
        }
        
        $this->fileName = $fileName;
        $this->version = $version;

        $catalogFile = "{$catalogBase}/{$this->fileName}.{$extension}";
        $cachedFile = "{$cachedBase}/{$this->fileName}.{$this->version}.{$extension}";

        $this->versions = (object)[
            'catalog' => $catalogFile, 
            'cached' => $cachedFile
        ];
    } // __construct()


    /**
     *
     */
    protected function createCache()
    {
        // Make cache 
        $c = file_get_contents( $this->versions->catalog );
        $this->minify( $c );
        file_put_contents( $this->versions->cached, $c );
    } // createCache()


    /**
     * Dispatches a file 
     */
    public function dispatch()
    {
        $version = $this->versions->cached;
        if ( !is_readable( $version ) && !$this->noCache ) {
            $this->createCache();
        }
        if ( $this->noCache ) {
            $version = $this->versions->catalog;
        }
        header("Content-Type: {$this->getContentType()}");
        echo file_get_contents( $version );
        die();
    } // dispatch()


    /**
     *
     */
    abstract protected function getContentType();

    /**
     *
     */
    public function getFileName()
    {
        return $this->fileName;
    } // getFileName()


    /**
     *
     */
    public function getVersion()
    {
        return $this->version;
    } // getVersion()


    /**
     * This method should be overriden 
     */
    public function minify( &$c ) 
    {
        if ( !isset($this->minifier) ) {
            $defaultMinifier = new DefaultMinifier();
            $defaultMinifier->run( $c );
        } else {
            $c = $this->minifier->run( $c );
        }
        return $this;
    } // minify()
     

    /**
     *
     */
    public function withNoCache()
    {
        $clone = clone $this;
        $clone->noCache = true;
        return $clone;
    } // withNoCache()
} // class

// EOF