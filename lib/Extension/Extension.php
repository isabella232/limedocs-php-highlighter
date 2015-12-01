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

use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class Extension implements ExtensionInterface {

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

    public function hasHook($hook_type)
    {
        return array_key_exists($hook_type, $this->getHooks());
    }

    public function callHook($hook_type, $value)
    {
        $hooks = $this->getHooks();
        //var_dump($hooks[$hook_type]);exit;
        return call_user_func($hooks[$hook_type], $value);
    }

}