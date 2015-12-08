<?php

namespace Ais\IjasahSmaBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\IjasahSmaBundle\Model\IjasahSmaInterface;
use Ais\IjasahSmaBundle\Form\IjasahSmaType;
use Ais\IjasahSmaBundle\Exception\InvalidFormException;

class IjasahSmaHandler implements IjasahSmaHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a IjasahSma.
     *
     * @param mixed $id
     *
     * @return IjasahSmaInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of IjasahSmas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new IjasahSma.
     *
     * @param array $parameters
     *
     * @return IjasahSmaInterface
     */
    public function post(array $parameters)
    {
        $ijasah_sma = $this->createIjasahSma();

        return $this->processForm($ijasah_sma, $parameters, 'POST');
    }

    /**
     * Edit a IjasahSma.
     *
     * @param IjasahSmaInterface $ijasah_sma
     * @param array         $parameters
     *
     * @return IjasahSmaInterface
     */
    public function put(IjasahSmaInterface $ijasah_sma, array $parameters)
    {
        return $this->processForm($ijasah_sma, $parameters, 'PUT');
    }

    /**
     * Partially update a IjasahSma.
     *
     * @param IjasahSmaInterface $ijasah_sma
     * @param array         $parameters
     *
     * @return IjasahSmaInterface
     */
    public function patch(IjasahSmaInterface $ijasah_sma, array $parameters)
    {
        return $this->processForm($ijasah_sma, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param IjasahSmaInterface $ijasah_sma
     * @param array         $parameters
     * @param String        $method
     *
     * @return IjasahSmaInterface
     *
     * @throws \Ais\IjasahSmaBundle\Exception\InvalidFormException
     */
    private function processForm(IjasahSmaInterface $ijasah_sma, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new IjasahSmaType(), $ijasah_sma, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $ijasah_sma = $form->getData();
            $this->om->persist($ijasah_sma);
            $this->om->flush($ijasah_sma);

            return $ijasah_sma;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createIjasahSma()
    {
        return new $this->entityClass();
    }

}
