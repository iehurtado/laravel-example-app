<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;

use Tests\TestCase;

class SubmitLinkTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/submit');
        $response->assertStatus(200);
    }
    
    /** @test */
    public function testGuestCanSubmitANewLink() 
    {
        $response = $this->post('/submit', [
            'title' => 'Ejemplo',
            'url' => 'https://ejemplo.com/',
            'description' => 'Un link de ejemplo'
        ]);
        
        $this->assertDatabaseHas('links', ['title' => 'Ejemplo']);
        
        $response
            ->assertStatus(302)
            ->assertHeader('Location', url('/'));
        
        $this
            ->get('/')
            ->assertSee('Ejemplo');
    }

    /** @test */
    public function testLinkIsNotCreatedIfValidationFails() 
    {
        $response = $this->post('/submit');
        
        $response->assertSessionHasErrors(['title', 'url', 'description']);
    }

    /** @test */
    public function testLinkIsNotCreatedWithAnInvalidUrl() 
    {
        $this->withoutExceptionHandling();

        $cases = ['//invalid-url.com', '/invalid-url', 'foo.com', 'http:/mandanga'];

        foreach ($cases as $case) {
            try {
                $response = $this->post('/submit', [
                    'title' => 'Example Title',
                    'url' => $case,
                    'description' => 'Example description',
                ]);
            } catch (ValidationException $e) {
                $this->assertEquals(
                    'The url format is invalid.',
                    $e->validator->errors()->first('url')
                );
                continue;
            }

            $this->fail("The URL $case passed validation when it should have failed.");
        }
    }
    
    /** @test */
    public function testMaxLengthFailsWhenTooLong()
    {
        $this->withoutExceptionHandling();

        $title = str_repeat('a', 256);
        $description = str_repeat('a', 256);
        $url = 'http://';
        $url .= str_repeat('a', 256 - strlen($url));

        try {
            $this->post('/submit', compact('title', 'url', 'description'));
        } catch(ValidationException $e) {
            $this->assertEquals(
                'The title may not be greater than 255 characters.',
                $e->validator->errors()->first('title')
            );

            $this->assertEquals(
                'The url may not be greater than 255 characters.',
                $e->validator->errors()->first('url')
            );

            $this->assertEquals(
                'The description may not be greater than 255 characters.',
                $e->validator->errors()->first('description')
            );

            return;
        }

        $this->fail('Max length should trigger a ValidationException');
    }


    /** @test */
    public function testMaxLengthSucceedsWhenUnderMax() 
    {
        $url = 'http://';
        $url .= str_repeat('a', 255 - strlen($url));

        $data = [
            'title' => str_repeat('a', 255),
            'url' => $url,
            'description' => str_repeat('a', 255),
        ];

        $this->post('/submit', $data);

        $this->assertDatabaseHas('links', $data);
    }
}
