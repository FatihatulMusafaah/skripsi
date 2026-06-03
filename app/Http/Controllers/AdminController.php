<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    function index()
    {
       return view('login');
    }

    function Admin()
    {
        return view('dashboard');
    }

    function karyawan()
    {
      return view('karyawan.dashboard');

    }

   public function owner()
{
    return view('owner.dashboard');
}
}