<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                // Label
                'label' => "Titre du livre",
                'label_attr' => [
                    'class' => "title-label"
                ],
                // Rendre require le champ
                'required' => true,
                // Attributs
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Saisir le titre du livre',
                ],
                // Helper
                'help' => "Ajouter le titre du livre",
                'help_attr' => [
                    'class' => "text-muted"
                ],
                // Contraintes du champ
                'constraints' => [
                    new NotBlank([
                        'message' => "Le titre du livre est obligatoire",
                    ]),
                    new Length([
                        'max' => 180,
                        'maxMessage' => "Le titre ne peut que contenir {{ limit }} caractères"
                    ])
                ]
            ])
            ->add('cover', FileType::class, [
                'label' => "Couverture du livre",
                'label_attr' => [
                    'class' => "cover-label"
                ],
                'required' => false,
                'attr' => [
                    // 'class' => 'form-control',
                    'multiple' => true,
                ],
                'help' => "Ajouter le couverture du livre",
                'help_attr' => [
                    'class' => "text-muted"
                ],
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => "L'image (de type {{ type }}) doit être de type {{ types }}",
                        'maxSize' => "2M",
                        'maxSizeMessage' => "L'image est trop large ({{ size }} {{ suffix }}). La taille max est {{ limit }} {{ suffix }}"
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description du livre",
                'label_attr' => [
                    'class' => "description-label"
                ],
                'required' => false,
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Saisir le description du livre',
                ],
                'help' => "Ajouter le description du livre",
                'help_attr' => [
                    'class' => "text-muted"
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => "Prix du livre",
                'label_attr' => [
                    'class' => "price-label"
                ],
                'required' => true,
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Saisir le prix du livre',
                    'min' => 0,
                    'step' => 0.01,
                ],
                'help' => "Ajouter le prix du livre",
                'help_attr' => [
                    'class' => "text-muted"
                ],
                'constraints' => [
                    new Positive([
                        'message' => "Le prix doit être supérieur à {{ compared_value }}"
                    ]),
                    new NotBlank([
                        'message' => "Le prix du livre est obligatoire",
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
