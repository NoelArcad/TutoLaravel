<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyFormRequest;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Option;




class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.properties.index", [
            "properties"=> Property::orderBy("created_at","desc")->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $property = new Property();
        $property -> fill([
            "surface"=> 40,
            "rooms"=> 3,
            "bedrooms"=> 1,
            "floor"=> 0, 
            "city"=> 'Calavi',
            'postal_code'=> 24000,
            'sold'=> false,
        ]);    
        return view("admin.properties.form", [
            'property' => $property, // Passer la variable $property à la vue
            'options' => Option::pluck('name','id'),
        ]);
    }



    public function edit(Property $property)
    {
        return view('admin.properties.form', [
            'property'=> $property,
            'options' => Option::pluck('name','id'),

        ]);
    }




    // Dans la fonction storeuse Intervention\Image\Facades\Image;

// Dans la fonction store
public function store(PropertyFormRequest $request)
{
    // Si un fichier image est téléchargé
    if ($request->hasFile('image')) {
        $image = $request->file('image');
    
        // Vérifier si le fichier est une image PNG, JPG ou GIF
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        $extension = $image->getClientOriginalExtension();
        if (in_array($extension, $allowedExtensions)) {
            // Le fichier est une image PNG, JPG, JPEG ou GIF valide
    
            // Charger l'image et obtenir ses dimensions
            list($width, $height) = getimagesize($image->getPathname());
    
            // Définir les nouvelles dimensions
            $newWidth = 272;
            $newHeight = 185;
    
            // Créer une image vide avec les nouvelles dimensions
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
    
            // Charger l'image source en fonction de son type
            switch ($extension) {
                case 'png':
                    $source = imagecreatefrompng($image->getPathname());
                    break;
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg($image->getPathname());
                    break;
                case 'gif':
                    $source = imagecreatefromgif($image->getPathname());
                    break;
            }
    
            // Redimensionner l'image source et la copier dans l'image vide
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
            // Enregistrer l'image redimensionnée
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = 'images/' . $imageName;
 
            switch ($extension) {
                case 'png':
                    imagepng($thumb, $imagePath);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($thumb, $imagePath);
                    break;
                case 'gif':
                    imagegif($thumb, $imagePath);
                    break;
            }
    
            // Libérer la mémoire
            imagedestroy($thumb);
            imagedestroy($source);
        }  else {
            // Le fichier n'est pas une image valide
            return redirect()->route('admin.property.index')->with('error', 'Le fichier sélectionné n\'est pas une image valide.');
        }
    } else {
        // Aucun fichier image n'est téléchargé, utiliser l'image par défaut
        $imageName = 'img1.jpeg';
    }

    // Enregistrer le nom du fichier image dans les données du bien
    $propertyData = $request->validated();
    $propertyData['image'] = $imageName;

    

    // Créer une nouvelle instance de Property avec les données et l'enregistrer dans la base de données
    Property::create($propertyData);

    // Rediriger vers la page d'index avec un message de succès
    return redirect()->route('admin.property.index')->with('success', 'Le bien a bien été créé.');
}

public function update(PropertyFormRequest $request, Property $property)
{
    // Si un fichier image est téléchargé
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // Vérifier si le fichier image est valide
        if ($image->isValid()) {
            // Le fichier est une image valide
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Chemin de stockage de l'image
            $imagePath = 'images/' . $imageName;

            
            // Redimensionner l'image avec GD
            list($width, $height) = getimagesize($image->getPathname());
            $newWidth = 272;
            $newHeight = 185;
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            
            // Charger l'image source en fonction de son type
            switch ($image->getClientOriginalExtension()) {
                case 'png':
                    $source = imagecreatefrompng($image->getPathname());
                    break;
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg($image->getPathname());
                    break;
                case 'gif':
                    $source = imagecreatefromgif($image->getPathname());
                    break;
            }

            // Redimensionner et copier l'image source dans l'image vide
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // Enregistrer l'image redimensionnée
            switch ($image->getClientOriginalExtension()) {
                case 'png':
                    imagepng($thumb, $imagePath);
                    break;
                case 'jpg':
                case 'jpeg':
                    imagejpeg($thumb, $imagePath);
                    break;
                case 'gif':
                    imagegif($thumb, $imagePath);
                    break;
            }

            // Mettre à jour l'attribut image avec le nouveau nom de fichier
            $property->image = $imageName;

            // Libérer la mémoire
            imagedestroy($thumb);
            imagedestroy($source);

        } else {
            // Le fichier n'est pas une image valide
            return redirect()->route('admin.property.index')->with('error', 'Le fichier sélectionné n\'est pas une image valide.');
        }
    }

    // Récupérer toutes les données validées du formulaire
    $propertyData = $request->validated();

    // Mettre à jour les autres attributs de la propriété
    unset($propertyData['image']); // Supprimer l'attribut image du tableau $propertyData
    $property->update($propertyData);

    // Rediriger vers la page d'index avec un message de succès
    return redirect()->route('admin.property.index')->with('success', 'Les informations du bien ont été mises à jour avec succès');
}

     
     
 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return to_route('admin.property.index') -> with('success', 'Le bien a été supprimé');

    }
}
