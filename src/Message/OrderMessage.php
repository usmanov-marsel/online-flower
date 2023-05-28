<?php

namespace App\Message;

class OrderMessage
{
  public function __construct(
    private string $idOrder,
  ) {
  }

  public function getIdOrder(): string
  {
    return $this->idOrder;
  }
}
