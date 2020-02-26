<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TodoController extends AbstractController
{
    private $serializer;

    public function __construct()
    {
        // Dans le constructeur, on créée notre serializer
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $this->serializer = $serializer;
    }

    /**
     * @Route("/todos", name="todos")
     */
    public function index(TodoRepository $todoRepository)
    {
        $todos = $todoRepository->findAll();
        $jsonContent = $this->serializer->serialize($todos, 'json');

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Type', 'charset=utf-8');

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', '"GET, PUT, POST, DELETE, HEAD, OPTIONS"');

        return $response;
    }

    /**
     * @Route("/todo/{todo}", name="todo")
     */
    public function show(Todo $todo)
    {
        $jsonContent = $this->serializer->serialize($todo, 'json');

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Type', 'charset=utf-8');

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', '"GET, PUT, POST, DELETE, HEAD, OPTIONS"');

        return $response;
    }
}
