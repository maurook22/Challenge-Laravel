<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PostSeeder extends Seeder
{

    static public $MIN_POSTS = 0;

    static public $MAX_POSTS = 50;

    static public $WORD_TITLE_VAL = 2;
    
    static public $WORD_BODY_VAL = 1;

    public function savePosts()
    {

        $posts = $this->httpGet();

        $rated_posts = $this->ratePosts($posts);

        $this->saveRatedPosts($rated_posts);
    }

    private function httpGet()
    {

        $response = Http::get(config('app.api_posts_url'));

        $array = array_slice($response->json(), self::$MIN_POSTS, self::$MAX_POSTS);

        return $array;
    }

    private function ratePosts($posts)
    {

        $rated_posts = array();

        foreach ($posts as $p) {

            $title_value = (int)var_export(preg_match_all('/[a-z]+/', $p['title']), true) * self::$WORD_TITLE_VAL;

            $body_value = (int)var_export(preg_match_all('/[a-z]+/', $p['body']), true) * self::$WORD_BODY_VAL;

            $total = $title_value + $body_value;

            $post = array(
                'user_id' => $p['userId'],
                'id' => $p['id'],
                'title' => $p['title'],
                'body' => $p['body'],
                'rating' => $total
            );

            array_push($rated_posts, $post);
        }

        return $rated_posts;
    }

    private function saveRatedPosts($posts)
    {

        foreach ($posts as $p) {

            Post::updateOrCreate(
                [
                    'id' => $p['id'],
                    'user_id' => $p['user_id'],
                    'title' => $p['title'],
                    'rating' => $p['rating']
                ],
                [
                    'body' => $p['body']
                ]
            );
        }
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->savePosts();
    }
}
