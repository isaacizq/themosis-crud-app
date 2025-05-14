<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Themosis\Support\Facades\View;
use Themosis\Support\Facades\User;
use Themosis\Support\Facades\Auth;

class PersonController extends Controller
{
    /**
     * Constructor - Requiere autenticación para todas las acciones
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage_options');
    }
    
    /**
     * Muestra la lista de registros
     */
    public function index()
    {
        $persons = Person::all();
        return View::make('persons.index', compact('persons'));
    }
    
    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        return View::make('persons.create');
    }
    
    /**
     * Almacena un nuevo registro
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:persons',
            'fecha_nacimiento' => 'required|date',
        ]);
        
        // Validación adicional para el RUT chileno
        if (!Person::validarRut($request->rut)) {
            return back()->withErrors(['rut' => 'El RUT ingresado no es válido'])->withInput();
        }
        
        Person::create($request->all());
        
        return redirect()->route('person.index')
            ->with('success', 'Registro creado exitosamente.');
    }
    
    /**
     * Muestra un registro específico
     */
    public function show(Person $person)
    {
        return View::make('persons.show', compact('person'));
    }
    
    /**
     * Muestra el formulario de edición
     */
    public function edit(Person $person)
    {
        return View::make('persons.edit', compact('person'));
    }
    
    /**
     * Actualiza un registro específico
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:persons,rut,'.$person->id,
            'fecha_nacimiento' => 'required|date',
        ]);
        
        // Validación adicional para el RUT chileno
        if (!Person::validarRut($request->rut)) {
            return back()->withErrors(['rut' => 'El RUT ingresado no es válido'])->withInput();
        }
        
        $person->update($request->all());
        
        return redirect()->route('person.index')
            ->with('success', 'Registro actualizado exitosamente');
    }
    
    /**
     * Elimina un registro
     */
    public function destroy(Person $person)
    {
        $person->delete();
        
        return redirect()->route('person.index')
            ->with('success', 'Registro eliminado exitosamente');
    }
}