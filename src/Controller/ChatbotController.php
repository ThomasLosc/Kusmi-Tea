<?php

namespace App\Controller;

use App\Conversation\TestConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Routing\Annotation\Route;

class ChatbotController extends AbstractController
{
    /**
     * @Route("/botman", name="botman")
     */
    public function handle(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [
            'web' => [
                'matchingData' => [
                    'driver' => 'web',
                ],
            ],
        ];

        $adapter = new FilesystemAdapter();
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));
        
        $botman->hears('{message}', function($bot, $firstName) {
            $bot->startConversation(new TestConversation($firstName));
        });

        $botman->listen();

        exit;
    }

     /**
     * @Route("/botman/chat", name="botman_chat")
     */
    public function chatWidget(): Response
    {
        return $this->render('chatbot/index.html.twig');
    }
}
