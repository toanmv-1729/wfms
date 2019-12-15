<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\SampleDescriptionRepository;

class SampleDescriptionController extends Controller
{
    protected $projectRepository;
    protected $sampleDescriptionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->sampleDescriptionRepository = $sampleDescriptionRepository;
    }

    public function index($slug)
    {
        //
    }
}
