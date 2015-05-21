<?php

namespace Order\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ItemForm
 * @package Order\Form
 */
class ItemForm extends Form
{
    /**
     * @param $name
     * @param InputFilterInterface $filter
     * @param array $options
     */
    public function __construct($name = null, InputFilterInterface $filter, $options = [])
    {
        parent::__construct($name, $options);

        $this->initialize();
        $this->setInputFilter($filter);
    }

    protected function initialize()
    {
        $this->add([
            'name' => 'id',
            'type' => 'Hidden',
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'Text',
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'name' => 'rate',
            'type' => 'Text',
            'options' => [
                'label' => 'Rate',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Create',
                'id' => 'submitbutton',
            ],
        ]);
    }
}