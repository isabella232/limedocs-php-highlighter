<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Language;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class LanguageInterface
 */
interface LanguageInterface {


    public function getTokenizer();
    public function getFormatter();

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