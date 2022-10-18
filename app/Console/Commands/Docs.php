<?php

namespace App\Console\Commands;

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
            'url' => 'http://127.0.0.1:8000',
            'title' => 'Our Awesome API',
            'description' => 'Generate API Document Using Lovely PHP.',
        ]);

        $api->post('transactions/{id}', function (Request $request) {

            //  Define Request.
            $request->title('Show transaction.');
            $request->version("v1"); // Optional

            $request->parameters([
                'token' => 'required',
                'transaction_id' => 'required',
            ]);

            // Define Response.
            $success = (new Response())
                ->title('Success')
                ->code(200)
                ->body([
                    'id' => 'numeric',
                    'status' => 'PAID | UNPAID',
                    'created_at' => 'timestamp',
                ]);

            // Assings Reaponses to the Request.
            $request->response($success);
        });
        return 0;
    }
}
