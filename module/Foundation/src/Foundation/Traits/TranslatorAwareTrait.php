<?php

namespace Foundation\Traits;

use Zend\I18n\Translator\TranslatorAwareTrait as ZendTranslatorAwareTrait;

trait TranslatorAwareTrait
{
    use ZendTranslatorAwareTrait;

    protected function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->getTranslator()->translate($message, $textDomain, $locale);
    }
}