<?php

namespace Order\Entity\Repository;

use Foundation\Crud\AbstractCrudRepository as CrudRepository;
use Order\Entity\Customer;

class CustomerRepository extends CrudRepository
{

    public function getObjectInstance(array $data)
    {
        $customer = new Customer();
        $customer->setName($data['name']);
        $customer->setAddress($data['address']);

        return $customer;
    }
}
