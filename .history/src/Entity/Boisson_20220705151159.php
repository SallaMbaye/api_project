<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(

    collectionOperations:["get","post"=>[

        'method'=>'post',

        'denormalization_context' => ['groups' => ['boisson:menu']],

        'security' => "is_granted('ROLE_GESTIONNAIRE')",

        'security_message' => "Vous n'avez pas access à cette ressource"

    ]],
    itemOperations:["put","get","delete"]
)]
class Boisson extends Produit
{
    

   

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissons')]
    private $taille;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    private $menus;

   /*  #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'boissons')]
    private $complement; */

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

   /*  public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
 */
    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBoisson($this);
        }

        return $this;
    }

    /* public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self
    {
        $this->complement = $complement;

        return $this;
    } */

    

   

    

   
}
