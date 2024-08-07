<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Documentação da API",
 *     version="1.0.0"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class DocController extends Controller
{
   /**
    * @OA\Get(
    *     path="/api/docs/{id}",
    *     summary="Obter um documento específico pelo ID",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(type="integer"),
    *         description="O ID do documento"
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Documento encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="string"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Documento não encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="string"),
    *             @OA\Property(property="message", type="string"),
    *             @OA\Property(property="data", type="array", @OA\Items())
    *         )
    *     )
    * )
    */
   public function show($id, Doc $docs)
   {
      $documento = $docs->find($id);

      if ($documento) {
         $dados = [
            'success' => 'true',
            'data' => $documento,
         ];
         return response()->json($dados, 200);
      } else {
         $dados = [
            'success' => 'false',
            'message' => 'Documento não encontrado',
            'data' => [],
         ];
         return response()->json($dados, 404);
      }
   }

   /**
    * @OA\Get(
    *     path="/api/docs",
    *     summary="Obter a lista de todos os documentos",
    *     security={{"bearerAuth":{}}},
    *     @OA\Response(
    *         response=200,
    *         description="Documentos encontrados",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="string"),
    *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Nenhum documento encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="string"),
    *             @OA\Property(property="message", type="string"),
    *             @OA\Property(property="data", type="array", @OA\Items())
    *         )
    *     )
    * )
    */
   public function index(Doc $docs)
   {
      $documentos = $docs->all();

      if ($documentos) {
         $dados = [
            'success' => 'true',
            'data' => $documentos,
         ];
         return response()->json($dados, 200);
      } else {
         $dados = [
            'success' => 'false',
            'message' => 'Nenhum documento encontrado',
            'data' => [],
         ];
         return response()->json($dados, 404);
      }
   }
}
