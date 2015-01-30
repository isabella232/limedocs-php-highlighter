<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Extension;

class PhpManualLinksExtension extends Extension {

    /**
     * @var array
     */
    private $quickref;

    public function __construct() {
        $this->quickref = include(__DIR__ . '/../../config/quickref-php.php');
    }

    /**
     * Return the extension name
     *
     * @return string
     */
    public function getName()
    {
        return 'PHP Manual links';
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getHooks()
    {
        return [
            'element.create' => function($element) {
                if($element['class'] === 'limedocs-generic-function') {
                    $native = isset($this->quickref[$element['value']]) ? $this->quickref[$element['value']] : false;
                    if ($native) {
                        $element['link'] = 'http://php.net/manual/en/'.$native['file'];
                        $element['title'] = $element['value'].': '.$native['desc'];
                    }
                } elseif ($element['class'] === 'limedocs-generic-predefined-constant') {
                    $element['link'] = 'http://php.net/manual/en/reserved.constants.php';
                    $element['title'] = 'Predefined constant';
                } elseif ($element['class'] === 'limedocs-generic-magic-constant') {
                    $element['link'] = 'http://php.net/manual/en/language.constants.predefined.php';
                    $element['title'] = 'Magic constant';
                }
                    return $element;
            }

        ];
    }




}