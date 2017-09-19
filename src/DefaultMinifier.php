<?php 
namespace AssetsDispatcher;

class DefaultMinifier implements MinifierInterface 
{
    /**
     * @inheritdoc
     */
    public function run( &$c )
    {
        $ptrn1 = <<<'EOS'
(?sx)
    # quotes
    (
    "(?:[^"\\]++|\\.)*+"
    | '(?:[^'\\]++|\\.)*+'
    )
|
    # comments
    /\* (?> .*? \*/ )
EOS;

        $ptrn2 = <<<'EOS'
(?six)
    # quotes
    (
    "(?:[^"\\]++|\\.)*+"
    | '(?:[^'\\]++|\\.)*+'
    )
|
    # ; before } (and the spaces after it while we're here)
    \s*+ ; \s*+ ( } ) \s*+
|
    # all spaces around meta chars/operators
    \s*+ ( [*$~^|]?+= | [{};,>~+-] | !important\b ) \s*+
|
    # spaces right of ( [ :
    ( [[(:] ) \s++
|
    # spaces left of ) ]
    \s++ ( [])] )
|
    # spaces left (and right) of :
    \s++ ( : ) \s*+
    # but not in selectors: not followed by a {
    (?!
    (?>
        [^{}"']++
    | "(?:[^"\\]++|\\.)*+"
    | '(?:[^'\\]++|\\.)*+' 
    )*+
    {
    )
|
    # spaces at beginning/end of string
    ^ \s++ | \s++ \z
|
    # double spaces to single
    (\s)\s+
EOS;

        $c = preg_replace("%$ptrn1%", '$1', $c);
        $c = preg_replace("%$ptrn2%", '$1$2$3$4$5$6$7', $c);
        return $this;
    } // run()
} // class

// EOF