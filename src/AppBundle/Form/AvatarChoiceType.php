<?php
/**
 * AvatarChoiceType.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvatarChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'choices' => [
                    "american-football-player" => "american-football-player",
                    "baseball-player"          => "baseball-player",
                    "basketball-player-1"      => "basketball-player-1",
                    "basketball-player"        => "basketball-player",
                    "boxer"                    => "boxer",
                    "climber"                  => "climber",
                    "cricket-player"           => "cricket-player",
                    "cyclist"                  => "cyclist",
                    "driver"                   => "driver",
                    "fencer"                   => "fencer",
                    "gymnast"                  => "gymnast",
                    "horsewoman"               => "horsewoman",
                    "karate"                   => "karate",
                    "mountaineer"              => "mountaineer",
                    "referee"                  => "referee",
                    "runner"                   => "runner",
                    "scuba-diver"              => "scuba-diver",
                    "snowboarder"              => "snowboarder",
                    "soccer-player-1"          => "soccer-player-1",
                    "soccer-player-2"          => "soccer-player-2",
                    "soccer-player"            => "soccer-player",
                    "sportswear-1"             => "sportswear-1",
                    "sportswear-2"             => "sportswear-2",
                    "sportswear"               => "sportswear",
                    "sumotori"                 => "sumotori",
                    "swimmer-1"                => "swimmer-1",
                    "swimmer"                  => "swimmer",
                    "tennis-player-1"          => "tennis-player-1",
                    "tennis-player"            => "tennis-player",
                    "wrestler"                 => "wrestler",
                ],
            ]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }


}