<?php

namespace App\Entity;

use App\Repository\MenuFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
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


#[ORM\Entity(repositoryClass: MenuFriteRepository::class)]
class MenuFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["read:menu"])]
    private $qte=1;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'menuFrites')]
    #[Groups(["read:menu"])]
    private $portionfrite;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'menufrites')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

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

    public function getPortionfrite(): ?PortionFrite
    {
        return $this->portionfrite;
    }

    public function setPortionfrite(?PortionFrite $portionfrite): self
    {
        $this->portionfrite = $portionfrite;

        return $this;
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
            $menu->addMenufrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeMenufrite($this);
        }

        return $this;
    }


    hjdjcjqsjcklqslmqsmlqslmlmq{
        klsqksdds kjskjqsokj
    }
}
