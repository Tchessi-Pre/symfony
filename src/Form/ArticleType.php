<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre de l\'article',
                    
                ]
            ])
            ->add('content', TextareaType::class, [

                'label' => 'Commentaire*',

                'attr' => [

                    'placeholder' => 'Votre Commentaire...',
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Télécharger une image',

                'constraints' => array(
                    new Image(array(
                        'minWidth' => 500, 'minHeight' => 350, 'mimeTypes' =>
                        array(
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/gif',
                        ),
                    )),

                    new File(array('maxSize' => 1024000, 'mimeTypes' =>
                    array(
                        'application/pdf',

                    ),)),
                ),


                'required' => false,

                'allow_delete' => true,
                'download_link' => true,

            ])
            ->add('Publier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
