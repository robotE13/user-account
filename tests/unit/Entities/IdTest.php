<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Id;
use Ramsey\Uuid\Exception\{
    InvalidArgumentException,
    UnsupportedOperationException
};
use Ramsey\Uuid\Type\{
    Hexadecimal,
    Integer,
};

class IdTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testOfUuidRepresentations()
    {
        $uuid1 = new Id();
        $uuid2 = new Id($uuid1->getBytes());

        expect('Представление UUID в виде строки совпадает с заданным UUID',
                $uuid1->getString())->equals($uuid2->getString());
        expect('Метод обертка `getHex()` вернет объект Hexadecimal', $uuid1->getHex())
                ->isInstanceOf(Hexadecimal::class);
        expect('Метод обертка `getInteger()` вернет объект Integer', $uuid1->getInteger())
                ->isInstanceOf(Integer::class);
        expect('Геттер для метода, иинкапсулированного в Id, класса Uuid1 не разрешенный в методе __call() не сработает.',
                fn() => $uuid1->getFields())->throws(\BadMethodCallException::class);
    }

    public function testFailToCreateIncorrectUid()
    {
        expect('Cannot create empty UUID', fn() => new Id(''))
                ->throws(InvalidArgumentException::class);
        expect('Cannot create from non UUID', fn() => new Id('fewf'))
                ->throws(InvalidArgumentException::class);
        expect('Cannot create non-time based UUID',
                        fn() => new Id(\Ramsey\Uuid\Uuid::uuid1()->getBytes()))
                ->throws(UnsupportedOperationException::class,
                        'Attempting to decode a non-time-based UUID using OrderedTimeCodec');
    }

}
