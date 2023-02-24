<?php

namespace EphenyxShop\PhenyxSpreadsheet\RichText;

class TextElement implements ITextElement
{
    /**
     * Text.
     *
     * @var string
     */
    private $text;

    /**
     * Create a new TextElement instance.
     *
     * @param string $text Text
     */
    public function __construct($text = '')
    {
        // Initialise variables
        $this->text = $text;
    }

    /**
     * Get text.
     *
     * @return string Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text.
     *
     * @param string $text Text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get font.
     *
     * @return null|\EphenyxShop\PhenyxSpreadsheet\Style\Font
     */
    public function getFont()
    {
        return null;
    }

    /**
     * Get hash code.
     *
     * @return string Hash code
     */
    public function getHashCode()
    {
        return md5(
            $this->text .
            __CLASS__
        );
    }
}
