<?php

namespace App\Form;

use App\Entity\Structures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructuresType extends AbstractType
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
      ->add("address", TextType::class, [
        "label" => "Adresse postale",
        "attr" => [
          "placeholder" => "Adresse postale"
          ],
          "row_attr" => [
          "class" => "form-floating text-dark mb-3"
          ]
        ])
      ->add("phone_number", TelType::class, [
        "label" => "Numéro de téléphone",
        "attr" => [
          "placeholder" => "Numéro de téléphone",
          "pattern" => "[0-9]{10}"
          ],
          "row_attr" => [
          "class" => "form-floating text-dark mb-3"
          ]
        ])
      ->add("Valider", SubmitType::class, [
        "attr" => [
          "class" => "form__input--button btn btn-outline-light",
          "onclick" => "return submitConfirmStructure()"
        ],
        "row_attr" => [
          "class" => "text-center mb-3"
        ],
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      "data_class" => Structures::class,
    ]);
  }
}