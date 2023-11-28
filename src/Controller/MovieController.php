<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ApiSearchType;
use App\Models\Search\ApiSearch;
use App\Models\Search\MovieSearch;
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

    #[Route('/collection', name: 'collection')]
    public function showCollection(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $moviesSearch = new MovieSearch();
        $moviesSearch->setUser($user);
        $movies = $this->getMovieService()->getAll($moviesSearch);

        return $this->render('movie/collection.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(int $id)
    {
        $movie = $this->getMovieService()->findById($id);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

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

    //Ajout d'un film à la collection de l'utilisateur via Ajax
    #[Route('/ajout-film', name: 'add')]
    public function addMovie(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $idMovieDB = $request->get('id');
        $movie = $this->getMovieService()->findOneBy(['idMovieDB' => $idMovieDB]);

        if($movie){
            $message = $this->getUserMovieService()->create($user, $movie);
        }else{
            $newMovie = $this->getCallApiService()->getMovieDetail($idMovieDB);
            $newMovie = $this->getMovieService()->create($newMovie);
            $message = $this->getUserMovieService()->create($user, $newMovie);
        }

        return new JsonResponse($message);
    }
}
