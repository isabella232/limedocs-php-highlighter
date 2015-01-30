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
use Lime\Highlighter\Language\PhpLanguage;
use Lime\Highlighter\Output\OutputFormatInterface;
use Lime\Highlighter\Theme\ThemeInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Main highlighter class
 *
 * @package Lime\Highlighter
 */
class Highlighter implements HighlighterInterface {

    /**
     * @var |Lime\Highlighter\Language\LanguageInterface
     */
    protected $language;

    /**
     * @var \Lime\Highlighter\Theme\ThemeInterface
     */
    protected $theme;

    /**
     * @var \Lime\Highlighter\Output\OutputFormatInterface
     */
    protected $outputFormat;

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container;

    protected $file;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $this->container->set('highlighter', $this);
        $this->language = (new PhpLanguage())->setContainer($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguage(LanguageInterface $language)
    {
        $this->language = $language;
        $this->language->setContainer($this->container);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function hook($hook_type, $value)
    {
        foreach ($this->extensions as $ext) {
            if($ext->hasHook($hook_type)) {
                $value = $ext->callHook($hook_type, $value);
            }
        }
        return $value;
    }


    /**
     * {@inheritdoc}
     */
    public function setOutputFormat(OutputFormatInterface $output_format)
    {
        $this->outputFormat = $output_format;
        $this->outputFormat->setContainer($this->container);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    /**
     * @return ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * {@inheritdoc}
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme->setContainer($this->container)->configure();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerExtension(ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension->setContainer($this->container);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see setParameters()
     */
    public function setParameter($name, $value)
    {
        $this->container->setParameter($name, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see setParameter()
     */
    public function setParameters(\Traversable $parameters)
    {
        foreach($parameters as $name => $value) {
            $this->setParameter($name, $value);
        }
        return $this;
    }

    /**
     * Highlight the source code of a file
     *
     * @param string $file File path
     * @return string
     */
    public function highlightFile($file)
    {
        $this->file = $file;
        return $this->highlightSource(file_get_contents($file));
    }

    public function getFile()
    {
        return $this->file;
    }


    /**
     * {@inheritdoc}
     */
    public function highlightString($string)
    {
        if (false === is_string($string)) {
            throw new \DomainException('$source must be a string.');
        }

        if (empty($this->language)) {
            throw new \LogicException(
                'Language is not set. Please set it using setLanguage() _before_ calling highlight()'
            );
        }

        if (empty($this->theme)) {
            throw new \LogicException(
                'Theme is not set. Please set it using setTheme() _before_ calling highlight()'
            );
        }

        $lines = count(explode("\n", $string));
        $iterator = $this->language->getTokenizer()->tokenize($string);
        $elements = $this->language->getFormatter()->format($iterator);
        $html = $this->outputFormat->getContent($elements, $lines);

        return $html;

    }
}