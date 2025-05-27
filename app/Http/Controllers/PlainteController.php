<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlainteController extends Controller
{
    /**
     * Afficher la liste des plaintes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plaintes = Plainte::with('user')->get();
        return view('admin.a_cours', compact('plaintes'));
    }

    /**
     * Afficher les plaintes en cours
     *
     * @return \Illuminate\Http\Response
     */
    public function enCours()
    {
        $plaintes = Plainte::where('statut', 'en_cours')->with('user')->get();
        $nb_plaintes_en_cours = $plaintes->count();
        return view('admin.a_cours', compact('plaintes', 'nb_plaintes_en_cours'));
    }

    /**
     * Afficher les plaintes terminées
     *
     * @return \Illuminate\Http\Response
     */
    public function terminees()
    {
        $plaintes = Plainte::where('statut', 'terminee')->with('user')->get();
        $nb_plaintes_terminee = $plaintes->count();
        return view('admin.a_terminee', compact('plaintes', 'nb_plaintes_terminee'));
    }

    /**
     * Afficher les plaintes refusées
     *
     * @return \Illuminate\Http\Response
     */
    public function refusees()
    {
        $plaintes = Plainte::where('statut', 'refusee')->with('user')->get();
        $nb_plaintes_refusee = $plaintes->count();
        return view('admin.a_refusee', compact('plaintes', 'nb_plaintes_refusee'));
    }

    /**
     * Afficher les plaintes de l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function mesPlaintes()
    {
        $nb_plaintes = Plainte::where('user_id', Auth::user()->id)->count();
        $nb_plaintes_en_cours = Plainte::where('user_id', Auth::user()->id)->where('statut', 'en_cours')->count();
        $nb_plaintes_terminee = Plainte::where('user_id', Auth::user()->id)->where('statut', 'terminee')->count();
        $nb_plaintes_refusee = Plainte::where('user_id', Auth::user()->id)->where('statut', 'refusee')->count();
        $user = Auth::user();
        return view('user.users', compact('user', 'nb_plaintes', 'nb_plaintes_en_cours', 'nb_plaintes_terminee', 'nb_plaintes_refusee'));
    }

    /**
     * Afficher les plaintes en cours de l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function mesPlaintesEnCours()
    {
        $plaintes = Auth::user()->plaintes()->where('statut', 'en_cours')->get();
        $nb_plaintes_en_cours = $plaintes->count();
        return view('user.p_cours', compact('plaintes', 'nb_plaintes_en_cours'));
    }

    /**
     * Afficher les plaintes terminées de l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function mesPlaintesTerminees()
    {
        $plaintes = Auth::user()->plaintes()->where('statut', 'terminee')->get();
        $nb_plaintes_terminee = $plaintes->count();
        return view('user.p_terminee', compact('plaintes', 'nb_plaintes_terminee'));
    }

    /**
     * Afficher les plaintes refusées de l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function mesPlaintesRefusees()
    {
        $plaintes = Auth::user()->plaintes()->where('statut', 'refusee')->get();
        $nb_plaintes_refusee = $plaintes->count();
        return view('user.p_refusee', compact('plaintes', 'nb_plaintes_refusee'));
    }

    /**
     * Afficher le formulaire de création d'une plainte
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create_plainte');
    }

    /**
     * Enregistrer une nouvelle plainte
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'piece_jointe' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pieceJointePath = null;
        if ($request->hasFile('piece_jointe')) {
            $pieceJointePath = $request->file('piece_jointe')->store('pieces_jointes', 'public');
        }

        $plainte = Plainte::create([
            'user_id' => Auth::id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'piece_jointe' => $pieceJointePath,
            'date' => now()->toDateString(),
            'heure' => now()->toTimeString(),
        ]);

        return redirect()->route('plainte_en_cours')->with('success', 'Plainte soumise avec succès');
    }

    /**
     * Afficher les détails d'une plainte spécifique
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plainte = Plainte::with('user')->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'plainte' => $plainte,
                'date_formatee' => \Carbon\Carbon::parse($plainte->date)->locale('fr_FR')->isoFormat('DD/MM/YYYY'),
                'heure_formatee' => \Carbon\Carbon::parse($plainte->heure)->locale('fr_FR')->isoFormat('H:mm'),
                'date_creation' => \Carbon\Carbon::parse($plainte->created_at)->locale('fr_FR')->isoFormat('DD/MM/YYYY à H:mm')
            ]);
        }
        
        return view('user.show_plainte', compact('plainte'));
    }

    /**
     * Afficher le formulaire de réponse à une plainte (pour admin)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repondre($id)
    {
        $plainte = Plainte::with('user')->findOrFail($id);
        return view('admin.repondre', compact('plainte'));
    }

    /**
     * Mettre à jour la réponse à une plainte (pour admin)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateReponse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reponse' => 'required|string',
            'statut' => 'required|in:terminee,refusee',
            'motif_refus' => 'required_if:statut,refusee|nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $plainte = Plainte::findOrFail($id);
        $plainte->update([
            'reponse' => $request->reponse,
            'statut' => $request->statut,
            'motif_refus' => $request->motif_refus,
            'notification' => true,
        ]);

        if ($request->statut == 'terminee') {
            return redirect()->route('admin_plainte_terminee')->with('success', 'Plainte traitée avec succès');
        } else {
            return redirect()->route('admin_plainte_refusee')->with('success', 'Plainte refusée avec succès');
        }
    }

    /**
     * Marquer une notification comme lue
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function marquerCommeLu($id)
    {
        $plainte = Plainte::findOrFail($id);
        $plainte->update([
            'notification' => false,
        ]);

        return redirect()->back()->with('success', 'Notification marquée comme lue');
    }

    /**
     * Supprimer une plainte
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plainte = Plainte::findOrFail($id);
        
        // Supprimer la pièce jointe si elle existe
        if ($plainte->piece_jointe) {
            Storage::disk('public')->delete($plainte->piece_jointe);
        }
        
        $plainte->delete();

        return redirect()->back()->with('success', 'Plainte supprimée avec succès');
    }
}
