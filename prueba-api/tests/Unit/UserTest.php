<?php

namespace Tests\Unit;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @return void
     */
    public function test_user_can_be_created()
    {

        $this->withoutExceptionHandling();
          $this->withoutMiddleware();
        $response = $this->post('api/register', [
            'name' => 'John Doe',
            'email' => 'mail@mail.com',
            'age' => 20,
            'address' => '123 Main Street',
        ]);
        $response->assertOk();
        $this->assertCount(1, User::all());

        $user = User::first();
        $this->assertEquals('mail@mail.com', $user->email);
    }

    /**
     * @return void
     */
    /** @test */
    public function list_of_users_can_be_retrieved(): void
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $response = $this->get('api/users',);
        $response->assertOk();
    }

    public function test_user_can_be_retrieved_by_id()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();


        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'mail3@mail.com',
            'age' => 20,
            'address' => '123 Main Street',
        ]);


        $response = $this->get('api/users/show/' . $user->id);

        $response->assertOk();

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'age' => $user->age,
            'address' => $user->address,
        ]);
    }

    /** test **/
    public function test_user_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'mail2@mail.com',
            'age' => 20,
            'address' => '123 Main Street',
        ]);

        $response = $this->put('api/users/' . $user->id, [
            'name' => 'John Doe',
            'email' => 'mail@mail.com',
            'age' => 21,
            'address' => '122 Main Street',
        ]);
        $response->assertOk();

        $user->refresh();

        $this->assertEquals('mail2@mail.com', $user->email);
    }

    public function test_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'mail4@mail.com',
            'age' => 20,
            'address' => '123 Main Street',
        ]);

        $response = $this->delete('api/users/' . $user->id);

        $response->assertStatus(204);

//        $this->assertDeleted($user);
    }

    public function test_user_can_login()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();


        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'mail25@mail.com',
            'password' => bcrypt('password'), // Asegúrate de encriptar la contraseña
            'age' => 20,
            'address' => '123 Main Street',
        ]);

        $response = $this->post('api/login', [
            'email' => 'mail25@mail.com',
            'password' => 'password',
        ]);

        $response->assertOk();

        $this->assertAuthenticatedAs($user);
    }
}
