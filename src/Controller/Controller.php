<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

trait Controller
{
    private $em;
    private $repo;

    public function __construct(ObjectManager $em, PropertyRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }
}