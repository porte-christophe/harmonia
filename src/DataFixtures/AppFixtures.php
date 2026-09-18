<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\StyleFactory;
use App\Factory\ArtistFactory;
use App\Factory\AlbumFactory;
use App\Factory\UserFactory;
use App\Factory\TrackFactory;
use App\Factory\PlaylistFactory;
use App\Factory\FavoriFactory;
use App\Factory\ListenFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $styles =[
            "Rock" => "#7D0085",
            "Metal" => "#000000",
            "Classique" => "#FFFFFF",
            "Punk" => "#007A13",
            "Baroque" =>"#5C4E25",
            "Orchestrale" => "#2E3FBF"];
        foreach ($styles as $key => $value) {
            StyleFactory::createOne([
                'name' => $key,
                'color' =>$value
            ]);
        }
        
        ArtistFactory::createMany(15);
        AlbumFactory::createMany(30);
        UserFactory::createMany(300);
        TrackFactory::createMany(150);
        PlaylistFactory::createMany(600);
        FavoriFactory::createMany(30);
        ListenFactory::createMany(1000);







        $manager->flush();
    }
}
