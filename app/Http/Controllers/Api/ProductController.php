<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::select('SELECT * FROM products ORDER BY id DESC');

        return response()->json([
            'status' => 200,
            'message' => 'Productos listados correctamente',
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = DB::select('SELECT * FROM products WHERE id = ?', [$id]);

        if (count($product) === 0) {
            return response()->json([
                'status' => 100,
                'message' => 'Producto no encontrado',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Producto encontrado',
            'data' => $product[0]
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->input('name') || !$request->input('price')) {
            return response()->json([
                'status' => 100,
                'message' => 'Los campos name y price son obligatorios',
                'data' => null
            ]);
        }

        try {
            DB::insert(
                'INSERT INTO products (name, price, description, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())',
                [
                    $request->input('name'),
                    $request->input('price'),
                    $request->input('description')
                ]
            );

            $id = DB::getPdo()->lastInsertId();
            $product = DB::select('SELECT * FROM products WHERE id = ?', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Producto creado correctamente',
                'data' => $product[0]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 100,
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$request->input('name') || !$request->input('price')) {
            return response()->json([
                'status' => 100,
                'message' => 'Los campos name y price son obligatorios',
                'data' => null
            ]);
        }

        try {
            $affected = DB::update(
                'UPDATE products SET name = ?, price = ?, description = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->input('name'),
                    $request->input('price'),
                    $request->input('description'),
                    $id
                ]
            );

            if ($affected === 0) {
                return response()->json([
                    'status' => 100,
                    'message' => 'Producto no encontrado para actualizar',
                    'data' => null
                ]);
            }

            $product = DB::select('SELECT * FROM products WHERE id = ?', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Producto actualizado correctamente',
                'data' => $product[0]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 100,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $affected = DB::delete('DELETE FROM products WHERE id = ?', [$id]);

            if ($affected === 0) {
                return response()->json([
                    'status' => 100,
                    'message' => 'Producto no encontrado para eliminar',
                    'data' => null
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Producto eliminado correctamente',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 100,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ]);
        }
    }
}
