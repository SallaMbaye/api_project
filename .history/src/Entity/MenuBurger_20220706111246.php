<?php

namespace App\Entity;

use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(

    collectionOperations:["get"
    
    
    ,
    
    
    
    "post"=>[

        'denormalization_context' => ['groups' => ['read:menu']]
    ]

],
    itemOperations:["get","put"]



)]

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["read:menu"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["read:menu"])]
    private $qte=1;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    private $burger;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'menuburgers')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

   /*  #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menuBurgers')]
    private $taille;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'menuBurgers')]
    private $portionfrite;
 */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    /* public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPortionfrite(): ?PortionFrite
    {
        return $this->portionfrite;
    }

    public function setPortionfrite(?PortionFrite $portionfrite): self
    {
        $this->portionfrite = $portionfrite;

        return $this;
    } */

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
            $menu->addMenuburger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeMenuburger($this);
        }

        return $this;
    }
}
