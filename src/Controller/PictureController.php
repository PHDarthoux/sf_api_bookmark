<?php

namespace App\Controller;

use App\Services\PictureServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/add-picture', name: 'add_picture', methods: 'POST')]
    public function addPicture(Request $request, PictureServices $pictureServices): JsonResponse
    {
        $link = $request->get("link");
        // $link = "https://www.flickr.com/photos/126579629@N06/40770662832/";

        $array = $pictureServices->add($link);

        return $this->json($array);
    }

    #[Route('/pictures', name: 'list_pictures')]
    public function allPictures(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }

    #[Route('/picture/{id}', name: 'read_picture')]
    public function readPicture(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }

    #[Route('/update-picture/{id}', name: 'update_picture')]
    public function updatePicture(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }

    #[Route('/delete-picture/{id}', name: 'delete_picture')]
    public function deletePicture(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }
}
