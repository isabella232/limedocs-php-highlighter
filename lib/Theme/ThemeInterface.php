<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Theme;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ThemeInterface {

    /**
     * Configure the theme by parsing the theme file
     *
     * @return $this
     */
    public function configure();

    /**
     * Get the theme code (the string "vendor/theme-file.tmTheme" )
     *
     * @return string
     */
    public function getCode();


    /**
     * Validate the theme code
     *
     * @param $theme_code
     * @return bool
     */
    public function validateThemeCode($theme_code);


    /**
     * Return path to the theme file
     *
     * @return string
     */
    public function getPath();

    /**
     * Check that the theme exists on disk
     *
     * @return boolean
     */
    public function exists();

    /**
     * Return informations about a theme
     *
     * @return array
     */
    public function getInfos();

    /**
     * Return the properties of the theme (colors, fonts etc)
     *
     * @return array
     */
    public function getProperties();

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