<?php
namespace BookCatalogBundle\Form;

use BookCatalogBundle\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Tytuł'))
            ->add('author')
            ->add('isbn')
            ->add('price', MoneyType::class, array(
                'currency' => 'PLN'
            ))
            ->add('genre', ChoiceType::class, array(
                'choices'  => array(
                    "dramat" => "dramat", 
                    "fantastyka" =>"fantastyka", 
                    "reportaż" => "reportaż", 
                    "poezja" => "poezja"
                )
            ))
            ->add('yearPublished')
            ->add('save', SubmitType::class)
        ;
    } 
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Book::class,
        ));
    }
}