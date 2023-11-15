<?php

namespace App\Controller;

use App\Form\ApiSearchType;
use App\Models\Search\ApiSearch;
use App\Service\Traits\AppServiceTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/movie', name: 'movie_')]
class MovieController extends AbstractController
{
    use AppServiceTrait;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/search', name: 'search')]
    public function search(Request $request): Response
    {
        $moviesData = null;
        $search = new ApiSearch();
        $searchForm = $this->createForm(ApiSearchType::class, $search);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()){
            $moviesData = $this->getCallApiService()->getData($searchForm['name']->getData());
        }

        return $this->render('movie/search.html.twig', [
            'searchForm' => $searchForm->createView(),
            'moviesData' => $moviesData,
        ]);
    }

    //affichage d'une nouvelle page de film via Ajax
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/search_by_page', name: 'searchByPage')]
    public function searchByPage(Request $request): JsonResponse
    {
        $result = $this->getCallApiService()->getPageResult($request->get('search'), $request->get('page'));
         return new JsonResponse($result);
    }
}
