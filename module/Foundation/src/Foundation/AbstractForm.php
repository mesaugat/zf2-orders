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
     * @param InputFilterInterface $filter
     * @param EntityInterface $prototype
     * @param array $options
     */
    public function __construct(InputFilterInterface $filter = null, EntityInterface $prototype, $options = [])
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName());
        parent::__construct($name, $options);

        // Set Hydrator and Object Prototype
        $this->setHydrator(new ClassMethods(false));
        $this->setObject($prototype);

        $this->initialize();
        if (!is_null($filter)) {
            $this->setInputFilter($filter);
        }
    }

    protected abstract function initialize();

    /**
     * @param int $flag
     * @return EntityInterface
     */
    public function getData($flag = FormInterface::VALUES_NORMALIZED)
    {
        return parent::getData($flag);
    }
}
