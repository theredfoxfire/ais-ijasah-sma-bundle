<?php

namespace Ais\IjasahSmaBundle\Tests\Handler;

use Ais\IjasahSmaBundle\Handler\IjasahSmaHandler;
use Ais\IjasahSmaBundle\Model\IjasahSmaInterface;
use Ais\IjasahSmaBundle\Entity\IjasahSma;

class IjasahSmaHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\IjasahSmaBundle\Tests\Handler\DummyIjasahSma';

    /** @var IjasahSmaHandler */
    protected $ijasah_smaHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $ijasah_sma = $this->getIjasahSma();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($ijasah_sma));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->ijasah_smaHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $ijasah_smas = $this->getIjasahSmas(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($ijasah_smas));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->ijasah_smaHandler->all($limit, $offset);

        $this->assertEquals($ijasah_smas, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ijasah_sma = $this->getIjasahSma();
        $ijasah_sma->setTitle($title);
        $ijasah_sma->setBody($body);

        $form = $this->getMock('Ais\IjasahSmaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ijasah_sma));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ijasah_smaObject = $this->ijasah_smaHandler->post($parameters);

        $this->assertEquals($ijasah_smaObject, $ijasah_sma);
    }

    /**
     * @expectedException Ais\IjasahSmaBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ijasah_sma = $this->getIjasahSma();
        $ijasah_sma->setTitle($title);
        $ijasah_sma->setBody($body);

        $form = $this->getMock('Ais\IjasahSmaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->ijasah_smaHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ijasah_sma = $this->getIjasahSma();
        $ijasah_sma->setTitle($title);
        $ijasah_sma->setBody($body);

        $form = $this->getMock('Ais\IjasahSmaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ijasah_sma));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ijasah_smaObject = $this->ijasah_smaHandler->put($ijasah_sma, $parameters);

        $this->assertEquals($ijasah_smaObject, $ijasah_sma);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $ijasah_sma = $this->getIjasahSma();
        $ijasah_sma->setTitle($title);
        $ijasah_sma->setBody($body);

        $form = $this->getMock('Ais\IjasahSmaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ijasah_sma));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ijasah_smaHandler = $this->createIjasahSmaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ijasah_smaObject = $this->ijasah_smaHandler->patch($ijasah_sma, $parameters);

        $this->assertEquals($ijasah_smaObject, $ijasah_sma);
    }


    protected function createIjasahSmaHandler($objectManager, $ijasah_smaClass, $formFactory)
    {
        return new IjasahSmaHandler($objectManager, $ijasah_smaClass, $formFactory);
    }

    protected function getIjasahSma()
    {
        $ijasah_smaClass = static::DOSEN_CLASS;

        return new $ijasah_smaClass();
    }

    protected function getIjasahSmas($maxIjasahSmas = 5)
    {
        $ijasah_smas = array();
        for($i = 0; $i < $maxIjasahSmas; $i++) {
            $ijasah_smas[] = $this->getIjasahSma();
        }

        return $ijasah_smas;
    }
}

class DummyIjasahSma extends IjasahSma
{
}
