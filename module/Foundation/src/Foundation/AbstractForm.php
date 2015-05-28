<?php

namespace Foundation;

use Zend\Form\Form;
use Zend\Form\FormInterface;
use Foundation\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

abstract class AbstractForm extends Form
{
    /**
     * @param EntityInterface $prototype
     * @param array $options
     */
    public function __construct(EntityInterface $prototype, $options = [])
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName());
        parent::__construct($name, $options);

        $this->initialize();
    }

    protected abstract function initialize();
}
