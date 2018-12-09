<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;

trait Controller
{
    private $em;
    private $repo;
    private $paginator;

    public function __construct(ObjectManager $em, PropertyRepository $repo, PaginatorInterface $pg)
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->paginator = $pg;
    }
}