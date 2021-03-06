<?php

/**
 * Description of Ad
 *
 * (c) lsroudi <http://lsroudi.com/> <lsroudi@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lsroudi\ClassifiedAdsBundle\Entity;

use Lsroudi\ClassifiedAdsBundle\Entity\CategoryInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Ad  implements AdInterface 
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=false)
     */
    protected $createdAt;

    /**
     * @var string
     * @Assert\NotBlank(message = "lsroudi_classified_ads.ad.title.not_blank",groups={"Default"})
     * @ORM\Column(name="title", type="string", length=255 , nullable=false)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank(message = "lsroudi_classified_ads.ad.description.not_blank",groups={"Default"})
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    protected $description;
    
     /**
     * @var Lsroudi\ClassifiedAdsBundle\Entity\Category
     *
     * @Assert\NotBlank(message = "lsroudi_classified_ads.category.name.not_blank",groups={"Default"}) 
     * @ORM\ManyToMany(targetEntity="Lsroudi\ClassifiedAdsBundle\Entity\Category", cascade={"persist"})
     */
    protected $category;

     /**
     * @var Lsroudi\ClassifiedAdsBundle\Entity\Tag
     *
     * @ORM\ManyToMany(targetEntity="Lsroudi\ClassifiedAdsBundle\Entity\Tag", cascade={"persist"})
     */
    protected $tag;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="enabled", type="boolean")         
     */  
    protected $enabled;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->category = new ArrayCollection();
        $this->tag = new ArrayCollection();        
        $this->enabled = false;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }    
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setCategory(CategoryInterface $category = null)
    {
        if($category instanceof CategoryInterface){
            
            $this->addCategory($category);
        }
        
        return $this;
    }
    
    public function addCategory(CategoryInterface $category)
    {
        $this->category->add($category);
        
        return $this;
    }
    
    public function getTag()
    {
        return $this->tag;
    }
    
    public function setTag(TagInterface $tag)
    {
        $this->addTag($tag);
        
        return $this;
    }
    
    public function addTag(TagInterface $tag)
    {
        $this->tag->add($tag);
        
        return $this;
    }    
    
    public function setEnabled($boolean)
    {
        $this->enabled = $boolean;

        return $this;
    } 
    
    public function isEnabled()
    {
        return $this->enabled;
    }    
}