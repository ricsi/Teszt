<?php

namespace Bundles\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $role = null;
        $builder
                ->add('title')
                ->add('titleSlug', 'hidden')
                ->add('content', 'textarea')
                ->add('seoKeywords')
                ->add('seoTitle')
                ->add('lft', 'hidden')
                ->add('lvl', 'hidden')
                ->add('root')
                ->add('rgt', 'hidden')->add('parent', 'entity', array(
            'class' => 'BundlesAdminBundle:Menu',
            'query_builder' => function(\Gedmo\Tree\Entity\Repository\NestedTreeRepository $er) use ($role) {
                $root = $er->findOneByTitle($role);
                $ret = $er->childrenQueryBuilder($root, $direct = false, $sortByField = null, $direction = 'ASC')->andWhere("node.lvl IN (1) OR node.id=1");
                return $ret;
            },
            'empty_value' => false,
            'property' => 'title',
            'required' => false,
            'expanded' => false,
            'multiple' => false,
            'read_only' => false
        ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bundles\AdminBundle\Entity\Menu'
        ));
    }

    public function getName() {
        return 'bundles_adminbundle_menutype';
    }

}
