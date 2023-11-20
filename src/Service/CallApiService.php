<?php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    public function __construct(private readonly HttpClientInterface $client, private readonly ParameterBagInterface $parameterBag){

    }

    //Récupération des données de base d'un film

    /**
     * @param string $query
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getData(string $query): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie?query=' . $query .'&api_key=' . $this->parameterBag->get('APP_SECRET') . '&language=fr-FR'
        );

        return $response->toArray();
    }

    //Récupération des résultats d'une recherche si il y a plusieurs pages de résultats

    /**
     * @param string $query
     * @param string $page
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getPageResult(string $query, string $page): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie?query=' . $query .'&api_key=' . $this->parameterBag->get('APP_SECRET') . '&language=fr-FR&page=' . $page
        );

        return $response->toArray();
    }

    //Récupération des détails d'un film via l'Id the movie DB
    public function getMovieDetail(int $id)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/' . $id .'?api_key=' . $this->parameterBag->get('APP_SECRET') . '&language=fr-FR'
        );

        return $response->toArray();
    }

}