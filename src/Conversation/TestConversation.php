<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class TestConversation extends Conversation
{
    protected $firstName;
    protected $taste;
    protected $timeOfDay;
    protected $caffeineSensitivity;

    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function run()
    {
        $this->askIfNeedHelp();
    }

    public function askIfNeedHelp()
    {
        $question = Question::create("Bonjour {$this->firstName} ! Comment puis-je vous aider ?")
            ->addButtons([
                Button::create('Quelles sont les valeurs de Kusmi Tea ?')->value('values'),
                Button::create('Quel thé choisir ?')->value('whichTea'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();

                if($selectedValue === "whichTea") {
                    $this->whichTea();
                } elseif($selectedValue === "values") {
                    $this->valuesKusmiTea();
                }
            }
        });
    }

    public function askIfNeedHelpAgain()
    {
        $question = Question::create('Avez-vous une autre question ?')
            ->addButtons([
                Button::create('Quelles sont les valeurs de Kusmi Tea ?')->value('values'),
                Button::create('Quel thé choisir ?')->value('whichTea'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();

                if($selectedValue === "whichTea") {
                    $this->whichTea();
                } elseif($selectedValue === "values") {
                    $this->valuesKusmiTea();
                }
            }
        });
    }

    public function whichTea() {
        $question = Question::create('Tout dépend de vos goûts ! Vous êtes plutôt...')
            ->addButtons([
                Button::create('Astringent et fort')->value('astringent'),
                Button::create('Doux et floral')->value('doux'),
                Button::create('Léger et délicat')->value('leger'),
                Button::create('Fruité et sucré')->value('fruite'),
                Button::create('Terreux et noisette')->value('terreux'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->taste = $answer->getValue();
                $this->askTimeOfDay();
            }
        });
    }

    public function askTimeOfDay()
    {
        $question = Question::create("À quel moment de la journée allez-vous boire votre thé ?")
            ->addButtons([
                Button::create('Le matin')->value('matin'),
                Button::create('L\'après-midi')->value('apres-midi'),
                Button::create('Le soir')->value('soir'),
                Button::create('Toute la journée')->value('toute-la-journee'),
            ]);

        $this->ask($question, function (Answer $answer) {
            $this->timeOfDay = $answer->getValue();
            $this->askCaffeineSensitivity();
        });
    }

    public function askCaffeineSensitivity()
    {
        $question = Question::create("Quelle est votre sensibilité à la caféine ?")
            ->addButtons([
                Button::create('J\'ai besoin de beaucoup de caféine')->value('beaucoup'),
                Button::create('Une petite quantité de caféine me convient')->value('peu'),
                Button::create('Je préfère sans caféine')->value('sans-cafeine'),
                Button::create('Je suis très sensible à la caféine')->value('sensible'),
            ]);

        $this->ask($question, function (Answer $answer) {
            $this->caffeineSensitivity = $answer->getValue();
            $this->recommendTea();
        });
    }

    public function recommendTea()
    {
        $recommendation = '';

        if ($this->taste == 'astringent') {
            if ($this->timeOfDay == 'matin' && $this->caffeineSensitivity == 'beaucoup') {
                $recommendation = 'Je vous recommande le thé noir.';
            } elseif ($this->timeOfDay == 'apres-midi' && $this->caffeineSensitivity == 'peu') {
                $recommendation = 'Je vous recommande le thé vert.';
            } elseif ($this->timeOfDay == 'soir' && ($this->caffeineSensitivity == 'sans-cafeine' || $this->caffeineSensitivity == 'sensible')) {
                $recommendation = 'Je vous recommande une tisane sans caféine.';
            }
        } elseif ($this->taste == 'doux') {
            if ($this->timeOfDay == 'soir' && ($this->caffeineSensitivity == 'sans-cafeine' || $this->caffeineSensitivity == 'sensible')) {
                $recommendation = 'Je vous recommande les infusions et tisanes.';
            } elseif ($this->timeOfDay == 'apres-midi' && $this->caffeineSensitivity == 'peu') {
                $recommendation = 'Je vous recommande le thé blanc.';
            }
        } elseif ($this->taste == 'léger') {
            if ($this->timeOfDay == 'apres-midi' && $this->caffeineSensitivity == 'peu') {
                $recommendation = 'Je vous recommande le thé blanc.';
            } elseif ($this->timeOfDay == 'toute-la-journee' && ($this->caffeineSensitivity == 'peu' || $this->caffeineSensitivity == 'sensible')) {
                $recommendation = 'Je vous recommande le thé vert.';
            }
        } elseif ($this->taste == 'fruite') {
            if ($this->timeOfDay == 'soir' && ($this->caffeineSensitivity == 'sans-cafeine' || $this->caffeineSensitivity == 'sensible')) {
                $recommendation = 'Je vous recommande le rooibos ou une infusion fruitée.';
            } elseif ($this->timeOfDay == 'apres-midi' && $this->caffeineSensitivity == 'peu') {
                $recommendation = 'Je vous recommande le thé vert aux fruits.';
            }
        } elseif ($this->taste == 'terreux') {
            if ($this->timeOfDay == 'toute la journée' && ($this->caffeineSensitivity == 'sans-cafeine' || $this->caffeineSensitivity == 'sensible')) {
                $recommendation = 'Je vous recommande le rooibos.';
            } elseif ($this->timeOfDay == 'matin' && $this->caffeineSensitivity == 'beaucoup') {
                $recommendation = 'Je vous recommande un thé noir aux notes terreuses.';
            }
        }

        if (empty($recommendation)) {
            $recommendation = 'Je vous recommande d\'explorer différents types de thé pour trouver celui qui vous convient le mieux.';
        }

        $this->say($recommendation);
        $this->askIfNeedHelpAgain();
    }

    public function valuesKusmiTea()
    {
        $this->say("Kusmi Tea est centré sur la qualité, l'innovation, et la durabilité. Nous nous engageons à offrir des thés de haute qualité tout en respectant l'environnement et en soutenant des pratiques durables. Nous valorisons également l'innovation en proposant des mélanges uniques et créatifs pour satisfaire tous les goûts.");
        $this->askIfNeedHelpAgain();
    }
}