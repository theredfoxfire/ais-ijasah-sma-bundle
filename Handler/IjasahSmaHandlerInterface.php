<?php

namespace Ais\IjasahSmaBundle\Handler;

use Ais\IjasahSmaBundle\Model\IjasahSmaInterface;

interface IjasahSmaHandlerInterface
{
    /**
     * Get a IjasahSma given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return IjasahSmaInterface
     */
    public function get($id);

    /**
     * Get a list of IjasahSmas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post IjasahSma, creates a new IjasahSma.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return IjasahSmaInterface
     */
    public function post(array $parameters);

    /**
     * Edit a IjasahSma.
     *
     * @api
     *
     * @param IjasahSmaInterface   $ijasah_sma
     * @param array           $parameters
     *
     * @return IjasahSmaInterface
     */
    public function put(IjasahSmaInterface $ijasah_sma, array $parameters);

    /**
     * Partially update a IjasahSma.
     *
     * @api
     *
     * @param IjasahSmaInterface   $ijasah_sma
     * @param array           $parameters
     *
     * @return IjasahSmaInterface
     */
    public function patch(IjasahSmaInterface $ijasah_sma, array $parameters);
}
