<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiServiceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('servi_service/home.html.twig');
    }
   
    /**
     * @Route("/servi/service", name="servi_service.servi_service.affiche")
     */
    public function service(ServiceRepository $repos)
    {   $service = $repos->findAll();
        return $this->render('servi_service/index.html.twig', [
            'services' => $service,
        ]);
    }
    /**
     * @Route("/servi/service/add", name="servi_service.servi_service.add")
     */

       public function ajoutservice(ServiceRepository $repos, Request $request)
       {
         $service = new Service();

            $form = $this->createForm(ServiceType::class, $service);

            $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid())
        {
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();
            $service = $form->getData();
                return $this->redirectToRoute('servi_service.servi_service.affiche');
                
        }
                return $this->render('servi_service/form.html.twig',[
                    'form' => $form->createView()

                ]);

                $service = $repos->findAll();
                return $this->render('servi_service/index.html.twig',
                [ 'services' => $service,]);
        
         
       }


           /**
     * @Route("/servi/service/edi{id}", name="servi_service.servi_service.edit")
     */

    public function editservice($id,ServiceRepository $repos, Request $request)
    {
      $service = $repos->find($id);

         $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid())
     {
         $manager= $this->getDoctrine()->getManager();
         $manager->persist($service);
         $manager->flush();
         $service = $form->getData();
             return $this->redirectToRoute('servi_service.servi_service.affiche');
             
     }
             return $this->render('servi_service/form.html.twig',[
                 'form' => $form->createView(),
                 'services'=>$service,

             ]);


             return $this->render('servi_service/index.html.twig',[
                'services'=>$service
        ]);  
    }

    /** 
 * @Route("/servi/service/delete/{id}", name="servi_service.servi_service.delete")
 */
public function deleteservice($id,ServiceRepository $repos)
{
     $service = $repos->find($id);

        $manager= $this->getDoctrine()->getManager();
        $manager->remove($service );
        $manager->flush();
        
             return $this->redirectToRoute('servi_service.servi_service.affiche');

    }
}
