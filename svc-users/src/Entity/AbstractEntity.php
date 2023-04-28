<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

class AbstractEntity
{

    #[ORM\Column(type:"datetime")]
    protected DateTime $createdAt;


    #[ORM\Column(type:"datetime")]
    protected DateTime $updatedAt;

    public function setCreatedAt(DateTime $date): void
    {
        $this->createdAt = $date;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(DateTime $date): void
    {
        $this->updatedAt = $date;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
