<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        $this->commandes = new ArrayCollection();
    }

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Adresse Obligatoire !!!")]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Telephone Obligatoire !!!")]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;

   
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
