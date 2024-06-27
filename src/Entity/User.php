<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = 'ROLE_USER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(targetEntity: Adresse::class, mappedBy: 'user')]
    private Collection $adresses;

    #[ORM\Column(type: 'boolean')]
    private ?bool $kusmiklub = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $frequencethe = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $quelThe = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $autreTypeThe = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $quelGout = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $commentConnuKusmiTea = null;

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'user')]
    private Collection $commandes;

    #[ORM\OneToMany(targetEntity: ReferralCode::class, mappedBy: 'user')]
    private Collection $referralCodes;

    #[ORM\OneToMany(targetEntity: Referral::class, mappedBy: 'referrer')]
    private Collection $referrals;

    #[ORM\Column(type: "integer")]
    private int $points = 0;

    #[ORM\OneToMany(targetEntity: PointLog::class, mappedBy: 'user', orphanRemoval: true)]
    private $pointLogs;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->referralCodes = new ArrayCollection();
        $this->referrals = new ArrayCollection();
        $this->pointLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Adresse>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setUser($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUser() === $this) {
                $adress->setUser(null);
            }
        }

        return $this;
    }

    public function isKusmiklub(): ?bool
    {
        return $this->kusmiklub;
    }

    public function setKusmiklub(bool $kusmiklub): static
    {
        $this->kusmiklub = $kusmiklub;

        return $this;
    }

     // getters and setters for new fields
     public function getFrequencethe(): ?string
     {
         return $this->frequencethe;
     }
 
     public function setFrequencethe(?string $frequencethe): self
     {
         $this->frequencethe = $frequencethe;
 
         return $this;
     }
 
     public function getQuelThe(): ?string
     {
         return $this->quelThe;
     }
 
     public function setQuelThe(?string $quelThe): self
     {
         $this->quelThe = $quelThe;
 
         return $this;
     }
 
     public function getAutreTypeThe(): ?string
     {
         return $this->autreTypeThe;
     }
 
     public function setAutreTypeThe(?string $autreTypeThe): self
     {
         $this->autreTypeThe = $autreTypeThe;
 
         return $this;
     }
 
     public function getQuelGout(): ?string
     {
         return $this->quelGout;
     }
 
     public function setQuelGout(?string $quelGout): self
     {
         $this->quelGout = $quelGout;
 
         return $this;
     }
 
     public function getCommentConnuKusmiTea(): ?string
     {
         return $this->commentConnuKusmiTea;
     }
 
     public function setCommentConnuKusmiTea(?string $commentConnuKusmiTea): self
     {
         $this->commentConnuKusmiTea = $commentConnuKusmiTea;
 
         return $this;
     }

     /**
      * @return Collection<int, Commande>
      */
     public function getCommandes(): Collection
     {
         return $this->commandes;
     }

     public function addCommande(Commande $commande): static
     {
         if (!$this->commandes->contains($commande)) {
             $this->commandes->add($commande);
             $commande->setUser($this);
         }

         return $this;
     }

     public function removeCommande(Commande $commande): static
     {
         if ($this->commandes->removeElement($commande)) {
             // set the owning side to null (unless already changed)
             if ($commande->getUser() === $this) {
                 $commande->setUser(null);
             }
         }

         return $this;
     }

    /**
     * @return Collection|ReferralCode[]
     */
    public function getReferralCodes(): Collection
    {
        return $this->referralCodes;
    }

    public function addReferralCode(ReferralCode $referralCode): self
    {
        if (!$this->referralCodes->contains($referralCode)) {
            $this->referralCodes[] = $referralCode;
            $referralCode->setUser($this);
        }

        return $this;
    }

    public function removeReferralCode(ReferralCode $referralCode): self
    {
        if ($this->referralCodes->removeElement($referralCode)) {
            // set the owning side to null (unless already changed)
            if ($referralCode->getUser() === $this) {
                $referralCode->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Referral[]
     */
    public function getReferrals(): Collection
    {
        return $this->referrals;
    }

    public function addReferral(Referral $referral): self
    {
        if (!$this->referrals->contains($referral)) {
            $this->referrals[] = $referral;
            $referral->setReferrer($this);
        }

        return $this;
    }

    public function removeReferral(Referral $referral): self
    {
        if ($this->referrals->removeElement($referral)) {
            // set the owning side to null (unless already changed)
            if ($referral->getReferrer() === $this) {
                $referral->setReferrer(null);
            }
        }

        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function addPoints(int $points): self
    {
        $this->points += $points;
        return $this;
    }

    public function getPointLogs(): Collection
    {
        return $this->pointLogs;
    }

    public function addPointLog(PointLog $pointLog): self
    {
        if (!$this->pointLogs->contains($pointLog)) {
            $this->pointLogs[] = $pointLog;
            $pointLog->setUser($this);
        }

        return $this;
    }

    public function removePointLog(PointLog $pointLog): self
    {
        if ($this->pointLogs->removeElement($pointLog)) {
            // set the owning side to null (unless already changed)
            if ($pointLog->getUser() === $this) {
                $pointLog->setUser(null);
            }
        }

        return $this;
    }
}
