<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index() 
    {
    }

    public function create() 
    {
         // Cette méthode afficher la vue pour créer un nouveau produit. 

        $categories = Category::all(); // Récupère les catégories
        $brands = Brand::all(); // Récupère les catégories

        return view('products.create', compact('categories', 'brands'));

    }

    public function store(ProductStoreRequest $request) 
    {
        // Cette méthode traite la soumission du formulaire (dont la vue a été préparée avec create) pour créer une nouvelle ressource. Elle valide les données envoyées et les enregistre dans la BDD. On peut faire un dd($request); pour la tester

        // Vérifie si une nouvelle marque a été saisie
        if (empty($request->brand_id) && $request->has('new_brand') && !empty($request->new_brand)) {
        // Créer une nouvelle marque avec description et logo
            $brandData = [
                'name' => $request->new_brand,
                'description' => $request->new_brand_description,
            ];

            // Gestion du logo (si un fichier est téléchargé)
            if ($request->hasFile('new_brand_logo')) {
                $logoPath = $request->file('new_brand_logo')->store('logos', 'public'); // Chemin d'enregistrement
                $brandData['logo'] = $logoPath;
            }

            // Créer la marque dans la base de données
            $brand = Brand::create($brandData);

            $brand_id = $brand->id;  // Récupère l'ID de la nouvelle marque
        } else if (!empty($request->brand_id)) {
            // Utiliser la marque existante
            $brand_id = $request->brand_id;
        } else {
             // Si aucune marque n'est sélectionnée, lance une exception ou gère l'erreur
            // Par exemple, tu peux rediriger avec un message d'erreur
            return back()->withErrors(['brand_id' => 'Veuillez sélectionner une marque ou en ajouter une nouvelle.']);
        }

        // Gestion de l'image (si un fichier est téléchargé)
        if ($request->hasFile('image')) {
            $validatedImage = $request->file('image')->isValid(); // Vérifie si l'upload est valide

            if($validatedImage) {
                $imagePath = $request->file('image')->store('images', 'public'); // Stocke l'image dans le dossier 'public/products'
            }
        }
        
         // Créer le produit principal
         $product = Product::create([
            'slug' => Str::of($request->slug)->slug('-'),
            'name' => $request->name,
            'description' => $request->description,
            'alcohol_degree' => $request->alcohol_degree,
            'category_id' => $request->category_id,
            'brand_id' => $brand_id, // Utiliser l'id de la marque (existante ou nouvelle)
            'image' => $imagePath,// A la base c'était : $request->image
        ]);

         // Créer les variantes associées au produit
         $variantsData = []; 
         foreach ($request->variants as $variant) {
             $variantsData[] = [
                'slug' => $variant['slug'],
                'volume' => $variant['volume'],
                'stock_quantity' => $variant['stock_quantity'],
                'price_without_tax' => $variant['price_without_tax'],
                'tax_amount' => $variant['tax_amount'],
                'available' => $variant['available'],
                'product_id' => $product->id, // Associer chaque variante au produit
             ];
         }
 
         // Insérer les variantes
         $product->productVariants()->createMany($variantsData);
 
         // Rediriger avec un message de succès sur la page Admin show
         return redirect()->route('admin.show')->with('success', 'Produit et variantes créés avec succès!');
    }

    public function show(Product $product) 
    {
        // // Cette méthode récupère l'objet Product pour l'afficher. On peut faire un dd($product); pour la tester 

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
