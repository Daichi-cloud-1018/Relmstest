<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $sort = $request->get('sort', 'id');

        [$column, $direction] = match ($sort) {
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            default => ['id', 'asc'],
        };

        $products = Product::when($keyword, function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })
            ->orderBy($column, $direction)
            ->paginate(6)
            ->appends(['sort' => $sort, 'q' => $keyword]);

        return view('index', compact('products', 'sort', 'keyword'));
    }

    public function detail(Product $product)
    {
        $seasons = Season::all();
        $selectedSeasons = $product->seasons->pluck('id')->toArray();
        return view('details', compact('product', 'seasons', 'selectedSeasons'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $path ?? $validated['image'] ?? null,
        ]);

        $product->seasons()->sync($validated['season']);

        return redirect()->route('products.index')->with('status', '登録しました');
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->fill([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? $product->image,
        ])->save();

        $product->seasons()->sync($validated['season']);

        return redirect()->route('products.index')->with('status', '更新しました');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('status', '削除しました');
    }
}
