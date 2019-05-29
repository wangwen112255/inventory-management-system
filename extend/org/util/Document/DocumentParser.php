<?php

namespace org\util\Document;

abstract class DocumentParser {

    /**
     * @var array 
     */
    protected $_annotation = array(
        '_annotation' => array(),
        '_methodlist' => array(
            '_annotation' => array()
        )
    );

    /**
     * Get annotations from a class file
     * @param $classFile
     * @return array
     */
    public function getAnnotation($className = '', $methodName = '') {
        if ($className && $methodName) {
            return $this->_annotation[$className]['_methodlist'][$methodName]['_annotation'];
        } elseif ($className) {
            return $this->_annotation[$className]['_annotation'];
        } else {
            return false;
        }
    }

    /**
     * Create storage object
     * @param string $engine Engine name (sysv, file)
     * @return object
     */
    public static function factory($engine) {
        return new PhpDoc();
    }

    /**
     * Parse code
     */
    abstract public function parseCode($classFile);
}
