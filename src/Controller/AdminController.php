<?php

namespace App\Controller;

use App\Entity\Addfirstname;
use App\Entity\Firstname;
use App\Repository\AddfirstnameRepository;
use App\Repository\ProblemRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("admin/mail/firstname", name="addfirstname")
     */
    public function addfirstname(AddfirstnameRepository $addfirstnameRepository, Request $request, EntityManagerInterface $em): Response
    {
        $addfirstnames = $addfirstnameRepository->findAll();

        return $this->render('admin/mailfirstname.html.twig', ['addfirstnames' => $addfirstnames]);

    }
    /**
     * @Route("delete/{id}", name="firstname_delete")
     */

    public function delete(EntityManagerInterface $em, Addfirstname $addfirstname,int $id){

        $em->remove($addfirstname);
        $em->flush();
        return $this->redirectToRoute('addfirstname');

    }
    /**
     * @Route("add/{id}", name="firstname_add")
     */

    public function addbutton(EntityManagerInterface $em, Addfirstname $addfirstname,int $id){

        $firstname = new Firstname();
        $firstname->setFirstname($addfirstname->getFirstname());
        $firstname->setDescription($addfirstname->getDescription());
        $firstname->setOrigin($addfirstname->getOrigin());
        $em->persist($firstname);
        $em->remove($addfirstname);
        $em->flush();
        return $this->redirectToRoute('addfirstname');

    }


    /**
     * @Route("admin/mail/problem", name="mailproblem")
     */
    public function mailproblem(ProblemRepository $problemRepository): Response
    {
        $problems = $problemRepository->findAll();

        return $this->render('admin/mailproblem.html.twig', ['problems' => $problems]);

    }


}