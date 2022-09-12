<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{

    public function saveUsers()
    {

        $users_id = $this->getUsersIds();

        $users = $this->findUsers($users_id);

        $this->insertUsers($users);
    }

    private function insertUsers($users)
    {

        foreach ($users as $user) {

            User::updateOrCreate(
                [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'city' => $user['address']['city']
                ]
            );
        }
    }

    private function findUsers($users)
    {

        $all_users = $this->httpGet();

        $filtered = array_filter($all_users, function ($element) use ($users) {

            return in_array($element['id'], $users);
        });

        return $filtered;
    }

    private function httpGet()
    {

        $response = Http::get(config('app.api_users_url'));

        $array = $response->json();

        return $array;
    }

    private function getUsersIds()
    {

        $data = Post::select('user_id')->distinct()->get()->toArray();

        $users_id = array_map(function ($element) {
            return $element['user_id'];
        }, $data);

        return $users_id;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->saveUsers();
    }
}
