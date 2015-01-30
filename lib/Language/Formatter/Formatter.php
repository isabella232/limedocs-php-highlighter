<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Language\Formatter;

use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class Formatter implements FormatterInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;
        return $this;
    }

    public function getCssClass($token_code)
    {
        $map = $this->getCssMap();
        return empty($map[$token_code]) ? 'limedocs-unknown-element' : $map[$token_code];
    }

}