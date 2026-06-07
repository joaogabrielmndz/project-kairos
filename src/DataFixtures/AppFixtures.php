<?php

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\Category;
use App\Entity\Departament;
use App\Entity\TicketType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('joao.suporte@empresa.com');
        $admin->setFullName('João Gabriel (Técnico)');

        $adminPasswordHash = $this->hasher->hashPassword($admin, 'demo1234');
        $admin->setPassword($adminPasswordHash);

        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $this->addReference('user_tecnico', $admin);

        $requester = new User();
        $requester->setEmail('usuario.comum@empresa.com');
        $requester->setFullName('Usuário Solicitante');

        $requesterPasswordhash = $this->hasher->hashPassword($requester, 'demo1234');
        $requester->setPassword($requesterPasswordhash);

        $requester->setRoles(['ROLE_USER']);

        $manager->persist($requester);
        $this->addReference('user_solicitante', $requester);

        $departments = ['Hardware - Usuário Final', 'Infraestrutura de Redes', 'Suporte N1'];
        foreach ($departments as $index => $name) {
            $dept = new Departament();
            $dept->setName($name);
            $manager->persist($dept);
            $this->addReference('dept_' . $index, $dept);
        }

        $categories = ['TI - Incidente Técnico', 'TI - Requisição de Serviço'];
        foreach ($categories as $index => $name) {
            $cat = new Category();
            $cat->setName($name);
            $manager->persist($cat);
            $this->addReference('cat_' . $index, $cat);
        }

        $types = ['Mouse com fio', 'Teclado Padrão', 'Notebook Corporativo'];
        foreach ($types as $index => $name) {
            $type = new TicketType();
            $type->setName($name);
            $manager->persist($type);
            $this->addReference('type_' . $index, $type);
        }

        $actions = ['Manutenção Corretiva', 'Empréstimo Temporário', 'Substituição de Ativo'];
        foreach ($actions as $index => $label) {
            $action = new Action();
            $action->setLabel($label);
            $manager->persist($action);
            $this->addReference('action_' . $index, $action);
        }

        $manager->flush();
    }
}
