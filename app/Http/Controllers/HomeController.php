<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;

class HomeController extends BaseController
{
    public function home()
    {
        return $GLOBALS['user']->role == 'admin'
            ? redirect()->route('admin.home')
            : ($GLOBALS['user']->role == 'employee'
            ? redirect()->route('employee.home')
            : ($GLOBALS['user']->role == 'mis_office_personnel'
            ? redirect()->route('mis_office_personnel.home')
            : redirect()->route('supply_office_personnel.home') ));
    }
    
    public function admin()
    {
        return view('admin.home');
    } 
      
    public function employee()
    {
        
    }   

    public function MIS_Office()
    {

    }   

    public function Supply_Office()
    {

    }
}
