<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    private $productService;

    public function __construct(ProductServiceInterface $productService){
        $this -> productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render('Admin/Products/ListProducts', [
            'products' => $this -> productService -> productList(request()->input('key'))
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
       
        // abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render('Admin/Products/CreateProduct', [
            'categories' =>  Category::latest()->pluck('id','name')
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request){
        $this -> productService -> productAdd($request->validated());
        return redirect()->route('products-master.index')->with('success', "Product Created Successfully");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        // abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render('Admin/Products/EditProduct', [
            'categories' =>  Category::latest()->pluck('id','name'),
            'product' =>  Product::where('id', $id)->with(['productCategory','additionalImages'])->first()
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id){
        dd($request->all());
        $this -> productService -> productUpdate($request->validated(), Product::findOrFail($id));
        return redirect()->route('products-master.index')->with('success', "Products Updated");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        // abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this -> productService -> productRemove(Product::findOrFail($id));
        return redirect()->route('products-master.index')->with('success', 'Products Deleted');
    }

    public function removeAdditionalImage($product, $image){
        $this -> productService -> removeIndividualImage($product, $image);
        return redirect()->back();
    }

}
