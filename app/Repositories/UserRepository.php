<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function all()
    {

        $data = User::select('id', 'name', 'email', 'city')
            ->with(['posts'])
            ->get()
            ->toArray();

        return $this->orderData($data);
    }

    private function orderData($data)
    {

        usort($data, function ($item1, $item2) {

            $avg_item1 = $this->getAvg($item1['posts']);

            $avg_item2 = $this->getAvg($item2['posts']);

            if ($avg_item1 == $avg_item2) return 0;

            return ($avg_item1 < $avg_item2) ? 1 : -1;
        });

        return $data;
    }

    private function getAvg($posts)
    {

        $total = 0;

        foreach ($posts as $post) {

            $total += (float) $post['rating'];
        }

        return $total / count($posts);
    }
}
