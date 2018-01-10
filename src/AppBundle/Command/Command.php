<?php

namespace AppBundle\Command;


use AppBundle\Entity\Customer;
use AppBundle\Entity\Phone;
use FacebookConnectionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bilemo:fixtures')
            ->setDescription('Fill the database with example fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $path = $this->getContainer()->get('kernel');

        $phones = Yaml::parse(file_get_contents($path->locateResource('@AppBundle/Resources/command/phones.yml'), true));
        $customers = Yaml::parse(file_get_contents($path->locateResource('@AppBundle/Resources/command/customers.yml'), true));
        $foreignCustomers = Yaml::parse(file_get_contents($path->locateResource('@AppBundle/Resources/command/foreign_customers.yml'), true));
        $foreignUsers = Yaml::parse(file_get_contents($path->locateResource('@AppBundle/Resources/command/foreign_users.yml'), true));

        foreach($phones as $item)
        {
            $phone = new Phone();
            $phone->setModel($item['model']);
            $phone->setBrand($item['brand']);
            $phone->setDescription($item['description']);
            $phone->setPrice($item['price']);
            $phone->setColor($item['color']);
            $phone->setStock($item['stock']);

            $em->persist($phone);
        }
        $em->flush();

        foreach($customers as $item)
        {
            $customer = new Customer();
            $customer->setUsername($item['username']);
            $customer->setEmail($item['email']);
            $customer->setPassword($item['password']);
            $customer->setFirstName($item['first_name']);
            $customer->setLastName($item['last_name']);
            $user = $this->getContainer()->get('doctrine')->getRepository('FacebookConnectionBundle:User')->findOneBy(array("id" => "1"));
            $customer->setUser($user);

            $em->persist($customer);
        }
        $em->flush();

        foreach($foreignUsers as $item)
        {
            $foreignUser = new User($item['facebookId'], $item['username'], $item['email'], $item['gender'], $item['first_name'], $item['last_name'], $item['accessToken']);

            $em->persist($foreignUser);
        }
        $em->flush();

        foreach($foreignCustomers as $item)
        {
            $foreignCustomer = new Customer();
            $foreignCustomer->setUsername($item['username']);
            $foreignCustomer->setEmail($item['email']);
            $foreignCustomer->setPassword($item['password']);
            $foreignCustomer->setFirstName($item['first_name']);
            $foreignCustomer->setLastName($item['last_name']);
            $user = $this->getContainer()->get('doctrine')->getRepository('FacebookConnectionBundle:User')->findOneBy(array("id" => "2"));
            $foreignCustomer->setUser($user);

            $em->persist($foreignCustomer);
        }
        $em->flush();
    }
}