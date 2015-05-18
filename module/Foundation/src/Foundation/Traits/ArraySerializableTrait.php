<?php

namespace Foundation\Traits;


trait ArraySerializableTrait
{
    /**
     * Exchange internal values from provided array
     *
     * @param  array $data
     * @return void
     */
    public function exchangeArray(array $data)
    {
        foreach ($this->getArrayCopy() as $key => $value) {

            if ($key === 'created') {
                continue;
            }

            $this->{$key} = isset($data[$key]) ? $data[$key] : null;
        }
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}