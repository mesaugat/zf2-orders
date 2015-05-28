<?php

namespace Order\Form;

use Foundation\AbstractForm as Form;
use Order\Entity\Repository\RoleRepository;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterInterface;

class RoleForm extends Form
{
    protected $repository;

    public function __construct(RoleRepository $repository, $options = [])
    {
        $this->repository = $repository;

        $entityClass = $repository->getClassName();
        $prototypeObject = new $entityClass();

        parent::__construct($prototypeObject, $options);
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
                'column-size' => 'sm-8'
            ],
        ]);

        $this->add([
            'name' => 'roleId',
            'type' => 'Text',
            'options' => [
                'label' => 'Role Unique Id',
                'column-size' => 'sm-8'
            ],
        ]);

        $roleSelectList = $this->repository->getRoleSelectList();

        $this->add([
            'name' => 'parentId',
            'type' => 'Select',
            'options' => [
                'label' => 'Parent',
                'value_options' => $roleSelectList,
                'column-size' => 'sm-8'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'label' => 'Submit',
                'column-size' => 'sm-8 col-sm-offset-2'
            ],
            'attributes' => [
                'id' => 'submitbutton',
                'class' => 'btn-primary'
            ],
        ]);
    }

    public function getData($flag = FormInterface::VALUES_NORMALIZED)
    {
        $entity = parent::getData($flag);
        $parentId = parent::get('parentId')->getValue();
        if ($parentId) {
            $entity->setParent($this->repository->find($parentId));
        }

        return $entity;
    }


}
