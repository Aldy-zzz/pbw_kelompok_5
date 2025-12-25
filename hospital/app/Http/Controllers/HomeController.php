<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Doctor::active()->get();
        return view('home.index', compact('doctors'));
    }

    public function services()
    {
        return view('home.services');
    }

    public function doctors()
    {
        $doctors = Doctor::active()->get();
        return view('home.doctors', compact('doctors'));
    }

    public function contact()
    {
        $doctors = Doctor::active()->get();
        return view('home.contact', compact('doctors'));
    }
}