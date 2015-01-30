<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Output;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface OutputFormatInterface {

    public function getName();

    public function getMimeType();

    public function getContent(array $elements, $lines);

    /**
     * Get the container
     *
     * @return ContainerBuilder
     */
    public function getContainer();

    /**
     * Set the container
     *
     * @param ContainerBuilder $container
     * @return $this
     */
    public function setContainer(ContainerBuilder $container);


}