<?php

namespace App\Form;

use App\Entity\Permissions;
use App\Entity\PermissionsStructures;
use App\Entity\Structures;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionsStructuresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("structures", EntityType::class, [
                "label" => "Salle de sport",
                "class" => Structures::class,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
            ])
            ->add("permissions", EntityType::class, [
                "label" => "Module",
                "class" => Permissions::class,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ])
            ->add("Valider", SubmitType::class, [
                "attr" => [
                    "class" => "form__input--button btn btn-outline-light",
                    "onclick" => "return submitConfirmPermissionStructure()"
                ],
                "row_attr" => [
                    "class" => "text-center mb-3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PermissionsStructures::class,
        ]);
    }
}
