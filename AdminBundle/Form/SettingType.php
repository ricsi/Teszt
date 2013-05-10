<?php

namespace Bundles\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seoKeywords')
            ->add('seoDescreption')
            ->add('siteTitle')
            ->add('facebookUrl')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundles\AdminBundle\Entity\Setting'
        ));
    }

    public function getName()
    {
        return 'bundles_adminbundle_settingtype';
    }
}
