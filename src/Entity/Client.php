<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]

#[ApiResource(

    /* attributes: [

        "security" => "is_granted('ROLE_GESTIONNAIRE')",

        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ], */

    collectionOperations:["get","post"],

    itemOperations:["put","get"]
)]
class Client extends User
{
    public function __construct()
    {
        $this->setRoles(["ROLE_CLIENT"]);
    }

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Adresse Obligatoire !!!")]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Telephone Obligatoire !!!")]
    private $telephone;

   
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
