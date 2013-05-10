<?php

namespace Bundles\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Bundles\AdminBundle\Entity\ProductRepository")
 */
class Product {

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\NotBlank(message="A termékkategóriát kötelező megadni!")
     */
    protected $category;

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
     * @Assert\NotBlank(message="A termék neve nem lehet üres")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="nameSlug", length=128, unique=true)
     */
    private $nameSlug;

    /**
     * @var integer
     * @Assert\NotBlank(message="A termék ára nem lehet üres")
     * @ORM\Column(name="prize", type="integer")
     */
    private $prize;

    /**
     * @var integer
     * 
     * @ORM\Column(name="view", type="integer", nullable=true)
     */
    private $view;

    /**
     * @var string
     * @Assert\NotBlank(message="A termék anyaga nem lehet üres")
     * @ORM\Column(name="anyag", type="string", length=255)
     */
    private $anyag;

    /**
     * @var string
     * @Assert\NotBlank(message="A termék mérete nem lehet üres")
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var string
     * @Assert\NotBlank(message="A termék leírása nem lehet üres")
     * @ORM\Column(name="descreption", type="string", length=1024)
     */
    private $descreption;

    /**
     * @var string
     * 
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="image2", type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @var string
     *
     * @ORM\Column(name="image3", type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @var string
     *
     * @ORM\Column(name="image4", type="string", length=255, nullable=true)
     */
    private $image4;

    /**
     * @var string $path
     * 
     * @ORM\Column(name="path", type="string", length=1024, nullable = true)
     * 
     */
    private $path;

    /**
     * 
     * @Assert\File(
     *          maxSize="10M",
     *          mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *          mimeTypesMessage = "Kérem csak jpg/jpeg/gif/png képet töltsön fel!"
     * )
     */
    public $file;

    /**
     * @Assert\File(
     *          maxSize="10M",
     *          mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *          mimeTypesMessage = "Kérem csak jpg/jpeg/gif/png képet töltsön fel!"
     * )
     */
    public $file2;

    /**
     * @Assert\File(
     *          maxSize="10M",
     *          mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *          mimeTypesMessage = "Kérem csak jpg/jpeg/gif/png képet töltsön fel!"
     * )
     */
    public $file3;

    /**
     * @Assert\File(
     *          maxSize="10M",
     *          mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *          mimeTypesMessage = "Kérem csak jpg/jpeg/gif/png képet töltsön fel!"
     * )
     */
    public $file4;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->image;
    }

    public function getAbsolutePath() {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
    }

    public function getAbsolutePath2() {
        return null === $this->image2 ? null : $this->getUploadRootDir() . '/' . $this->image2;
    }

    public function getAbsolutePath3() {
        return null === $this->image3 ? null : $this->getUploadRootDir() . '/' . $this->image3;
    }

    public function getAbsolutePath4() {
        return null === $this->image4 ? null : $this->getUploadRootDir() . '/' . $this->image4;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->image;
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        return 'uploads/product';
    }

    public function toAscii($str, $delimiter = '-') {
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public function upload() {

        if ($this->file === null) {
            return;
        }
        if ($this->image) {
            @unlink($this->getUploadRootDir() . "/" . $this->image);
            @unlink($this->getUploadRootDir() . "/thb_" . $this->image);
        }

        if (!\is_dir($this->getUploadRootDir())) { //ha nem letezik a konyvtar 
            \mkdir($this->getUploadRootDir(), 0755); //letrehozzuk
        }

        $ext = $this->file->guessExtension(); //file kiterjesztése
        $name = $this->toAscii($this->name);

        $this->image = ($name . "." . $ext);

        $resizer = new \Bundles\AdminBundle\Resizer\Resizer();

        $resizer->load($this->file->getPathname());
        $resizer->output($ext);
        $resizer->save($this->getAbsolutePath());
        @unlink($this->file->getPathname());

        list($width, $height) = \getimagesize($this->getUploadRootDir() . "/" . $this->image);

        $this->width = $width;
        $this->height = $height;

        $resizer->load($this->getAbsolutePath());
        $resizer->resizeToWidth(400);
        $resizer->output($ext);
        $resizer->save($this->getUploadRootDir() . "/" . "thb_" . $this->image);
    }

    public function upload2() {
        if ($this->file2 === null) {
            return;
        }
        if ($this->image2) {
            @unlink($this->getUploadRootDir() . "/" . $this->image2);
            @unlink($this->getUploadRootDir() . "/thb_" . $this->image2);
        }

        $ext = $this->file2->guessExtension(); //file kiterjesztése
        $name = $this->toAscii($this->name . '2');

        $this->image2 = ($name . "." . $ext);

        $resizer = new \Bundles\AdminBundle\Resizer\Resizer();

        $resizer->load($this->file2->getPathname());
        $resizer->output($ext);
        $resizer->save($this->getAbsolutePath2());
        @unlink($this->file2->getPathname());

        list($width, $height) = \getimagesize($this->getUploadRootDir() . "/" . $this->image2);

        $this->width = $width;
        $this->height = $height;

        $resizer->load($this->getAbsolutePath2());
        $resizer->resize(115, 115);
        $resizer->output($ext);
        $resizer->save($this->getUploadRootDir() . "/" . "thb_" . $this->image2);
    }

    public function upload3() {
        if ($this->file3 === null) {
            return;
        }
        if ($this->image3) {
            @unlink($this->getUploadRootDir() . "/" . $this->image3);
            @unlink($this->getUploadRootDir() . "/thb_" . $this->image3);
        }

        $ext = $this->file3->guessExtension(); //file kiterjesztése
        $name = $this->toAscii($this->name . '3');

        $this->image3 = ($name . "." . $ext);

        $resizer = new \Bundles\AdminBundle\Resizer\Resizer();

        $resizer->load($this->file3->getPathname());
        $resizer->output($ext);
        $resizer->save($this->getAbsolutePath3());
        @unlink($this->file3->getPathname());

        list($width, $height) = \getimagesize($this->getUploadRootDir() . "/" . $this->image3);

        $this->width = $width;
        $this->height = $height;

        $resizer->load($this->getAbsolutePath3());
        $resizer->resize(115, 115);
        $resizer->output($ext);
        $resizer->save($this->getUploadRootDir() . "/" . "thb_" . $this->image3);
    }

    public function upload4() {
        if ($this->file4 === null) {
            return;
        }
        if ($this->image4) {
            @unlink($this->getUploadRootDir() . "/" . $this->image4);
            @unlink($this->getUploadRootDir() . "/thb_" . $this->image4);
        }

        $ext = $this->file4->guessExtension(); //file kiterjesztése
        $name = $this->toAscii($this->name . '4');

        $this->image4 = ($name . "." . $ext);

        $resizer = new \Bundles\AdminBundle\Resizer\Resizer();

        $resizer->load($this->file4->getPathname());
        $resizer->output($ext);
        $resizer->save($this->getAbsolutePath4());
        @unlink($this->file4->getPathname());

        list($width, $height) = \getimagesize($this->getUploadRootDir() . "/" . $this->image4);

        $this->width = $width;
        $this->height = $height;

        $resizer->load($this->getAbsolutePath4());
        $resizer->resize(115, 115);
        $resizer->output($ext);
        $resizer->save($this->getUploadRootDir() . "/" . "thb_" . $this->image4);
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set nameSlug
     *
     * @param string $nameSlug
     * @return Product
     */
    public function setNameSlug($nameSlug) {
        $this->nameSlug = $nameSlug;

        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string 
     */
    public function getNameSlug() {
        return $this->nameSlug;
    }

    /**
     * Set prize
     *
     * @param integer $prize
     * @return Product
     */
    public function setPrize($prize) {
        $this->prize = $prize;

        return $this;
    }
    /**
     * Set prize
     *
     * @param integer $prize
     * @return Product
     */
    public function setView($view) {
        $this->view = $view;

        return $this;
    }

    /**
     * Get prize
     *
     * @return integer 
     */
    public function getPrize() {
        return $this->prize;
    }
    /**
     * Get prize
     *
     * @return integer 
     */
    public function getView() {
        return $this->view;
    }
    /**
     * Set anyag
     *
     * @param string $anyag
     * @return Product
     */
    public function setAnyag($anyag) {
        $this->anyag = $anyag;

        return $this;
    }

    /**
     * Get anyag
     *
     * @return string 
     */
    public function getAnyag() {
        return $this->anyag;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Product
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Set descreption
     *
     * @param string $descreption
     * @return Product
     */
    public function setDescreption($descreption) {
        $this->descreption = $descreption;

        return $this;
    }

    /**
     * Get descreption
     *
     * @return string 
     */
    public function getDescreption() {
        return $this->descreption;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set image2
     *
     * @param string $image2
     * @return Product
     */
    public function setImage2($image2) {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return string 
     */
    public function getImage2() {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param string $image3
     * @return Product
     */
    public function setImage3($image3) {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get image3
     *
     * @return string 
     */
    public function getImage3() {
        return $this->image3;
    }

    /**
     * Set image4
     *
     * @param string $image4
     * @return Product
     */
    public function setImage4($image4) {
        $this->image4 = $image4;

        return $this;
    }

    /**
     * Get image4
     *
     * @return string 
     */
    public function getImage4() {
        return $this->image4;
    }

    /**
     * Set category
     *
     * @param \Bundles\AdminBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Bundles\AdminBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Bundles\AdminBundle\Entity\Category 
     */
    public function getCategory() {
        return $this->category;
    }


    /**
     * Set path
     *
     * @param string $path
     * @return Product
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }
}