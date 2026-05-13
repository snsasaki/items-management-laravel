<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $sort = $request->query('sort');
        // $keyword = $request->input('keyword'); 何の違い

        $query = Item::query();

        $query->when($keyword, function ($query, $keyword) {
            return $query->where('name', "LIKE", "%$keyword%");
        });

        $query->when($sort == 'name', function ($query) {
            return $query->orderBy('name', 'asc');
        });

        $items = $query->latest()->get();

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $item = Item::create($request->validated());

        return response()->json([
            'message' => '備品を作成しました。',
            'data' => new ItemResource($item),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->validated());

        return response()->json([
            'message' => '備品情報を更新しました。',
            'data' => new ItemResource($item),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => '備品情報を削除しました。'
        ], 204);
    }
}
