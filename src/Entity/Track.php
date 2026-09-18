<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?int $trackNum = null;

    #[ORM\Column]
    private ?int $listenCount = null;

    #[ORM\Column]
    private ?bool $isExplicitLyrics = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    /**
     * @var Collection<int, Style>
     */
    #[ORM\ManyToMany(targetEntity: Style::class, inversedBy: 'tracks')]
    private Collection $styles;

    /**
     * @var Collection<int, Listen>
     */
    #[ORM\OneToMany(targetEntity: Listen::class, mappedBy: 'track')]
    private Collection $listens;

    /**
     * @var Collection<int, Favori>
     */
    #[ORM\OneToMany(targetEntity: Favori::class, mappedBy: 'track')]
    private Collection $favoris;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\ManyToMany(targetEntity: Playlist::class, inversedBy: 'tracks')]
    private Collection $playlists;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
        $this->listens = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTrackNum(): ?int
    {
        return $this->trackNum;
    }

    public function setTrackNum(int $trackNum): static
    {
        $this->trackNum = $trackNum;

        return $this;
    }

    public function getListenCount(): ?int
    {
        return $this->listenCount;
    }

    public function setListenCount(int $listenCount): static
    {
        $this->listenCount = $listenCount;

        return $this;
    }

    public function isExplicitLyrics(): ?bool
    {
        return $this->isExplicitLyrics;
    }

    public function setIsExplicitLyrics(bool $isExplicitLyrics): static
    {
        $this->isExplicitLyrics = $isExplicitLyrics;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): static
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
        }

        return $this;
    }

    public function removeStyle(Style $style): static
    {
        $this->styles->removeElement($style);

        return $this;
    }

    /**
     * @return Collection<int, Listen>
     */
    public function getListens(): Collection
    {
        return $this->listens;
    }

    public function addListen(Listen $listen): static
    {
        if (!$this->listens->contains($listen)) {
            $this->listens->add($listen);
            $listen->setTrack($this);
        }

        return $this;
    }

    public function removeListen(Listen $listen): static
    {
        if ($this->listens->removeElement($listen)) {
            // set the owning side to null (unless already changed)
            if ($listen->getTrack() === $this) {
                $listen->setTrack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favori $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setTrack($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getTrack() === $this) {
                $favori->setTrack(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        $this->playlists->removeElement($playlist);

        return $this;
    }
}
