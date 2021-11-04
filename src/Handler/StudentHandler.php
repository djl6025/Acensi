<?php

use Entity\Student;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

class StudentHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'Entity\Student',
                'method' => 'serialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Student $student, array $type, Context $context)
    {
        $data = [
            'firstname' => $student->getFirstName(),
            'lastname' => $student->getLastName(),
            'numetud' => $student->getNumEtud(),
            'department' => $student->getDepartment(),
        ];

        return $visitor->visitArray($data, $type, $context);
    }
}