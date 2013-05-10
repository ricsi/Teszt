<?php

namespace Bundles\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $role = null;
        $builder
            ->add('name')
            ->add('nameSlug', 'hidden')
            ->add('prize', 'text')
            ->add('anyag')
            ->add('size')
            ->add('descreption', 'textarea')
            ->add('file')
            ->add('file2')
            ->add('file3')
            ->add('file4')
                ->add('view', 'hidden')
            ->add('category','entity', array(
                    'class' => 'BundlesAdminBundle:Category',
                    'query_builder' => function(\Gedmo\Tree\Entity\Repository\NestedTreeRepository $er) use ($role) {
                        $root = $er->findOneByName($role);
                        $ret = $er->childrenQueryBuilder($root, $direct = false, $sortByField = null, $direction = 'ASC')->andWhere("node.lvl IN (2) ");
                        return $ret;
                    },
                    'empty_value' => false,
                    'property' => 'name',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'read_only' => false
        ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundles\AdminBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'bundles_adminbundle_producttype';
    }
}
