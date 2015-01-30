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

class LimedocsReflectionLinksExtension extends Extension {

    /**
     * @var array
     */
    private $fileset;

    public function __construct($fileset) {
        $this->fileset = $fileset;
    }

    /**
     * Return the extension name
     *
     * @return string
     */
    public function getName()
    {
        return 'Limedocs reflection links';
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getHooks()
    {
        $file = $this->getContainer()->get('highlighter')->getFile();

        if (!$file) {
            return [];
        }

        return [
            'element.create' => function($element) {

                return $element;
            }

        ];
    }

}