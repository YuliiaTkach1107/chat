<?php
namespace App\Http\Controllers;

use App\Models\UserPreference;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonnalisationController extends Controller
{
    public function index()
{
    $preferences = auth()->user()->preferences ?? null;
    return Inertia::render('Personnalisation/Personnalisation', [
        'preferences' => $preferences
    ]);
}

public function update(Request $request)
{
    $user = auth()->user();
    $preferences = $user->preferences ?? $user->preferences()->create([]);
    
    $tab = $request->input('tab');
    $value = $request->input('value');

    $preferences->$tab = $value;
    $preferences->save();

    return redirect()->back()->with('success', 'Vos modifications ont été enregistrées !');
}

}
?>
