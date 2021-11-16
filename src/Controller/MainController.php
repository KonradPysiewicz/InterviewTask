<?php

namespace App\Controller;

use App\Entity\Code;
use App\Form\CodeType;
use App\Repository\CodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\equalTo;



class MainController extends AbstractController
{

    /**
     * Funkcja w kontrolerze sterująca całym programem
     * @param CodeRepository $codeRepository
     * @param Request $request
     * @return Response
     */

    public function index(CodeRepository $codeRepository, Request $request): Response
    {

        /** Utworzenie formularza */

        $code = new Code();
        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);

        /** Zapisywanie kodu do bazy danych jeśli przycisk submit został wciśnięty */

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $code->setCodeNr($code->getCodeNr());

            $code->setFlag(1);

            $date = new \DateTime('now');

            $code->setDate($date);
            $entityManager->persist($code);
            $entityManager->flush();

        }

        /** Pobranie danych z repozytorium i posortowanie ich malejąco według daty  */

        $codes = $codeRepository->findBy(array(),array('date' => 'DESC'));


        /** Wygenerowanie widoku i przekazanie do niego danych (formularza, oraz kodów) */

        return $this->render('index.html.twig', [
            'codes' => $codes,
            'form' => $form->createView()

        ]);
    }
}
