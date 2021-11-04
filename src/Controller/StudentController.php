<?php

namespace Controller;

use Entity\Department;
use Entity\Student;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Request\ParamFetcherInterface;
use StudentFormType;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation as Doc;

class StudentController extends AbstractController
{

    /**
     * @Route("/student_add", name="student_add")
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentFormType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
        }
        return $this->render('student/student-form.html.twig', [
            "form_title" => "Enregistrer un étudiant",
            "form_student" => $form->createView(),
        ]);
    }

    /**
     * @Route("/students", name="students")
     */
    public function viewStudents() {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();

        return $this->render('student/students.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/student_edit/{id}", name="student_edit")
     */
    public function updateStudent(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentFormType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
        }

        return $this->render("student/student-form.html.twig", [
            "form_title" => "Modifier un etudiant",
            "form_student" => $form->createView(),
        ]);
    }

    /**
     * @Route("/student_delete/{id}" , name="student_delete")
     */
    public function deleteStudent($id): Response {

        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute("students");

    }
}