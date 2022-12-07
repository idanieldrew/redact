<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Module\Category\Models\Category;
use Module\Post\Models\Post;
use Module\Role\Models\Permission;
use Module\Role\Models\Role;
use Module\User\Models\User;

class CustomTestCase extends TestCase
{
    public function CreateUser($type = 'writer', $email = 'test@test.com', bool $special_role = false): array
    {
        // Create role
        $this->createRole($special_role);
        // Find it
        $role = Role::query()->where('name', $type)->firstOrFail();
        // Create new user with type admin
        $user = User::factory(['email' => $email ?? $this->faker->email])->raw();

        $user = $role->users()->create($user);

//        $user->assignRole($type);
        // actingAs
        Sanctum::actingAs($user);
        return [$user, $role->id];
    }

    private function createRole(bool $special = false)
    {
        $role1 = Role::create(['name' => 'writer']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'super']);

        $p1 = Permission::create(['name' => 'view-users']);
        $p2 = Permission::create(['name' => 'create-post']);
        $p3 = Permission::create(['name' => 'create-category']);
        $p4 = Permission::create(['name' => 'create-plan']);

        $role1->givePermissionTo($p2);
        $special ?
            $role2->givePermissionTo($p1, $p2, $p3, $p4)
            :
            $role2->givePermissionTo($p1, $p2, $p3);

        $role3->givePermissionTo($p1, $p2, $p3, $p4);
    }

    protected function storePost($role = 'writer', $attachments = false, $number = 1, $title = null, $details = null, $category = null, $mail = null): array
    {
        $img = 'banner.png';
        $extension = '.png';
        $titles = [];

        //Create user and category
        $this->CreateUser($role, $mail);
        $categories = Category::factory()->create(['user_id' => auth()->user(), 'slug' => $category ?? $this->faker->slug]);

        Storage::fake('local');

        $attachments = $attachments ?
            [
                UploadedFile::fake()->create("video.mp4", "280000000", "mp4"),
                uploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ] :
            null;

        for ($i = 0; $i < $number; $i++) {
            $this->post(route('post.store'), [
                'title' => $titles[$i] = $title ?? $this->faker->name,
                'details' => $details ?? $this->faker->sentence,
                'description' => $this->faker->paragraph,
                'banner' => UploadedFile::fake()->image($img),
                'category' => [$categories->slug],
                'tag' => ['tag_1'],
                'attachment' => $attachments
            ])
                ->assertValid()
                ->assertCreated();
        }

        return array($titles, $extension);
    }

    protected function CreateComment()
    {
        $this->storePost();
        return Post::first();
    }
}
