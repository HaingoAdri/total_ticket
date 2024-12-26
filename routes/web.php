<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PrioriteController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\HistoriqueActionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'go_login'])->name('login');
Route::get('/register', [AdminController::class, 'go_register'])->name('register');
Route::post('/insert_admin', [AdminController::class, 'insert_admin'])->name('insert_user');
Route::post('/connexion', [AdminController::class, 'get_admin'])->name('connexion');
// Lost password 
Route::get('/lost_pass', [AdminController::class, 'get_ModifPage'])->name('lost_pass');
Route::post('/next_lost_pass', [AdminController::class, 'get_Next_Page'])->name('gest_next_page');
Route::post('/input_modif_pass', [AdminController::class, 'modifier_password'])->name('modifier_password');

Route::get('/acceuil_admin', [PageController::class, 'index'])->name('acceuil_admin');

// Routes pour les catégories
Route::get('/categories', [CategorieController::class, 'index'])->name('gestion_categorie');
Route::post('/categories', [CategorieController::class, 'store'])->name('categorie_store');
Route::get('/categories/{id}', [CategorieController::class, 'show']);
Route::put('/categories/{id}', [CategorieController::class, 'update']); 
Route::delete('/categories/{id}', [CategorieController::class, 'destroy'])->name('categorie_destroy'); 

// Routes pour les priorités
Route::get('/priorites', [PrioriteController::class, 'index']);
Route::post('/priorites', [PrioriteController::class, 'store'])->name('priorite_poste');
Route::get('/priorites/{id}', [PrioriteController::class, 'show']);
Route::put('/priorites/{id}', [PrioriteController::class, 'update']);
Route::delete('/priorites/{id}', [PrioriteController::class, 'destroy'])->name('priorite_destroy');

// Routes pour les postes
Route::get('/postes', [PosteController::class, 'index']); // Lister tous les postes
Route::post('/postes', [PosteController::class, 'store']); // Créer un poste
Route::get('/postes/{id}', [PosteController::class, 'show']); // Afficher un poste spécifique
Route::put('/postes/{id}', [PosteController::class, 'update']); // Mettre à jour un poste
Route::delete('/postes/{id}', [PosteController::class, 'destroy']); // Supprimer un poste

// Routes pour les états
Route::get('/etats', [EtatController::class, 'index']); // Lister tous les états
Route::post('/etats', [EtatController::class, 'store']); // Créer un état
Route::get('/etats/{id}', [EtatController::class, 'show']); // Afficher un état spécifique
Route::put('/etats/{id}', [EtatController::class, 'update']); // Mettre à jour un état
Route::delete('/etats/{id}', [EtatController::class, 'destroy']); // Supprimer un état

// Routes pour les tickets
Route::get('/tickets/{id}', [TicketController::class, 'index'])->name('get_ticket');
Route::post('/tickets', [TicketController::class, 'store'])->name('store_ticket'); // Créer un ticket
Route::get('/assignation', [TicketController::class, 'assignation'])->name('assignation');
Route::post('/assigner-technicien', [TicketController::class, 'assigner_technicien'])->name('assigner_technicien');
Route::get('/suivi/user/{id}', [TicketController::class, 'suivi_client'])->name('suivi_user');
Route::get('/rapport/user/{id}', [TicketController::class, 'rapport'])->name('rapport');
Route::get('/suivi/{id}', [TicketController::class, 'suivi'])->name('suivi');
Route::post('/ticket/update', [TicketController::class, 'update'])->name('ticket.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy']); // Supprimer un ticket

// Routes pour les notes des techniciens
Route::get('/notes', [NoteTechnicienController::class, 'index']); // Lister toutes les notes
Route::post('/notes', [NoteTechnicienController::class, 'store']); // Créer une note



// Routes pour les rapports des tickets
Route::get('/rapports', [RapportController::class, 'index']); // Lister tous les rapports
Route::post('/rapports', [RapportController::class, 'store'])->name('rapport.store');
Route::get('/rapports/{id}', [RapportController::class, 'show']); // Afficher un rapport spécifique
Route::put('/rapports/{id}', [RapportController::class, 'update']); // Mettre à jour un rapport
Route::delete('/rapports/{id}', [RapportController::class, 'destroy']); // Supprimer un rapport

// Routes pour l'historique des actions
Route::get('/historiques', [HistoriqueActionController::class, 'index']); // Lister tout l'historique
Route::post('/historiques', [HistoriqueActionController::class, 'store']); // Ajouter un historique
Route::get('/historiques/{id}', [HistoriqueActionController::class, 'show']); // Afficher un historique spécifique
Route::delete('/historiques/{id}', [HistoriqueActionController::class, 'destroy']); // Supprimer un historique
