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
use Lime\Highlighter\Output\OutputFormatInterface;
use Lime\Highlighter\Theme\ThemeInterface;

/**
 * Interface implemented by the Highlighter
 * @package Lime\Highlighter
 */
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
     * @return ThemeInterface
     */
    public function getTheme();


    /**
     * Set the output format used
     *
     * @param OutputFormatInterface $output_format
     * @return $this
     */
    public function setOutputFormat(OutputFormatInterface $output_format);


    /**
     * @return OutputFormatInterface
     */
    public function getOutputFormat();

    /**
     * Register an extension to be used
     *
     * @param ExtensionInterface $extension
     * @return $this
     */
    public function registerExtension(ExtensionInterface $extension);


    /**
     * Set a parameter value
     *
     * @param string $name Option name
     * @param mixed $value Option value
     * @return $this
     */
    public function setParameter($name, $value);

    /**
     * Set several parameters in one call
     *
     * @param \Traversable $parameters
     * @return $this
     */
    public function setParameters(\Traversable $parameters);

    /**
     * Get the source file if set
     *
     * @return string|null
     */
    public function getFile();

    /**
     * Highlight the source code of a file
     *
     * @param string $file File path
     * @return string
     */
    public function highlightFile($file);


    /**
     * Highlight the source code
     *
     * @param string $string Source code
     * @return string
     */
    public function highlightString($string);


    public function hook($hook_type, $value);

}