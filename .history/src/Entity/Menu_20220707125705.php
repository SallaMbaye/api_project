<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AssertValide;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    
    collectionOperations:[
        
        'get' => [
            
                'method' => 'get',

                'normalization_context' => ['groups' => ['affiche']]
            
            ],
    
        "post"=>[

            'method'=>'post',
       
            'denormalization_context' => ['groups' => ['read:menu','write','frite:menu',"boisson:menu","read:commande"]]

        ]
    ],

    subresourceOperations : [

        [
            'burgersmenu' => [

                'method' => 'get',
                
                'normalization_context' => ['groups' => ['foobar']],

                'security' => "is_granted('ROLE_GESTIONNAIRE')"


            ],
        ],

      
    ],
    itemOperations:["put"=>[

        'method'=>'put',
       
        'denormalization_context' => ['groups' => ['read:menu','write','frite:menu',"boisson:menu"]]


    ],"get","delete"]
)]
//#[Assert\Callback([Validator::class, 'validate'])]

class Menu extends Produit
{
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["read:menu","affiche"])]
    private $gestionnaire;

   

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    #[ORM\ManyToMany(targetEntity: MenuFrite::class, inversedBy: 'menus',cascade:['persist'])]
    #[Groups(["read:menu","affiche"])]
    #[AssertValide\ConstraintMenu]
    #[Assert\Valid()]
    private $menufrites;

    #[ORM\ManyToMany(targetEntity: MenuTaille::class, inversedBy: 'menus',cascade:['persist'])]
    #[Groups(["read:menu","affiche"])]
    #[Assert\Valid()]
    #[AssertValide\ConstraintMenu]
    private $menutailles;

    #[ORM\ManyToMany(targetEntity: MenuBurger::class, inversedBy: 'menus',cascade:['persist'])]
    #[Assert\Count(['min' => 1])]
    #[Groups(["read:menu","affiche"])]
    #[AssertValide\ConstraintMenu]
    #[Assert\Valid()]
    private $menuburgers;

   

   
    public function __construct()
    {

        $this->menufrites = new ArrayCollection();
        $this->menutailles = new ArrayCollection();
        $this->menuburgers = new ArrayCollection();
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
   /*  public function getPortionFrites(): Collection
    {
        return $this->portionFrites;
    } */

   /*  public function addPortionFrite(PortionFrite $portionFrite): self
    {
        if (!$this->portionFrites->contains($portionFrite)) {
            $this->portionFrites[] = $portionFrite;
            $portionFrite->addMenu($this);
        }

        return $this;
    }
 */
    /* public function removePortionFrite(PortionFrite $portionFrite): self
    {
        if ($this->portionFrites->removeElement($portionFrite)) {
            $portionFrite->removeMenu($this);
        }

        return $this;
    } */

    
   /*  public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {

            $this->burgers[] = $burger;
            
            $burger->addMenu($this);
        }

        return $this;
    } */

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
   /*  public function getBoissons(): Collection
    {
        return $this->boissons;
    } */

   /*  public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    } */

   /*  public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }
 */
    /**
     * @return Collection<int, Taille>
     */
    /* public function getTailles(): Collection
    {
        return $this->tailles;
    } */

    /* public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    } */

    /* public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

        return $this;
    } */

    /**
     * @return Collection<int, Commande>
     */
   /*  public function getCommandes(): Collection
    {
        return $this->commandes;
    } */

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addMenu($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    /* public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    } */

    /* public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }
 */

    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenufrites(): Collection
    {
        return $this->menufrites;
    }

    public function addMenufrite(MenuFrite $menufrite): self
    {
        if (!$this->menufrites->contains($menufrite)) {

            $this->menufrites[] = $menufrite;
        }

        return $this;
    }

    public function removeMenufrite(MenuFrite $menufrite): self
    {
        $this->menufrites->removeElement($menufrite);

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenutailles(): Collection
    {
        return $this->menutailles;
    }

    public function addMenutaille(MenuTaille $menutaille): self
    {
        if (!$this->menutailles->contains($menutaille)) {
            $this->menutailles[] = $menutaille;
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        $this->menutailles->removeElement($menutaille);

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuburgers(): Collection
    {
        return $this->menuburgers;
    }

    public function addMenuburger(MenuBurger $menuburger): self
    {
        if (!$this->menuburgers->contains($menuburger)) {
            $this->menuburgers[] = $menuburger;
        }

        return $this;
    }

    public function removeMenuburger(MenuBurger $menuburger): self
    {
        $this->menuburgers->removeElement($menuburger);

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (count($this->getMenufrites())<0 && count($this->getMenufrites())<0  ) {
            $context->buildViolation('Au moins un complement !!!')
                ->atPath('menufrites')
                ->atPath('menufritesmenufrites')
                ->addViolation();
        }
        
    }
    
    
    
}
