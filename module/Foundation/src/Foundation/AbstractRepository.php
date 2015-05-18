<?php

namespace Foundation;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    const PAGINATION_MAX_ROWS = 10;
    const PAGINATION_OFFSET_START = 0;
}