<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Sonata\FormatterBundle\Form\Type\FormatterType;

final class BlogArticleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('content', FormatterType::class, [
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'   => 'contentFormatter',
                'format_field_options' => [
                    'choices' => [
                        'text' => 'Text',
                        'markdown' => 'Markdown',
                        'rawhtml' => 'RawHtml',
                        'richhtml' => 'RichHtml'
                    ],
                    'data' => 'markdown',
                ],
                'source_field' => 'rawContent',
                'source_field_options' => [
                    'attr' => ['class' => 'span10', 'rows' => 20],
                ],
                'listener' => true,
                'target_field' => 'content',
            ])
            ->add('enabled', ChoiceType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('enabled')
        ;
    }    
}