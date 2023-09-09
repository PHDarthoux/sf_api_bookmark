<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookmarkController extends AbstractController
{
    #[Route('/bookmark', name: 'app_bookmark')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your Bookmark API!',
            'all bookmark' => '/bookmark/all',
            'pictures' => [
                'add' => '/add-picture/{link}',
                'list' => '/pictures',
                'read' => '/picture/{id}',
                'update' => '/update-picture/{id}',
                'delete' => '/delete-picture/{id}',
            ],
            'movie' => [
                'add' => '/add-movie/{link}',
                'list' => '/movies',
                'read' => '/movie/{id}',
                'update' => '/update-movie/{id}',
                'delete' => '/delete-movie/{id}',
            ],
        ]);
    }
    
    #[Route('/bookmark/all', name: 'app_bookmark_all')]
    public function allBookmark(): JsonResponse
    {
        $datas = [];
        //TODO

        return $this->json($datas);
    }

}
