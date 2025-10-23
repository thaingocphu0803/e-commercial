<?php

namespace App\Services\Interfaces;

/**
 * Interface CartServiceInterface
 * @package App\Services\Interfaces
 */
interface CartServiceInterface
{
    public function create($request);
    public function order($request);
    public function update($request);
    public function delete($request);
    public function getDiscountByCartTotal($cartTotal);
}
