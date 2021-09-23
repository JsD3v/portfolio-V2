<?php

namespace App\Form;

use App\Entity\Contact;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>'votre nom',
                'attr'=>[
                    'placeholder' => 'doe',
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
            ->add('prenom', TextType::class,[
                'label'=>'votre prénom',
                'attr'=>[
                    'placeholder' => 'john',
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
            ->add('email', EmailType::class,[
                'label'=>'Veuillez saisir votre e-mail',
                'attr'=>[
                    'placeholder'=>'example@votre e-mail',
                    'class' =>'form-control'
                ],
                'required'=>true

            ])
            ->add('text', TextareaType::class,[
                'label'=>'Veuillez saisir votre message',
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre message',
                    'class'=>'form-control'
                ],
                'required'=>true
            ])
            ->add('checkbox',CheckboxType::class,[
                'label'=>'En soumettant ce formulaire j\'accepte que JsChristophe utilise mes coordonnées dans le strict cadre de la réponse à ma demande.',
                'required' => true,
                'attr'=>[
                    'type'=>'checkbox',
                    'id'=>'toggle-two',
                    'checked data-toggle'=>'toggle',
                    'date-on'=>'ok',
                    'data-off'=>'non',
                    'data-style'=>'slow',
                    'data-onstyle'=>'outline-info',
                    'data-size'=>'lg'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //voir si besoin
        ]);
    }
}
