<?php
namespace Blog;

use Illuminate\Pagination\Paginator as OldPaginator;
use Illuminate\Support\Contracts\JsonableInterface;

class Paginator extends OldPaginator implements JsonableInterface
{
    public function toJson($options = 0)
    {
        $json = [
            'last' => $this->getLastPage(),
            'page' => $this->getCurrentPage(),
            'perPage' => $this->getPerPage(),
            'results' => $this->items,
            'total' => $this->getTotal()
        ];
        return json_encode($json, $options);
    }
}