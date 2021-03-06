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
    public function __construct( $file, $catalogBase, $cachedBase, $version = null )
    {
        // Take extenstion
        $i = strrpos( $file, '.' );
        $extension = trim(substr( $file, $i ), '.');
        $file = substr( $file, 0, $i );

        $fileName = $file;

        // Take version
        if ( $version === null ) {
            $i = strrpos( $file, '-' );
            if ( $i !== false ) {
                $fileName = substr( $file, 0, $i );
                $version = trim(substr( $file, $i ), '-');
            } else {
                $fileName = $file;
                $version = '0';
            }
        }
        
        $this->fileName = $fileName;

        $catalogFile = "{$catalogBase}/{$this->fileName}.{$extension}";

        if ( $version === false ) {
            // keep original name
            $cachedFile = "{$cachedBase}/{$this->fileName}.{$extension}";
        } else {
            $this->version = $version;
            $cachedFile = "{$cachedBase}/{$this->fileName}.{$this->version}.{$extension}";
        }

        $this->versions = (object)[
            'catalog' => $catalogFile, 
            'cached' => $cachedFile
        ];
    } // __construct()


    /**
     *
     */
    public function createCache()
    {
        // Make cache 
        if ( !is_readable( $this->versions->catalog ) ) {
            return;
        }
        $c = file_get_contents( $this->versions->catalog );
        $this->minify( $c );
        file_put_contents( $this->versions->cached, $c );
    } // createCache()


    /**
     * Dispatches the HTTP-requested file.
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
        if ( !is_readable( $version) ) {
            return;
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
     * Takes a string (by refference) and minifies it. 
     *
     * @param string &$c String to minify
     * @return chainable
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