<?php

namespace Bundles\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $role = $options['role'];

        $builder
                ->add('name')
                ->add('slug', 'hidden')
                ->add('lft', 'hidden')
                ->add('lvl', 'hidden')
                ->add('rgt', 'hidden')
                ->add('root')
                ->add('parent', 'entity', array(
                    'class' => 'BundlesAdminBundle:Category',
                    'query_builder' => function(\Gedmo\Tree\Entity\Repository\NestedTreeRepository $er) use ($role) {
                        $root = $er->findOneByName($role);
                        $ret = $er->childrenQueryBuilder($root, $direct = false, $sortByField = null, $direction = 'ASC')->andWhere("node.lvl IN (1) OR node.id=1");
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

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bundles\AdminBundle\Entity\Category',
            'role' => null
        ));
    }

    public function getName() {
        return 'bundles_adminbundle_categorytype';
    }

}
