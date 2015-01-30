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

use Lime\Highlighter\Language\Tokenizer\TokenIterator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface FormatterInterface {

    /**
     * @param TokenIterator $tokenIterator
     * @return array
     */
    public function format(TokenIterator $tokenIterator);

    /**
     * @return array
     */
    public function getCssMap();

    /**
     * @param int $token_code Token code
     * @return string
     */
    public function getCssClass($token_code);


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