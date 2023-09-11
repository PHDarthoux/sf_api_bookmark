<?php

namespace App\Controller;

use App\Repository\BookmarkRepository;
use App\Services\BookmarkServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookmarkController extends AbstractController
{
    #[Route('/bookmark', name: 'app_bookmark')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your Bookmark API!',
            'add bookmark' => '/add-bookmark',
            'list bookmarks' => '/bookmarks',
            'read' => '/bookmark/{id}',
            'delete' => '/delete-bookmark/{id}',
        ]);
    }
    
    #[Route('/add-bookmark', name: 'add_bookmark', methods: 'POST')]
    public function addPicture(Request $request, BookmarkServices $bookmarkServices): JsonResponse
    {
        $link = $request->get("link");
        $array = $bookmarkServices->add($link);

        return $this->json($array);
    }

    #[Route('/bookmarks', name: 'list_bookmarks', methods: 'GET')]
    public function allBookmarks(BookmarkServices $bookmarkServices): JsonResponse
    {
        return $this->json($bookmarkServices->getAll());
    }

    #[Route('/bookmark/{id}', name: 'read_bookmark', methods: 'GET')]
    public function getOneBookmark(Request $request, BookmarkServices $bookmarkServices): JsonResponse
    {
        $id = $request->get("id");
        $datas = $bookmarkServices->getOneById($id);

        return $this->json($datas);
    }

    #[Route('/delete-bookmark/{id}', name: 'delete_bookmark', methods: 'POST')]
    public function deleteOneBookmark(
        Request $request,
        BookmarkRepository $bookmarkRepository,
        EntityManagerInterface $entityManager 
        ): JsonResponse
    {
        $id = $request->get("id");
        $boomark = $bookmarkRepository->find($id);

        if ($boomark === null) {
            return $this->json(['404' => "Boomark not found"]);
        } 

        $entityManager ->remove($boomark);
        $entityManager ->flush();

        return $this->json(['Bookmark Deleted' => $boomark->getLink()]);
    }
}
