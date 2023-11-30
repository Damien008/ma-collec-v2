<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ApiSearchType;
use App\Form\SupportType;
use App\Models\Search\ApiSearch;
use App\Models\Search\MovieSearch;
use App\Models\SupportModel;
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
     * @return Response
     */
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

    /**
     * @param int $id
     * @return Response
     */
    #[Route('/show/{id}', name: 'show')]
    public function show(int $id)
    {
        $movie = $this->getMovieService()->findById($id);
        $user = $this->getUser();
        $userMovie = $this->getUserMovieService()->findOneBy(['user' => $user, 'movie' => $movie]);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'userMovie'  => $userMovie,
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/ajout-support', name: 'addSupport', options: ['expose' => true])]
    public function addSupportToMovie(): JsonResponse
    {
        $support = new SupportModel();
        $form = $this->createForm(SupportType::class, $support);
        $html = $this->render('movie/_form_add_support.html.twig', ['form' => $form->createView()])->getContent();

        return new JsonResponse($html);
    }

    //Ajout d'un film à la collection de l'utilisateur via Ajax
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/ajout-film', name: 'add')]
    public function addMovie(Request $request): JsonResponse
    {
        $model = new SupportModel();
        $form = $this->createForm(SupportType::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $support = $this->getSupportService()->findOneBy([ 'name' => $form['name']->getData()]);

            /** @var User $user */
            $user = $this->getUser();
            $idMovieDB = $form['idMovie']->getData();
            $movie = $this->getMovieService()->findOneBy(['idMovieDB' => $idMovieDB]);

            //si le film est déjà dans la base de données on l'ajoute à l'utilsateur
            if($movie){
                $message = $this->getUserMovieService()->create($user, $movie, $support);
                //si le film n'est pas dans la base de données on l'ajoute, puis on l'ajoute à l'utilisateur
            }else{
                $newMovie = $this->getCallApiService()->getMovieDetail($idMovieDB);
                $newMovie = $this->getMovieService()->create($newMovie);
                $message = $this->getUserMovieService()->create($user, $newMovie, $support);
            }
            $jsonRet['message'] = $message;
        }else{
            $html = $this->render('movie/_form_add_support.html.twig', ['form' => $form->createView()])->getContent();
            $jsonRet['html'] = $html;
        }

        return new JsonResponse($jsonRet);
    }

    /**
     * @param int $id
     * @return Response
     */
    #[Route('/delete_user_movie/{id}', name: 'delete_user_movie')]
    public function deleteUserMovie(int $id): Response
    {
        $user = $this->getUser();
        $movie = $this->getMovieService()->findById($id);
        $userMovie =  $this->getUserMovieService()->findOneBy(['user' => $user, 'movie' => $movie]);
        $this->getUserMovieService()->delete($userMovie);

        return $this->redirectToRoute('movie_collection');

    }
}
