<?php

namespace App\EventSubscriber;

use App\Entity\Cart;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RemoveCartItemSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    public function postSubmit (FormEvent $event)
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if (!$cart instanceof Cart) {
            return;
        }

        // Removes items from the cart
        foreach ($form->get('cartHasProducts')->all() as $child) {
            if ($child->get('remove')->isClicked()) {
                $cart->removeCartHasProduct($child->getData());
                break;
            }
        }
    }
}
