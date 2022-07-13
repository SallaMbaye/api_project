<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]

#[ApiResource(

    collectionOperations:[
        
        "get"=>[ "security" => "is_granted('COMMANDE_ALL',_api_resource_class)"],
        
        "post" => [ 
            
            "security_post_denormalize" => "is_granted('COMMANDE_CREATE', object)",

            'denormalization_context' => ['groups' => ['read:commande']]
    
    
        ],

    ],
    itemOperations:[
        
        "get" => [

            "security" => "is_granted('COMMANDE_ONE', object)" 

        ],
    
        "put"=>[
            
            "security" => "is_granted('COMMANDE_EDIT',object)" 
        ]
    
    ]




)]

//#[Assert\Expression(count($this->getMenus())!=0)]




class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:commande"])]
    private $numero;

    #[ORM\Column(type: 'datetime_immutable')]
    private $commandeAt;

    #[ORM\Column(type: 'integer')]
    #[Groups(["read:commande"])]
    private $qte;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:commande"])]
    private $etat;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["read:commande"])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(["read:commande"])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[Groups(["read:commande"])]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'commandes')]
    //#[Assert\Count(min:1)]
    #[Groups(["read:commande"])]
    private $menus;

    
    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'commandes')]
    #[Groups(["read:commande"])]
    //#[Assert\NotNull(message:"Au moins un burger  !!!")]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'commandes')]
    #[Groups(["read:commande"])]
    private $portionfrites;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->portionfrites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCommandeAt(): ?\DateTimeImmutable
    {
        return $this->commandeAt;
    }

    public function setCommandeAt(\DateTimeImmutable $commandeAt): self
    {
        $this->commandeAt = $commandeAt;

        return $this;
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
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
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

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
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionfrites(): Collection
    {
        return $this->portionfrites;
    }

    public function addPortionfrite(PortionFrite $portionfrite): self
    {
        if (!$this->portionfrites->contains($portionfrite)) {
            $this->portionfrites[] = $portionfrite;
        }

        return $this;
    }

    public function removePortionfrite(PortionFrite $portionfrite): self
    {
        $this->portionfrites->removeElement($portionfrite);

        return $this;
    }
}
