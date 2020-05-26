<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    // 引数がnullのケース
    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();

        $result = $article->isLikedBy(null);

        // 引数がfalseかどうかをテストする
        $this->assertFalse($result);
    }

    // いいねをしているケース
    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        // likesメソッドを呼び出す（記事にいいねをする）
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        // 引数がtrueかどうかをテストする
        $this->assertTrue($result);
    }

    // いいねをしていないケース
    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();

        // 他人が記事にいいねをする
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
