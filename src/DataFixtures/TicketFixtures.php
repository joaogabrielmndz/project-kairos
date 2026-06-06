<?php

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\Category;
use App\Entity\Departament;
use App\Entity\Ticket;
use App\Entity\TicketType;
use App\Entity\User;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ticket1 = new Ticket();
        $ticket1->setTitle('Mouse óptico não liga');
        $ticket1->setDescription('O mouse parou de acender a luz vermelha e o cursor não mexe na tela do Fedora.');
        $ticket1->setTicketNumber('2026000001');
        $ticket1->setStatus(TicketStatus::PENDING);
        $ticket1->setPriority(TicketPriority::MEDIUM);
        
        $ticket1->setRequester($this->getReference('user_solicitante', User::class));
        $ticket1->setDepartament($this->getReference('dept_0', Departament::class)); // Hardware - Usuário Final
        $ticket1->setCategory($this->getReference('cat_0', Category::class));    // TI - Incidente Técnico
        $ticket1->setTicketType($this->getReference('type_0', TicketType::class));  // Mouse com fio
        $ticket1->setAction($this->getReference('action_0', Action::class));    // Manutenção Corretiva
        $ticket1->setMetaData(['patrimonio' => 'RBS-10293', 'so' => 'Fedora KDE']);
        $manager->persist($ticket1);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }
}