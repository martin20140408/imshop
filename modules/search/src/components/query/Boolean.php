<?php

namespace im\search\components\query;

/**
 * Boolean query.
 *
 * @package im\search\components\query
 */
class Boolean extends SearchQuery implements BooleanQueryInterface
{
    /**
     * @var SearchQueryInterface[]
     */
    private $_subQueries = [];

    /**
     * SubQueries signs.
     * true is used to define required query.
     * false is used to define prohibited query.
     * null is used to define optional query.
     * If array is null then all sub queries are required
     *
     * @var array
     */
    private $_signs = [];

    /**
     * @inheritdoc
     */
    public function setSubQueries($subQueries = [], $signs = null)
    {
        $this->_subQueries = $subQueries;
        $this->_signs = $signs ? $signs : array_fill_keys(array_keys($subQueries), true);
    }

    /**
     * @inheritdoc
     */
    public function getSubQueries()
    {
        return $this->_subQueries;
    }

    /**
     * @inheritdoc
     */
    public function addSubQuery(SearchQueryInterface $subQuery, $sign = null)
    {
        if ($sign !== true || $this->_signs !== null) {
            if ($this->_signs === null) {
                $this->_signs = array_fill_keys(array_keys($this->_subQueries), true);
            }
            $this->_signs[] = $sign;
        }
        $this->_subQueries[] = $subQuery;
    }

    /**
     * @inheritdoc
     */
    public function getSigns()
    {
        return $this->_signs;
    }

    /**
     * @param array $signs
     */
    public function setSigns($signs)
    {
        $this->_signs = $signs;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return !(bool) $this->_subQueries;
    }


} 