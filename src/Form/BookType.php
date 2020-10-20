<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'constraints' => new NotBlank(),
        ]);
        $builder->add('size', ChoiceType::class, [
            'choices' => [
                'letter' => 'letter',
                'legal' => 'legal',
                'A5' => 'A5',
                'A4' => 'A4',
                'A3' => 'A3',
                'A2' => 'A2',
                'A1' => 'A1',
            ]
        ]);
        $builder->add('orientation', ChoiceType::class, [
            'choices' => [
                'portrait' => 'portrait',
                'landscape' => 'landscape',
            ]
        ]);
        $builder->add('intro', TextareaType::class, [
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'empty_data' => new Book(),
        ]);
    }
}
