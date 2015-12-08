<?php

namespace Ais\IjasahSmaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\IjasahSmaBundle\Exception\InvalidFormException;
use Ais\IjasahSmaBundle\Form\IjasahSmaType;
use Ais\IjasahSmaBundle\Model\IjasahSmaInterface;


class IjasahSmaController extends FOSRestController
{
    /**
     * List all ijasah_smas.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing ijasah_smas.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many ijasah_smas to return.")
     *
     * @Annotations\View(
     *  templateVar="ijasah_smas"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIjasahSmasAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->all($limit, $offset);
    }

    /**
     * Get single IjasahSma.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a IjasahSma for a given id",
     *   output = "Ais\IjasahSmaBundle\Entity\IjasahSma",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the ijasah_sma is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="ijasah_sma")
     *
     * @param int     $id      the ijasah_sma id
     *
     * @return array
     *
     * @throws NotFoundHttpException when ijasah_sma not exist
     */
    public function getIjasahSmaAction($id)
    {
        $ijasah_sma = $this->getOr404($id);

        return $ijasah_sma;
    }

    /**
     * Presents the form to use to create a new ijasah_sma.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newIjasahSmaAction()
    {
        return $this->createForm(new IjasahSmaType());
    }
    
    /**
     * Presents the form to use to edit ijasah_sma.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisIjasahSmaBundle:IjasahSma:editIjasahSma.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ijasah_sma id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ijasah_sma not exist
     */
    public function editIjasahSmaAction($id)
    {
		$ijasah_sma = $this->getIjasahSmaAction($id);
		
        return array('form' => $this->createForm(new IjasahSmaType(), $ijasah_sma), 'ijasah_sma' => $ijasah_sma);
    }

    /**
     * Create a IjasahSma from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new ijasah_sma from the submitted data.",
     *   input = "Ais\IjasahSmaBundle\Form\IjasahSmaType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisIjasahSmaBundle:IjasahSma:newIjasahSma.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIjasahSmaAction(Request $request)
    {
        try {
            $newIjasahSma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newIjasahSma->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ijasah_sma', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing ijasah_sma from the submitted data or create a new ijasah_sma at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\IjasahSmaBundle\Form\IjasahSmaType",
     *   statusCodes = {
     *     201 = "Returned when the IjasahSma is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisIjasahSmaBundle:IjasahSma:editIjasahSma.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ijasah_sma id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ijasah_sma not exist
     */
    public function putIjasahSmaAction(Request $request, $id)
    {
        try {
            if (!($ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->put(
                    $ijasah_sma,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $ijasah_sma->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ijasah_sma', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing ijasah_sma from the submitted data or create a new ijasah_sma at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\IjasahSmaBundle\Form\IjasahSmaType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisIjasahSmaBundle:IjasahSma:editIjasahSma.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ijasah_sma id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ijasah_sma not exist
     */
    public function patchIjasahSmaAction(Request $request, $id)
    {
        try {
            $ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $ijasah_sma->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ijasah_sma', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a IjasahSma or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return IjasahSmaInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $ijasah_sma;
    }
    
    public function postUpdateIjasahSmaAction(Request $request, $id)
    {
		try {
            $ijasah_sma = $this->container->get('ais_ijasah_sma.ijasah_sma.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $ijasah_sma->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ijasah_sma', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
