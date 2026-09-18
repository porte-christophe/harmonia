<?php
    // src/Twig/StyleExtension.php
    namespace App\Twig;

    use Twig\Attribute\AsTwigFunction;
    use App\Repository\StyleRepository;

    class StyleExtension
    {

        public function __construct(
            private StyleRepository $sr
        ){}


        // private StyleRepository $StyleRepository;

        // public function __construct(){
        //     $this->StyleRepository = $StyleRepository
        // }

        #[AsTwigFunction('getStyles')]
        public function getStyles(): array
        {
            $styles = $this->sr->findAll();

            return $styles;
        }
    }
?>