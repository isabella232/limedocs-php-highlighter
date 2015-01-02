<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter;

use Lime\Highlighter\Extension\ExtensionInterface;
use Lime\Highlighter\Language\LanguageInterface;
use Lime\Highlighter\Theme\ThemeInterface;

interface HighlighterInterface {

    /**
     * Set the language used in source code
     *
     * @param LanguageInterface $language
     * @return $this
     */
    public function setLanguage(LanguageInterface $language);

    /**
     * @return LanguageInterface
     */
    public function getLanguage();

    /**
     * Set the theme used
     *
     * @param ThemeInterface $theme
     * @return $this
     */
    public function setTheme(ThemeInterface $theme);

    /**
     * Register an extension to be used
     *
     * @param ExtensionInterface $extension
     * @return $this
     */
    public function registerExtension(ExtensionInterface $extension);


    /**
     * Set an option value
     *
     * @param string $optname Option name
     * @param mixed $optvalue Option value
     * @return $this
     */
    public function setOption($optname, $optvalue);

    /**
     * Set several options in one call
     *
     * @param \Traversable $options
     * @return $this
     */
    public function setOptions(\Traversable $options);

    /**
     * Highlight the source code
     *
     * @param string $source Source code
     * @return string
     */
    public function highlight($source);

}