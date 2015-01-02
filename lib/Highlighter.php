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
use Lime\Highlighter\Tokenizer\Tokenizer;

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
     * @var array
     */
    protected $extensions = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritdoc}
     */
    public function setLanguage(LanguageInterface $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerExtension(ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see setOptions()
     */
    public function setOption($optname, $optvalue)
    {
        $this->options[$optname] = $optvalue;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see setOption()
     */
    public function setOptions(\Traversable $options)
    {
        foreach($options as $optname => $optvalue) {
            $this->setOption($optname, $optvalue);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function highlight($source)
    {
        if (false === is_string($source)) {
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

        $lines = count(explode("\n", $source));
        $iterator = $this->language->getTokenizer()->tokenize($source);
        $elements = $this->language->getFormatter()->format($iterator);

        $html = '';

        foreach ($this->theme->getExternalStylesheets() as $stylesheet)
        {
            $html .= '<link href="'.$stylesheet.'" rel="stylesheet" type="text/css">'."\n";
        }

        $html .= "<style>\n".$this->theme->getStyle()."\n</style>";
        $html .= '<div class="limedocs-highlighter">';
        $html .= '<div class="limedocs-highlighter-gutter">';
        for ($i = 1; $i<=$lines; $i++) {
            $html .= '<span class="limedocs-line-num" id="ldn-'.$i.'"><a href="#ldn-'.$i.'">'.$i.'</a></span><br />';
        }
        $html .= '</div>';
        $html .= '<div class="limedocs-highlighter-editor">';

        foreach ($elements as $element) {
            $html .= '<span class="'.$element['class'].'">'.htmlentities($element['value']).'</span>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;

    }
}