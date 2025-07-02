<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        //Iniciamos las vista inicioPagina de la pagina
        return view('InicioPagina');
    }

    
    // iniciar la vista en iniciarSesion
    
    public function inicioSesion()
    {
        return view('iniciarSesion');
    }

    // iniciar la vista registro paso 1

    public function registroPaso1(){
        return view('RegistroPasoOne');
    }
    
}
