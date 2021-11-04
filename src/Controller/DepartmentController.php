<?php

namespace Controller;

use Entity\Department;
use Entity\Student;

use DepartmentFormType;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/department_add", name="department_add")
     */
    public function addDepartment(Request $request)
    {
        $department = new Department();
        $form = $this->createForm(DepartmentFormType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();
        }
        return $this->render('department/department-form.html.twig', [
            "form_title" => "Enregistrer un département",
            "form_department" => $form->createView(),
        ]);
    }

    /**
     * @Route("/departments", name="departments")
     */
    public function viewDepartments() {
        $departments = $this->getDoctrine()->getRepository(Department::class)->findAll();

        return $this->render('department/departments.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/students/{department}", name="students_department")
     * * @Method ({"GET"})
     * @Get(
     *     path = "/students",
     *     name = "students_department_show"
     *     requirements={"department"="[a-z]+"}
     * )
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="Get the list of all students by Department."
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "description"="The student unique identifier."
     *         }
     *         {
     *             "name"="FirstName",
     *             "dataType"="string",
     *             "description"="The student's firstname."
     *         }
     *         {
     *             "name"="LastName",
     *             "dataType"="string",
     *             "description"="The student's lastname."
     *         }
     *         {
     *             "name"="NumEtud",
     *             "dataType"="string",
     *             "description"="The student's number."
     *         }
     *         {
     *             "name"="Department",
     *             "dataType"="department",
     *             "description"="The student's department."
     *         }
     *     }
     * )
     */
    public function getStudentsByDepartment() {

        $department = $this->getDoctrine()->getRepository(Department::class);
        $students = $department->getStudents();

        $data = $this->get('jms_serializer')->serialize($students, 'json');
        $response = new Response($data);

        $response->headers->set('Content-Type', 'application/json');

        return $students;
    }

    /**
     * @Route("/department_edit/{id}", name="department_edit")
     */
    public function updateDepartment(Request $request, Student $student, $id) {

        $em = $this->getDoctrine()->getManager();
        $department = $em->getRepository(Department::class)->find($id);
        $form = $this->createForm(DepartmentFormType::class, $department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $student->setDepartment($this);
            $em->flush();
        }

        return $this->render("department/department-form.html.twig", [
            "form_title" => "Modifier un département",
            "form_department" => $form->createView(),
        ]);
    }

    /**
     * @Route("/department_delete/{id}" , name="department_delete")
     */
    public function deleteDepartment(Student $student, $id): Response {

        $em = $this->getDoctrine()->getManager();
        $department = $em->getRepository(Department::class)->find($id);
        $student->setDepartment(null);
        $em->remove($department);
        $em->flush();

        return $this->redirectToRoute("departments");

    }
}