<?php

namespace Foundation;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterInterface;

abstract class AbstractForm extends Form
{
    /**
     * @param InputFilterInterface $filter
     * @param array $options
     */
    public function __construct(InputFilterInterface $filter = null, $options = [])
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName());
        parent::__construct($name, $options);

        $this->initialize();
        if (!is_null($filter)) {
            $this->setInputFilter($filter);
        }
    }

    protected abstract function initialize();

}
