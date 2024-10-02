<?php

namespace App\Form;

use App\Entity\Permissions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add("name", TextType::class, [
        "label" => "Nom",
        "attr" => [
          "placeholder" => "Nom"
          ],
          "row_attr" => [
          "class" => "form-floating text-dark mb-3"
          ]
        ])
      ->add("description", TextType::class, [
        "label" => "Description",
        "attr" => [
          "placeholder" => "Description"
          ],
          "row_attr" => [
          "class" => "form-floating text-dark mb-3"
          ]
        ])
      ->add("Valider", SubmitType::class, [
        "attr" => [
          "class" => "form__input--button btn btn-outline-light",
          "onclick" => "return submitConfirmPermission()"
        ],
        "row_attr" => [
          "class" => "text-center mb-3"
        ]
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      "data_class" => Permissions::class,
    ]);
  }
}