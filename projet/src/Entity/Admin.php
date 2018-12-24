<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
class Admin extends User
{

    public function __toString()
    {
        return 'ADMIN-'.$this->getName();
    }
}
