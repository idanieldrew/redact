<?php

namespace Module\Share\Commands;

use Illuminate\Console\Command;
use Mvaliolahi\SibDoc\Schemas\Request\Request;
use Mvaliolahi\SibDoc\Schemas\Response\Response;
use Mvaliolahi\SibDoc\SibDoc;

class Docs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate documents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new SibDoc([
            'url' => 'http://127.0.0.1',
            'title' => 'Our Awesome API',
            'description' => 'Generate API Document Using Lovely PHP.',
            'background_color' => '#191970'
        ]);

        $api->group('api/users', function (SibDoc $user) {
            $user->get('/', function (Request $request) {
                $request->title('Show all users');
                $request->description('You must have a permission.');
                $request->version(1);
                $request->headers([
                    'Authorization ' => 'Bearer {token}'
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Show all users')
                    ->body([
                        'name' => 'string',
                        'email' => 'string',
                    ]);

                // Assings Reaponses to the Request.
                $request->response($success);
            });
            $user->get('/{user}', function (Request $request) {
                $request->title('Show user');
                $request->description('You must have a permission,or you are {user}');
                $request->version(1);
                $request->headers([
                    'Authorization ' => 'Bearer {token}'
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Show user')
                    ->body([
                        'name' => 'string',
                        'email' => 'string',
                    ]);

                // Assings Reaponses to the Request.
                $request->response($success);
            });
            $user->patch('/{user}', function (Request $request) {
                $request->title('Update user');
                $request->description('You must have a permission,or you are {user}');
                $request->version(1);
                $request->headers([
                    'Authorization ' => 'Bearer {token}'
                ]);

                $request->parameters([
                    'name' => 'nullable|max:32|min:3',
                    'email' => 'nullable|unique:users|min:10',
                    'permission' => 'nullable|exists:permissions,name',
                    'role' => 'nullable|exists:roles,name',
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(204)
                    ->description('Successfully update user')
                    ->body();
                $request->response($success);
            });
            $user->delete('/{user}', function (Request $request) {
                $request->title('Destroy user');
                $request->description('You must have a permission,or you are {user}');
                $request->version(1);
                $request->headers([
                    'Authorization ' => 'Bearer {token}'
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(204)
                    ->description('Successfully destroy user')
                    ->body();
                $request->response($success);
            });
        });

        $api->group('api/auth', function (SibDoc $auth) {
            $auth->post('login', function (Request $request) {
                $request->title('Login');
                $request->version(1);
                $request->parameters([
                    'email' => 'required|email|string',
                    'password' => 'required|min:8'
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Successfully login')
                    ->body([
                        'token' => 'string',
                        'user' => [
                            'name' => 'string',
                            'email' => 'string'
                        ],
                    ]);

                // Assings Reaponses to the Request.
                $request->response($success);
            });
            $auth->post('register', function (Request $request) {
                $request->title('Register');
                $request->version(1);
                $request->parameters([
                    'name' => 'required|string|min:3',
                    'email' => 'required|email|string',
                    'password' => 'required|min:8'
                ]);
                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Successfully register')
                    ->body([
                        'token' => 'string',
                        'user' => [
                            'name' => 'string',
                            'email' => 'string'
                        ],
                    ]);

                // Assings Reaponses to the Request.
                $request->response($success);
            });
        });

        $api->group('api/posts', function (SibDoc $user) {
            $user->get('/', function (Request $request) {
                $request->title('Show all posts');
                $request->version(1);

                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Show all posts');

                // Assings Reaponses to the Request.
                $request->response($success);
            });
            $user->get('/', function (Request $request) {
                $request->title('Show one post with similar post with it');
                $request->version(1);

                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Show "name" post');

                // Assings Reaponses to the Request.
                $request->response($success);
            });

            $user->get('search?=keyword=', function (Request $request) {
                $request->title('Search post');
                $request->version(1);
                $request->parameters('keyword');

                // Define Response.
                $success = (new Response())
                    ->title('Success')
                    ->code(200)
                    ->description('Show post or posts')
                    ->body([
                        'title' => 'string',
                        'slug' => 'string',
                        'details' => 'string',
                        'description' => 'string',
                        'banner' => 'string',
                        'user' => [
                            'name' => 'string',
                            'email' => 'string',
                            'phone' => 'string',
                        ],
                        'tags' => [
                            'name' => 'string'
                        ],
                        'media' => [
                            'type' => 'string',
                            'files' => 'string',
                            'name' => 'string',
                            'is-private' => 'bool'
                        ],
                        'categories' => [
                            'name' => 'string',
                            'slug' => 'string',
                        ],
                        'comments' => [
                            'body' => 'string',
                        ],
                        'blue_tick' => 'bool',
                        'published' => 'bool',
                        'created_at' => 'timestamp'
                    ]);

                $request->response($success);
            });
        });

        $api->saveTo('/docs/api');
        return 0;
    }
}
