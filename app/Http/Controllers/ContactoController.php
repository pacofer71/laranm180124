<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function pintarFormulario(){
        return view('contactoform.formulario');
    }
    public function procesarFormulario(Request $request){
        $request->validate([
            'nombre'=>['required', 'string', 'min:5'],
            'email'=>['required', 'email'],
            'contenido'=>['required', 'string', 'min:10'],
        ]);

        try{
            Mail::to("admin@correo.es")
            ->send(new ContactoMailable(ucwords($request->nombre), $request->email, ucfirst($request->contenido)));
            return redirect()->route('home')->with('info', 'Correo enviado, gracias por sus comentarios');
        }catch(\Exception $ex){
            //dd("Error: ".$ex->getMessage());
            return redirect()->route('home')->with('info', 'No se pudo enviar el correo, intentelo más tarde');
        }

    }
}
