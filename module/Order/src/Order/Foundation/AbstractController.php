<?php


namespace Order\Foundation;


use Zend\I18n\Translator\Translator;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{

    /**
     * @var Translator
     */
    protected $translator;


    /**
     * @return Translator
     */
    public function getTranslator()
    {

        if (!$this->translator) {
            $this->translator = $this->getServiceLocator()->get('translator');
        }

        return $this->translator;
    }

    protected function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->getTranslator()->translate($message, $textDomain, $locale);
    }
}