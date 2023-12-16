<?php

namespace App\Services\ContactusServices;

use App\Services\ContactusServices\Contracts\ContactusContract;
use App\Http\Controllers\Controller;
use App\Models\Pages\Contactus;
use Illuminate\Http\Request;

class ContactusService extends Controller implements ContactusContract
{
    private $ProductRoutesModel;
    protected Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->ProductRoutesModel = new Contactus();
    }
    
    public function dataFetch()
    {
        return $this->ProductRoutesModel->searchByLike($this->request);
    }
}