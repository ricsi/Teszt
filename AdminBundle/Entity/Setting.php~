<?php

namespace Bundles\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity
 */
class Setting
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="seoKeywords", type="string", length=700)
     */
    private $seoKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="seoDescreption", type="string", length=700)
     */
    private $seoDescreption;

    /**
     * @var string
     *
     * @ORM\Column(name="siteTitle", type="string", length=50)
     */
    private $siteTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookUrl", type="string", length=300)
     */
    private $facebookUrl;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return Setting
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;
    
        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string 
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }

    /**
     * Set seoDescreption
     *
     * @param string $seoDescreption
     * @return Setting
     */
    public function setSeoDescreption($seoDescreption)
    {
        $this->seoDescreption = $seoDescreption;
    
        return $this;
    }

    /**
     * Get seoDescreption
     *
     * @return string 
     */
    public function getSeoDescreption()
    {
        return $this->seoDescreption;
    }

    /**
     * Set siteTitle
     *
     * @param string $siteTitle
     * @return Setting
     */
    public function setSiteTitle($siteTitle)
    {
        $this->siteTitle = $siteTitle;
    
        return $this;
    }

    /**
     * Get siteTitle
     *
     * @return string 
     */
    public function getSiteTitle()
    {
        return $this->siteTitle;
    }

    /**
     * Set facebookUrl
     *
     * @param string $facebookUrl
     * @return Setting
     */
    public function setFacebookUrl($facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;
    
        return $this;
    }

    /**
     * Get facebookUrl
     *
     * @return string 
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }
}