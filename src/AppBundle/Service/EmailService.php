<?php
namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class EmailService{

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function send($user, $event, $entity)
    {
        $twig = $this->container->get('templating');
        $message = \Swift_Message::newInstance()
            ->setSubject('Сообщение с сайта PhAdDb Planner')
            ->setFrom('PhAdDbPlanner@gmail.com')
            ->setTo('bhd.m@ya.ru')
            ->setBody(
                $twig->render(
                    'AppBundle:Mail:notify.html.twig',
                    array(
                        'user' => $user,
                        'event' => $event,
                        'entity' => $entity
                    )
                ),
                'text/html'
            )

        ;
        $this->container->get('mailer')->send($message);
    }
}