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

class OutputHtmlFormat extends OutputFormat {

    protected $container;

    protected $externalStylesheets = [];
    protected $cssStyle;


    public function getName()
    {
        return 'HTML';
    }

    public function getMimeType()
    {
        return 'text/html';
    }

    public function getContent(array $elements, $lines)
    {
        $manifest = $this->getContainer()->getParameter('theme_manifest');
        $css_file = $this->getCssTemplateFile();

        if (false === file_exists($css_file) || false === is_readable($css_file)) {
            throw new \RuntimeException('Theme style (theme.css) does not exist or is not readable.');
        }

        if (!empty($manifest['external_stylesheets'])) {
            $this->setExternalStylesheets($manifest['external_stylesheets']);
        }

        $this->buildCss($manifest, $css_file);
        $html = '';

        foreach ($this->getExternalStylesheets() as $stylesheet)
        {
            $html .= '<link href="'.$stylesheet.'" rel="stylesheet" type="text/css">'."\n";
        }

        $html .= "<style>\n".$this->getCssStyle()."\n</style>";
        $html .= '<div class="limedocs-highlighter">';
        $html .= '<table class="limedocs-highlighter-table">';
        $html .= '<tr>';
        $html .= '<td class="limedocs-highlighter-table-gutter">';
        $html .= '<div class="limedocs-highlighter-gutter">';
        for ($i = 1; $i <= $lines; $i++) {
            $html .= '<span class="limedocs-line-num" id="ldn-'.$i.'"><a href="#ldn-'.$i.'">'.$i.'</a></span>';
        }
        $html .= '</div>';
        $html .= '</td>';
        $html .= '<td class="limedocs-highlighter-table-content">';
        $html .= '<div class="limedocs-highlighter-lines-layer">';
        for ($i = 1; $i<=$lines; $i++) {
            $class = '';
            $html .= '<span class="limedocs-line-layer '.$class.'"></span>';
        }
        $html .= '</div>';

        $html .= '<div class="limedocs-highlighter-editor">';
        foreach ($elements as $element) {
            $label = htmlentities($element['value']);
            if (!empty($element['link'])) {
                $label = '<a href="'.$element['link'].'" title="'.$element['title'].'">'.$label.'</a>';
            }
            $html .= '<span class="'.$element['class'].'">'.$label.'</span>';
        }
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }

    protected function buildCss($manifest, $css_file)
    {
        $replacements = [];

        foreach ($manifest['theme'] as $element => $rules) {
            foreach ($rules as $rule_name => $rule_value) {
                $replacements[$element . "." . $rule_name] = $rule_value;
            }
        }

        $css_style = str_replace(array_keys($replacements), $replacements, file_get_contents($css_file));

        $this->setCssStyle($css_style);

        return $this;
    }

    public function getCssTemplateFile()
    {
        $paths = [
            $this->getContainer()->get('highlighter')->getTheme()->getPath() . '/theme.css',
            __DIR__ . '/../../assets/css/theme.css'
        ];

        foreach ($paths as $path) {
            if(file_exists($path)) {
                return $path;
            }
        }
    }

    public function getExternalStylesheets() {
        return $this->externalStylesheets;
    }

    public function setExternalStylesheets($stylesheets) {
        $this->externalStylesheets = $stylesheets;
        return $this;
    }

    public function getCssStyle()
    {
        return $this->cssStyle;
    }

    public function setCssStyle($style)
    {
        $this->cssStyle = $style;
        return $this;
    }

}