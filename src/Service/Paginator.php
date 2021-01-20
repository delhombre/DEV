<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class Paginator
{
  protected $request;

  public function __construct(RequestStack $requestStack)
  {
    $this->request = $requestStack->getCurrentRequest();
  }

  public function getOffset()
  {
    return max(0, $this->request->query->getInt('offset', 0));
  }

  public function previous(string $itemsPerPage)
  {
    return $this->getOffset($this->request) - $itemsPerPage;
  }

  public function next($paginator, string $itemPerPage)
  {
    return min(count($paginator), $this->getOffset($this->request) +
      $itemPerPage);
  }
}
