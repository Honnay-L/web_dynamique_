<?php

namespace App\Controller;

use App\Entity\Addfirstname;
use App\Entity\Firstname;
use App\Entity\Problem;
use App\Entity\Usersite;
use App\Form\AddfirstnameType;
use App\Form\ProblemType;
use App\Form\UserProfileType;
use App\Repository\AddfirstnameRepository;
use App\Repository\FirstnameRepository;
use App\Repository\ProblemRepository;
use App\Repository\UsersiteRepository;
use App\Search\Search;
use App\Service\PhotoUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends AbstractController
{
    //les différentes routes du controller

    /**
     * @Route("/addname", name="addfirstname")
     */
    public function createfirstname(Request $request, EntityManagerInterface $em): Response
    {

        $addfirstname = new Addfirstname();
        $form = $this->createForm(AddfirstnameType::class, $addfirstname);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($addfirstname);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/addname.html.twig', ['AddfirstnameForm' => $form->createview()]);
    }


    /**
     * @Route("/profile/{id}", name="profile")
     */
    function profile(int $id,Request $request,PhotoUploader $photoUploader,UsersiteRepository $usersiteRepository,Usersite $usersite,EntityManagerInterface $em)
    {
        $user = $usersiteRepository->find($id);
        $userco = $this->getUser();
        if($user !== $userco){
            throw new AccessDeniedException();
        }
            $form = $this->createForm(UserProfileType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPhoto($photoUploader->uploadPhoto($form->get('photo')));
                if ($user->getPhoto() != null) {
                    $em->persist($user->getPhoto());
               // }else{
               //     $user->setPhoto($user->getPhoto());
                //    $em->persist($user->getPhoto());
                }
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('profile', ['id' => $user->getId()]);
            }
            return $this->render('pages/profile.html.twig', ['user'=>$user, 'userForm' => $form->createView()]);
    }

    /**
     * @Route("/content", name="content")
     */
    public function displayfirstname(FirstnameRepository $firstnameRepository, Request $request,PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {


        $datas = $firstnameRepository->findAll();

        $firstnames = $paginator->paginate(
            $datas,   //on donne les données
            $request->query->getInt('page', 1),  // le numéro de la page en cours(1 par default)
            10  // nombre d'élément par pages.
        );
        $problem = new Problem();
        $form = $this->createForm(ProblemType::class, $problem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($problem);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('pages/content.html.twig', ['firstnames' => $firstnames, 'problemForm' => $form->createview()]);

    }

    /**
     * @Route("/", name="home")
     */
    public
    function displayfirstnamehome(FirstnameRepository $firstnameRepository, EntityManagerInterface $em, Request $request): Response
    {
        //modifier l'id par le nombre de like.
        $firstnames = $firstnameRepository->findBy([], ['date' => 'desc'], 10, 0);

        $problem = new Problem();
        $form = $this->createForm(ProblemType::class, $problem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($problem);
            $em->flush();
            return $this->redirectToRoute('home');

        }


        return $this->render('pages/home.html.twig', ['firstnames' => $firstnames, 'problemForm' => $form->createview()]);

    }



}