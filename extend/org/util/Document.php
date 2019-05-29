<?php

namespace org\util;

use org\util\Document\DocumentParser;

/**
 * @title 类注释解析
 */
class Document {

    protected $_parser = null;

    /**
     * Construct
     */
    public function __construct($classFile, $parser = 'PhpDoc') {
        if (!file_exists($classFile)) {
            exit("Non-exists class file '$classFile'.");
        }

        $this->_parser = DocumentParser::factory($parser);
        $this->_parser->parseCode($classFile);
    }

    /**
     * Get annotations
     * @param $classFile ClassName you want
     * @param $methodName MethodName you want
     * @return array
     */
    public function getAnnotation($className = '', $methodName = '') {
        return $this->_parser->getAnnotation($className, $methodName);
    }

}
