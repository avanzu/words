<?php
/**
 * ResourceRepository.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Repository;


use Components\Resource\Repository\IRepository;
use Doctrine\ORM\EntityRepository;

class ResourceRepository extends EntityRepository implements IRepository
{

}