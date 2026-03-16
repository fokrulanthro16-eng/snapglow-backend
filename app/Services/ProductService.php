<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list()
    {
        return $this->productRepository->getAll();
    }

    public function show($id)
    {
        return $this->productRepository->find($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        return $this->productRepository->create($data);
    }

    public function update($request, $id)
    {
        $product = $this->productRepository->find($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
