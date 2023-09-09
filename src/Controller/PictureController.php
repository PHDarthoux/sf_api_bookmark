<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Entity\Picture;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Embed\Embed;

class PictureController extends AbstractController
{
    #[Route('/add-picture/{link}', name: 'add_picture')]
    public function addPicture(Request $request, EntityManagerInterface $emi): JsonResponse
    {
        $link = $request->get("link");
        $link = "https://www.flickr.com/photos/126579629@N06/40770662832/";

        $embed = new Embed();
        //Load any url:
        $info = $embed->get($link);

        $picture = new Picture();
        $picture->setHeight($info->code->height);
        $picture->setWidth($info->code->width);

        $bookmark = new Bookmark();
        $bookmark->setLink($link);
        $bookmark->setTitle($info->title);
        $bookmark->setAuthor($info->authorName);
        $bookmark->setCreatedAt(new DateTimeImmutable());
        $bookmark->setPicture($picture);


        $emi->persist($picture);
        $emi->persist($bookmark);
        $emi->flush();

        return $this->json([
            '200' => 'success',
            'link' => $bookmark->getLink(),
            'title' => $bookmark->getTitle(),
            'author' => $bookmark->getAuthor(),
            'createdAt' => $bookmark->getCreatedAt(),
            'height' => $bookmark->getPicture()->getHeight(),
            'width' => $bookmark->getPicture()->getWidth(),
        ]);
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
