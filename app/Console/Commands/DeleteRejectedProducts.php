<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class DeleteRejectedProducts extends Command
{

    protected $signature = 'products:delete-rejected';


    protected $description = 'Delete rejected products from the database';


    public function handle()
    {
        Product::where('status', 'rejected')->delete();

        $this->info('Rejected products have been deleted successfully.');
    }
}
