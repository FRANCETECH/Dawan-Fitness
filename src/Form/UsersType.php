<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
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
        "class" => "form-floating text-dark"
        ]
      ])
      ->add("email", EmailType::class,[
        "label" => "Adresse e-mail",
        "attr" => [
          "placeholder" => "Adresse e-mail"
        ],
        "row_attr" => [
          "class" => "form-floating text-dark"
        ],
        "constraints" => [
          new NotBlank([
            "message" => "Veuillez renseigner une adresse mail s'il vous plaît."
          ]),
          new Email([
            "message" => "L'adresse mail {{ value }} n'est pas valide."
          ])
        ],
        "required" => true
      ])
      ->add("phone_number", TelType::class, [
        "label" => "Numéro de téléphone",
        "attr" => [
          "placeholder" => "Numéro de téléphone",
          "pattern" => "[0-9]{10}"
        ],
        "row_attr" => [
          "class" => "form-floating text-dark"
        ]
      ])
      ->add("password", PasswordType::class, [
        "label" => "Mot de passe",
        "mapped" => false,
        "attr" => [
          "autocomplete" => "new-password",
          "placeholder" => "Mot de passe"
        ],
        "row_attr" => [
          "class" => "form-floating text-dark"
        ],
        "required" => true,
        "constraints" => [
            new NotBlank([
                "message" => "Veuillez renseigner un mot de passe s'il vous plaît"
            ]),
            new Length([
                "min" => 6,
                "minMessage" => "Le mot de passe doit contenir au moins {{ limit }} caractères.",
                // max length allowed by Symfony for security reasons
                "max" => 4096
            ]),
        ],
      ])
      ->add("roles", CollectionType::class, [
        "label" => "Type de compte",
        "entry_type" => ChoiceType::class,
        "entry_options" => [
          "label" => false,
          "choices" => [
            "Responsable d'une salle de sport" => "ROLE_MANAGER",
            "Partenaire" => "ROLE_PARTNER",
            "Equipe technique" => "ROLE_ADMIN"
          ]
        ],
      ])
      ->add("structures")
      ->add("Valider", SubmitType::class, [
        "attr" => [
          "class" => "form__input--button btn btn-outline-light",
          "onclick" => "return submitConfirmUser()"
        ],
        "row_attr" => [
          "class" => "text-center mb-3"
        ],
      ])
    ;

// For add dynamic fields
/*     $formModifier = function (FormInterface $form, Users $user) {
      $structures = (null === $user) ? [] : $user->getStructures();

      $form->add("structures", EntityType::class, [
        "class" => Structures::class,
        "choices" => $structures,
        "choice_label" => "Nom",
        "placeholder" => "Structure (Choisir une structure)",
        "label" => "Structure"
      ]);
    };
    
    $builder->get("roles")->addEventListener(
      FormEvents::POST_SUBMIT,
      function (FormEvent $event) use ($formModifier){
        $roles = $event->getForm()->getData();
        $formModifier($event->getForm()->getParent(), $roles);
      }
    ); */
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      "data_class" => Users::class,
    ]);
  }
}