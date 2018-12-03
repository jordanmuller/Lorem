<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;

trait Controller
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }
}