<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CompleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($applicant->load(['churchInfo', 'healthInfo', 'criminalInfo', 'recommendationInfo', 'socialInfo']));
        return Inertia::render('Apply/Complete');
    }
}