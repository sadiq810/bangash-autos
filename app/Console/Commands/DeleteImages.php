<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $images = Storage::disk('uploads')->files();
        $products = Product::pluck('image');

        $imagess = [];
        foreach ($products as $product)
            $imagess = array_merge($imagess, $product);

        foreach ($images as $image)
            if (!in_array($image, $imagess))
                unlink(public_path('/uploads/thumbs/'.$image));
        $this->info('deleted....');
    }
}
