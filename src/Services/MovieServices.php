<?php

namespace App\Services;

use App\Entity\Bookmark;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Embed\Embed;

class MovieServices
{
    public function __construct(
        private EntityManagerInterface $emi,
        private MovieRepository $movieRepository,
    ) {
    }

    public function addMovie($link): ?array
    {
        $embed = new Embed();
        //Load any url:
        $info = $embed->get($link);

        $movie = new Movie();
        $movie->setHeight($info->code->height);
        $movie->setWidth($info->code->width);
        // $movie->setDuration($info->duration); // TODO

        $bookmark = new Bookmark();
        $bookmark->setLink($link);
        $bookmark->setTitle($info->title);
        
        $info->authorName != null ? $bookmark->setAuthor($info->authorName) : $bookmark->setAuthor("no author specified");
        $bookmark->setCreatedAt(new DateTimeImmutable());
        $bookmark->setMovie($movie);


        $this->emi->persist($movie);
        $this->emi->persist($bookmark);
        $this->emi->flush();

        $array = [
            '200' => 'success',
            'link' => $bookmark->getLink(),
            'title' => $bookmark->getTitle(),
            'author' => $bookmark->getAuthor(),
            'createdAt' => $bookmark->getCreatedAt(),
            'height' => $bookmark->getMovie()->getHeight(),
            'width' => $bookmark->getMovie()->getWidth(),
            'duration' => $bookmark->getMovie()->getDuration(),
        ];

        return $array;
    }
}
