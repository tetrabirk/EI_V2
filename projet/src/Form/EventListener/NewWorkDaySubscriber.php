<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 28-Jan-19
 * Time: 20:50
 */

namespace App\Form\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class NewWorkDaySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $workday = $event->getData();
        $form = $event->getForm();

        if (!$workday || null === $workday->getId()) {
            dump($workday);
        }
    }
}