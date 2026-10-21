<?php


namespace App\Http\Controllers;


// Agregar el modelo Asistente
use App\Models\Asistente;
// Agregar la clase Request para manejar las peticiones
use Illuminate\Http\Request;
// Agregar la clase Validator para validar los datos de la petición
use Illuminate\Support\Facades\Validator;


class AsistenteController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        // Recuperar todos los recursos
        $asistentes = Asistente::all();


        // Retornar los recursos recuperados
        $respuesta = [
            'asistentes' => $asistentes,
            'status' => 200,
        ];
        return response()->json($respuesta);
    }


    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'evento_id' => 'required|exists:eventos,id',
        ]);


        // Si la petición no contiene todos los datos necesarios, retornar un mensaje de error
        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }


        // Crear un nuevo recurso con los datos de la petición
        $asistente = Asistente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'evento_id' => $request->evento_id,
        ]);


        // Si el recurso no se pudo crear, retornar un mensaje de error
        if (!$asistente) {
            $respuesta = [
                'message' => 'Error al crear el asistente',
                'status' => 500, // Error interno del servidor
            ];
            return response()->json($respuesta, 500);
        }


        // Retornar el recurso creado
        $respuesta = [
            'asistente' => $asistente,
            'status' => 201,
        ];
        return response()->json($respuesta, 201);
    }


    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        // Recuperar el recurso especificado
        $asistente = Asistente::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }


        // Retornar el recurso recuperado
        $respuesta = [
            'asistente' => $asistente,
            'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }


    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Recuperar el recurso especificado
        $asistente = Asistente::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }


        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'evento_id' => 'required|exists:eventos,id',
        ]);


        // Si la petición no contiene todos los datos necesarios, retornar un mensaje de error
        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }


        // Actualizar el recurso especificado con los datos de la petición
        $asistente->nombre = $request->nombre;
        $asistente->email = $request->email;
        $asistente->telefono = $request->telefono;
        $asistente->evento_id = $request->evento_id;
        $asistente->save();


        // Retornar el recurso actualizado
        $respuesta = [
            'asistente' => $asistente,
            'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }


    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        // Recuperar el recurso especificado
        $asistente = Asistente::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }


        // Eliminar el recurso especificado
        $asistente->delete();


        // Retornar un mensaje de éxito
        $respuesta = [
            'message' => 'Asistente eliminado',
            'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }
}
