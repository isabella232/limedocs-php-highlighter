<?php
namespace Lime\Highlighter\Language\Tokenizer;

class Token implements TokenInterface
{
    private $type;
    private $value;
    private $offset;

    /**
     * {@inheritdoc}
     */
    public function __construct($type, $value, $offset)
    {
        $this->type = $type;
        $this->value = $value;
        $this->offset = $offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset($offset)
    {
        $this->$offset = $offset;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->offset;
    }
}