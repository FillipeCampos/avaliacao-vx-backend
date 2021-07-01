<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductPersist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {product_name=VXProduct10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Product';

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
        $name = $this->argument('product_name');
//        if(empty($name)) {
//            $name = $this->ask('Product name:');
//        }
        $reference = $this->ask('Product reference:');
        $price = $this->ask('Product price:');
        $delivery_days = $this->ask('Product delivery_days:');

        $product = new Product();
        $product->name = $name;
        $product->reference = $reference;
        $product->price = $price;
        $product->delivery_days = $delivery_days;
        $product->save();

        $this->info('Product saved');

        return 0;
    }
}
