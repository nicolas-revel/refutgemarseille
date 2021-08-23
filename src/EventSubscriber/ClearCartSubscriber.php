<?php

namespace App\EventSubscriber;

use App\Entity\Cart;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearCartSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents ()
    {
        return [FormEvents::POST_SUBMIT=> 'postSubmit'];
    }

    public function postSubmit (FormEvent $event)
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if (!$cart instanceof Cart) {
            return;
        }

        if ($form->get('clear')->isClicked()) {
            foreach ($form->get('cartHasProducts')->all() as $child) {
                $cart->removeCartHasProduct($child->getData());
            }
        }

    }
}
