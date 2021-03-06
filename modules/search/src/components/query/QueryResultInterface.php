<?php

namespace im\search\components\query;

use im\search\components\query\facet\FacetInterface;

interface QueryResultInterface
{
    /**
     * @return int
     */
    public function getTotal();

    /**
     * @return array
     */
    public function getObjects();

    /**
     * @return FacetInterface[]
     */
    public function getFacets();

    /**
     * @return FacetInterface[]
     */
    public function getSelectedFacets();

    /**
     * @return QueryInterface|IndexQueryInterface
     */
    public function getQuery();
}