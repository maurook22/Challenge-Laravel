<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function top();
    public function get($id);
}
