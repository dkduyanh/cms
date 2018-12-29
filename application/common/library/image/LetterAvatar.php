<?php

namespace common\library\image;

use Imagine\Image\Point;

class LetterAvatar
{
    protected $_generator;
    protected $letter;
    protected $bgColor;
    protected $shape;
    protected $size;
    protected $font;
    protected $fontSize;
    protected $fontColor;

    public function __construct($args = array())
    {
        $defaults = [
            'letter' => '',
            'bgColor' => null,
            'shape' => 'circle',
            'size' => 48,
            'font' => './fonts/arial.ttf',
            'fontSize' => 18,
            'fontColor' => '#ffffff',
        ];

        $args = array_merge($defaults, $args);

        $this->setLetter($args['letter']);
        $this->setBgColor($args['bgColor']);
        $this->setShape($args['shape']);
        $this->setSize($args['size']);
        $this->setFont($args['font']);
        $this->setFontSize($args['fontSize']);
        $this->setFontColor($args['fontColor']);

        $imagine = new \Imagine\Gd\Imagine();
        $this->setGenerator($imagine);
    }

    public static function factory(){

    }

    /**
     * @return mixed
     */
    public function getGenerator()
    {
        return $this->_generator;
    }

    /**
     * @param mixed $generator
     */
    public function setGenerator(/*\commom\library\image\generator\ImageGeneratorInterface */$generator)
    {
        $this->_generator = $generator;
    }

    /**
     * @return mixed
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * @param mixed $letter
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;
    }

    /**
     * @return mixed
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * @param mixed $bgColor
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }

    /**
     * @return mixed
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param mixed $shape
     */
    public function setShape($shape)
    {
        $this->shape = $shape;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param mixed $font
     */
    public function setFont($font)
    {
        if(!realpath($font)){
            $font = realpath(dirname(__FILE__).'/'.$font);
        }
        $this->font = $font;
    }

    /**
     * @return mixed
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * @param mixed $fontSize
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    }

    /**
     * @return mixed
     */
    public function getFontColor()
    {
        return $this->fontColor;
    }

    /**
     * @param mixed $fontColor
     */
    public function setFontColor($fontColor)
    {
        $this->fontColor = $fontColor;
    }

    /**
     * Generate random hex color
     * @return string
     */
    function generateRandomHexColor() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    /*function stringToColor($string)
    {
        // random color
        $rgb = substr(dechex(crc32($string)), 0, 6);
        // make it darker
        $darker = 2;
        list($R16, $G16, $B16) = str_split($rgb, 2);
        $R = sprintf("%02X", floor(hexdec($R16) / $darker));
        $G = sprintf("%02X", floor(hexdec($G16) / $darker));
        $B = sprintf("%02X", floor(hexdec($B16) / $darker));
        return '#' . $R . $G . $B;
    }*/

    /**
     * Save Letter Avatar
     * @param $path
     * @param string $mimeType
     * @param int $quality
     * @return bool|int
     * @throws \Exception
     */
    public function saveAs($path, $mimeType = 'image/png', $quality = 90)
    {
        //validate processor
        if($this->getGenerator() == null || $this->getGenerator() instanceof \Imagine){
            throw new \Exception('Invalid Image Generator');
        }

        //validate output
        if(empty($path) || empty($mimeType) || $mimeType != "image/png" && $mimeType != 'image/jpeg'){
            return false;
        }

        //Generate random hex color if not set
        if($this->getBgColor() === null){
            $this->setBgColor($this->generateRandomHexColor());
        }


        $palette = new \Imagine\Image\Palette\RGB();
        $color = $palette->color($this->getBgColor(), 100);
        $size  = new \Imagine\Image\Box($this->size, $this->size);
        $font = $this->getGenerator()->font($this->font, $this->fontSize, $palette->color($this->fontColor, 100));

        //create image
        $image = $this->getGenerator()->create($size, $color);

        //draw text
        $x = ($this->size-$this->fontSize)/2;
        $y = ($this->size-$this->fontSize)/2;
        $image->draw()->text($this->getLetter(), $font, new Point($x, $y), 0);

        //save image
        $image->save($path);

        if(is_file($path)){
            return true;
        }
        return false;

        //return @file_put_contents($path, $this->generate()->encode($mimeType, $quality));
    }
}