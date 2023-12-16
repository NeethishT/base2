<?php

namespace App\Services\AboutusService;

use App\Services\AboutusServices\Contracts\AboutusContract;
use App\Http\Controllers\Controller;
use App\Models\Pages\Aboutus;
use Illuminate\Http\Request;

class AboutusService extends Controller implements AboutusContract 
{
    private $AboutusModel;
    protected Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->AboutusModel = new Aboutus();
    }
    
    public function index()
    {
        return $this->AboutusModel->searchByLike($this->request);
    }
}