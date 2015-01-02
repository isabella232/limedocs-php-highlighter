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

interface ExtensionInterface {

    /**
     * Return the extension name
     *
     * @return string
     */
    public function getName();

    public function getSubscribedEvents();

}