<?php

namespace App\Services;

use App\Repository\BookmarkRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookmarkServices
{
    public function __construct(
        private EntityManagerInterface $entityManager ,
        private BookmarkRepository $bookmarkRepository,
        private PictureServices $pictureServices,
        private MovieServices $movieServices,
    ){
    }

    public function add($link): ?array
    {
        // For this api I test if the link comes from fickr (only for photos)
        // otherwise I consider it a link to a video
        return strpos($link, 'flickr.com/photos') ? $this->pictureServices->addPicture($link) : $this->movieServices->addMovie($link) ;
    }


    public function getAll() : ?array {
        
        $bookmarks = $this->bookmarkRepository->getBookmarks();

        foreach ($bookmarks as $bookmark) {
            $bookmarkData = [
                'link' => $bookmark->getLink(),
                'title' => $bookmark->getTitle(),
                'author' => $bookmark->getAuthor(),
                'createdAt' => $bookmark->getCreatedAt(),
            ];

            // Picture or Movie ?
            if ($bookmark->getPicture()) {
                $bookmarkData['type'] = "picture";
                $bookmarkData['picture'] = [];
                $picture = $bookmark->getPicture();
                $bookmarkData['picture']['height'] = $picture->getHeight();
                $bookmarkData['picture']['width'] = $picture->getWidth();
            }

            if ($bookmark->getMovie()) {
                $bookmarkData['type'] = "movie";
                $bookmarkData['movie'] = [];
                $picture = $bookmark->getMovie();
                $bookmarkData['movie']['height'] = $picture->getHeight();
                $bookmarkData['movie']['width'] = $picture->getWidth();
                $bookmarkData['movie']['duration'] = $picture->getDuration();
            }

            $datas[] = $bookmarkData;
        }

        return $datas;
    }

    public function getOneById($id) : ?array {
        $bookmark = $this->bookmarkRepository->getOneBookmark($id);
        $bookmarkData = [
                'link' => $bookmark->getLink(),
                'title' => $bookmark->getTitle(),
                'author' => $bookmark->getAuthor(),
                'createdAt' => $bookmark->getCreatedAt(),
            ];

            // Picture or Movie ?
            if ($bookmark->getPicture()) {
                $bookmarkData['type'] = "picture";
                $bookmarkData['picture'] = [];
                $picture = $bookmark->getPicture();
                $bookmarkData['picture']['height'] = $picture->getHeight();
                $bookmarkData['picture']['width'] = $picture->getWidth();
            }

            if ($bookmark->getMovie()) {
                $bookmarkData['type'] = "movie";
                $bookmarkData['movie'] = [];
                $picture = $bookmark->getMovie();
                $bookmarkData['movie']['height'] = $picture->getHeight();
                $bookmarkData['movie']['width'] = $picture->getWidth();
                $bookmarkData['movie']['duration'] = $picture->getDuration();
            }

            return $bookmarkData;
    }
}
