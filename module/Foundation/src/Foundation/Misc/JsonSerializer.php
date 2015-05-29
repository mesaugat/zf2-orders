<?php

namespace Foundation\Misc;

use DateTime;
use Traversable;
use Zend\Stdlib\ArrayUtils;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Handler\HandlerRegistry;

class JsonSerializer
{
    public function serialize($data)
    {
        if ($data instanceof Traversable) {
            $data = ArrayUtils::iteratorToArray($data);
        }

        $serializer = SerializerBuilder::create()
            ->addDefaultHandlers()
            ->configureHandlers(function (HandlerRegistry $registry) {
                $registry->registerHandler('serialization', 'DateTime', 'json',
                    function ($visitor, DateTime $value, array $type) {
                        return $value->format('M, d Y h:i:s A');
                    }
                );
            })->build();

        return $serializer->serialize($data, 'json');
    }
}
