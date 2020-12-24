<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PostAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    
    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    
    public function testAnybodyCanViewPostsIndex()
    {
        $this->get(route('posts.index'))->assertOk();
        $this->asAuthenticated()->get(route('posts.index'))->assertOk();
    }
    
    public function testAnybodyCanViewOnePost()
    {
        $post = $this->user->posts()->create(['title' => 'asdasd', 'body' => 'asdasd']);
        
        $this->get(route('posts.show', $post))->assertOk();
        $this->asAuthenticated()->get(route('posts.show', $post))->assertOk();
        $this->actingAs(User::factory()->create())->get(route('posts.show', $post))->assertOk();
    }
    
    public function testAutenticatedUserSeesCreateButton()
    {
        $response = $this->asAuthenticated()->get(route('posts.index'));
        $response->assertSee(route('posts.create'));
    }
    
    public function testUnauthenticatedUserDoesntSeeCreateButton()
    {
        $response = $this->get(route('posts.index'));
        $response->assertDontSee(route('posts.create'));
    }
    
    public function testAuthenticatedUserCanCreatePosts()
    {
        $this->asAuthenticated()->get(route('posts.create'))
            ->assertStatus(200);
        
        $data = ['title' => 'Un titulo', 'body' => 'Un contenido'];
        $response = $this->asAuthenticated()->post(route('posts.store'), $data);
        $post = \App\Models\Post::query()
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();
        $response->assertRedirect(route('posts.show', $post));
    }
    
    public function testUnauthenticatedUserCantCreatePosts()
    {
        $this->get(route('posts.create'))->assertRedirect();
        $data = ['title' => 'Un titulo', 'body' => 'Un contenido'];
        $response = $this->post(route('posts.store'), $data);
        $response->assertRedirect('/login');
    }
    
    public function testOwnerCanUpdatePost()
    {
        $data = ['title' => 'Un titulo', 'body' => 'Un cuerpo'];
        $post = $this->user->posts()->create($data);
        
        $this->asAuthenticated()->get(route('posts.edit', $post))->assertOk();
        
        $data = $post->toArray();
        $data['title'] = 'Otro titulo';
        $this->asAuthenticated()->put(route('posts.update', $post), $data)
            ->assertRedirect(route('posts.show', $post));
        $post->refresh();
        $this->assertEquals('Otro titulo', $post->title);
    }
    
    public function testCantUpdateIfNotOwner()
    {
        $data = ['title' => 'Un titulo', 'body' => 'Un cuerpo'];
        $post = $this->user->posts()->create($data);
        
        $anotherUser = User::factory()->create();
        
        $this->actingAs($anotherUser)
            ->get(route('posts.edit', $post))
            ->assertForbidden();
        
        $data = ['title' => 'Otro titulo'];
        $this->actingAs($anotherUser)
            ->put(route('posts.update', $post), $data)
            ->assertForbidden();
    }
    
    public function testUnauthenticatedUserCantUpdate()
    {
        $data = ['title' => 'Un titulo', 'body' => 'Un cuerpo'];
        $post = $this->user->posts()->create($data);
        
        $this->get(route('posts.edit', $post))
            ->assertRedirect('/login');
        
        $data['title'] = 'Otro titulo';

        $this->put(route('posts.update', $post), $data)
            ->assertRedirect('/login');
    }
    
    public function testOwnerCanDeletePost()
    {
        $post = $this->user->posts()->create(['title' => 'Un titulo', 'body' => 'Un cuerpo']);
        
        $this->asAuthenticated()
            ->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));
    }
    
    public function testCantDeleteIfNotOwner()
    {
        $post = $this->user->posts()->create(['title' => 'Un titulo', 'body' => 'Un cuerpo']);
        
        $anotherUser = User::factory()->create();
        
        $this->actingAs($anotherUser)
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();
    }
    
    public function testUnauthenticatedCantDelete()
    {
        $post = $this->user->posts()->create(['title' => 'Un titulo', 'body' => 'Un cuerpo']);
        
        $this->delete(route('posts.destroy', $post))
            ->assertRedirect('/login');
    }
    
    protected function asAuthenticated() {
        return $this->actingAs($this->user);
    }
}
