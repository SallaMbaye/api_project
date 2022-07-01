<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    
    collectionOperations:["get"=>[

        'security' => "is_granted('ROLE_GESTIONNAIRE')",

        'normalization_context' => ['groups' => ['affiche']],

        'security_message' => "Vous n'avez pas access à cette ressource",  

    ],
    "post"=>[
        

    ]

    ],
    
    itemOperations:["put",
    
    "get"=>[
        
        'denormalization_context' => ['groups' => ['gestionnaire']],

        'security' => "is_granted('ROLE_GESTIONNAIRE')",

        'security_message' => "Vous n'avez pas access à cette ressource",

    ],
    
    "delete"]
)]


class Gestionnaire extends User
{
    
    
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Menu::class)]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Burger::class)]
    private $burgers;

   

    
    
    
    public function __construct()
    {
        $this->setRoles(["ROLE_GESTIONNAIRE"]);
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
    }



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
            $menu->setGestionnaire($this);
        }

        return $this;
    }



    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getGestionnaire() === $this) {
                $menu->setGestionnaire(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setGestionnaire($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getGestionnaire() === $this) {
                $burger->setGestionnaire(null);
            }
        }

        return $this;
    }

   



    


}
