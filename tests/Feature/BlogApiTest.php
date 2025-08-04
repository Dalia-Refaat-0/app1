<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Blog;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_blog()
    {
        $data = ['title' => 'Test Title', 'content' => 'Test content'];

        $response = $this->postJson('/api/blogs', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('blogs', $data);
    }

    public function test_can_get_all_blogs()
    {
        Blog::factory()->count(3)->create();

        $response = $this->getJson('/api/blogs');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_show_single_blog()
    {
        $blog = Blog::factory()->create();

        $response = $this->getJson("/api/blogs/{$blog->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $blog->title]);
    }

    public function test_can_update_blog()
    {
        $blog = Blog::factory()->create();
        $data = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/blogs/{$blog->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('blogs', $data);
    }

    public function test_can_delete_blog()
    {
        $blog = Blog::factory()->create();

        $response = $this->deleteJson("/api/blogs/{$blog->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
