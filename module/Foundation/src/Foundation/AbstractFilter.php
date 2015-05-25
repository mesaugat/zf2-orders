<?php

namespace Foundation;

use Foundation\Traits\TranslatorAwareTrait;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\InputFilter\InputFilter;

abstract class AbstractFilter extends InputFilter
{
    use TranslatorAwareTrait;

    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
        $this->initialize();
    }

    protected abstract function initialize();
}
