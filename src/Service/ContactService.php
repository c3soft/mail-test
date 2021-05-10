<?php

namespace App\Service;

use DateTime;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function persistContact(Contact $contact)
    {
        $contact->setIsSend(false)
                ->setCreatedAt(new DateTime('now'));
        
        $this->manager->persist($contact);
        $this->manager->flush();
        $this->flash->add('success', 'Message enregistré !');
    }
}
