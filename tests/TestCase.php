<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Module\Category\Models\Category;
use Module\Role\Models\Permission;
use Module\Role\Models\Role;
use Module\User\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    public function CreateUser($type = 'writer'): array
    {
        // Create role
        $this->createRole();
        // Find it
        $role = Role::query()->where('name', $type)->firstOrFail();

        // Create new user with type admin
        $user = User::factory()->create();

        $user->assignRole($type);
        // actingAs
        Sanctum::actingAs($user);

        return [$user, $role->id];
    }

    private function createRole()
    {
        $role1 = Role::create(['name' => 'writer']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'super']);

        $p1 = Permission::create(['name' => 'view-users']);
        $p2 = Permission::create(['name' => 'create-post']);

        $role1->givePermissionTo($p2);
        $role2->givePermissionTo($p1, $p2);
        $role3->givePermissionTo($p1, $p2);
    }

    protected function storePost($role = 'writer', $attachments = false, $number = 1, $titles = null, $details = null): array
    {
        $img = 'banner.png';
        $extension = '.png';

        $this->WithoutEvents();

        //Create user and category
        $this->CreateUser($role);
        $categories = Category::factory()->create(['user_id' => auth()->user()]);

        Storage::fake('local');

        $attachments = $attachments ?
            [
                uploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png')
            ] :
            null;

        for ($i = 0; $i < $number; $i++) {
            $this->post(route('post.store', ['lang' => 'en']), [
                'title' => $title = $titles ?? $this->faker->name,
                'details' => $details ?? $this->faker->sentence,
                'description' => $this->faker->paragraph,
                'banner' => UploadedFile::fake()->image($img),
                'category' => [$categories->name],
                'tag' => ['tag_1'],
                'attachment' => $attachments
            ])
                ->assertValid()
                ->assertCreated();
        }

        return array($title, $extension);
    }
}
