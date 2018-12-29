<?php

namespace commom\library\image\generator;

/**
 * Interface ImageGeneratorInterface
 *
 * ImageGeneratorInterface is the interface that must be implemented by counter classes.
 *
 * @author DuyAnh
 */
interface ImageGeneratorInterface
{
    public function saveAs();
    public function process();
}