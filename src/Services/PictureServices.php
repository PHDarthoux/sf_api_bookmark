<?php

namespace App\Services;

use App\Entity\Bookmark;
use App\Entity\Picture;
use App\Repository\PictureRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Embed\Embed;

class PictureServices
{
    public function __construct(
        private EntityManagerInterface $entityManager ,
        private PictureRepository $pictureRepository,
    ){
    }

    public function addPicture($link) : ?array {
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


        $this->entityManager->persist($picture);
        $this->entityManager->persist($bookmark);
        $this->entityManager->flush();

        $array =[
            '200' => 'success',
            'link' => $bookmark->getLink(),
            'title' => $bookmark->getTitle(),
            'author' => $bookmark->getAuthor(),
            'createdAt' => $bookmark->getCreatedAt(),
            'height' => $bookmark->getPicture()->getHeight(),
            'width' => $bookmark->getPicture()->getWidth(),
        ];

        return $array;
    }
}